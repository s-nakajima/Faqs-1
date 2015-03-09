<?php
/**
 * Faqs Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * Faqs Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Controller
 */
class FaqsController extends FaqsAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Faqs.Faq',
		'Faqs.FaqOrder',
		'Categories.Category',
		'Comments.Comment',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Security' => array('validatePost' => false),
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('indexLatest', 'indexSetting', 'edit', 'delete'),
				'contentCreatable' => array('edit', 'delete'),
			),
		),
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token'
	);

/**
 * beforeFilter
 *
 * @return void
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('selectCategory');
	}

/**
 * index method
 *
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index() {
		if (! $this->viewVars['blockId']) {
			return;
		}
		$this->__initFaq();
	}

/**
 * selectCategory method
 *
 * @param int $frameId frames.id
 * @param int $categoryId categories.id
 * @return void
 */
	public function selectCategory($frameId = 0, $categoryId = null) {
		$results = $this->__getLatest($this->viewVars['blockId'], $categoryId);
		$this->renderJson($results);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param int $faqId faqs.id
 * @return void
 */
	public function view($frameId = 0, $faqId = 0) {
		if (! $this->viewVars['contentReadable']) {
			return;
		}

		$options = array(
			'conditions' => array(
				'Faq.id' => $faqId,
				'Faq.block_id' => $this->viewVars['blockId'],
			),
		);
		$faq = $this->Faq->find('first', $options);
		if (! empty($faq)) {
			$this->set('faq', $faq);
		}
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $faqId faqs.id
 * @param int $manageMode manage mode
 * @return void
 */
	public function edit($frameId = 0, $faqId = 0, $manageMode = 0) {
		$this->__initFaqEdit($faqId);
		$this->set('manageMode', $manageMode);
		if ($this->request->isGet()) {
			CakeSession::write('backUrl', $this->request->referer());
		}

		if ($this->request->isPost()) {
			if (isset($this->params['data']['delete'])) {
				$this->Faq->deleteFaq($faqId);
			} else {
				if (!$status = $this->__parseStatus()) {
					return;
				}

				$data = Hash::merge($this->data, array('Faq' =>
					array(
						'block_id' => $this->viewVars['blockId'],
						'status' => $status,
					)));

				if (!$faq = $this->Faq->getFaq($faqId, $this->viewVars['blockId'])) {
					$faq = $this->Faq->create(['key' => Security::hash('faq' . mt_rand() . microtime(), 'md5')]);
				}
				$data = Hash::merge($faq, $data);
				$this->Faq->saveFaq($data, $this->viewVars['blockId'], $this->viewVars['blockKey']);
				if (!$this->__handleValidationError($this->Faq->validationErrors)) {
					return;
				}
			}

			if (!$this->request->is('ajax')) {
				$backUrl = CakeSession::read('backUrl');
				CakeSession::delete('backUrl');
				$this->redirect($backUrl);
			}
		}
	}

/**
 * Parse content status from request
 *
 * @throws BadRequestException
 * @return mixed status on success, false on error
 */
	private function __parseStatus() {
		if ($matches = preg_grep('/^save_\d/', array_keys($this->data))) {
			list(, $status) = explode('_', array_shift($matches));
		} else {
			if ($this->request->is('ajax')) {
				$this->renderJson(
					['error' => ['validationErrors' => ['status' => __d('net_commons', 'Invalid request.')]]],
					__d('net_commons', 'Bad Request'), 400
				);
			} else {
				throw new BadRequestException(__d('net_commons', 'Bad Request'));
			}
			return false;
		}

		return $status;
	}

/**
 * Handle validation error
 *
 * @param array $errors validation errors
 * @return bool true on success, false on error
 */
	private function __handleValidationError($errors) {
		if ($errors) {
			$this->validationErrors = $errors;
			if ($this->request->is('ajax')) {
				$results = ['error' => ['validationErrors' => $errors]];
				$this->renderJson($results, __d('net_commons', 'Bad Request'), 400);
			}
			return false;
		}

		return true;
	}

/**
 * __getLatest method
 *
 * @param int $blockId blocks.id
 * @param int $categoryId selected category id
 * @return array
 */
	private function __getLatest($blockId, $categoryId = null) {
		$faqList = $this->Faq->getFaqList($blockId, $categoryId);
		$categoryOptions = $this->Category->getCategoryList($blockId);

		$results = array(
			'faqList' => $faqList,
			'categoryOptions' => $categoryOptions
		);
		return $results;
	}

/**
 * __initFaq method
 *
 * @return void
 */
	private function __initFaq() {
		$results = $this->__getLatest($this->viewVars['blockId']);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * __initFaqEdit method
 *
 * @param int $faqId faqs.id
 * @return void
 */
	private function __initFaqEdit($faqId = 0) {
		$results = $this->__getLatest($this->viewVars['blockId']);
		if (! $faq = $this->Faq->getFaq($faqId, $this->viewVars['blockId'])) {
			$faq = $this->Faq->create(['status' => '0']);
		}
		$comments = $this->Comment->getComments(
			array(
				'plugin_key' => 'faqs',
				'content_key' => isset($faq['Faq']['key']) ? $faq['Faq']['key'] : null,
			)
		);

		$results['faq'] = $faq;
		$results['comments'] = $comments;
		$results['contentStatus'] = $faq['Faq']['status'];
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}
}
