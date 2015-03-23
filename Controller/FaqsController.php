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
		/* 'NetCommons.NetCommonsBlock', */
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit'),
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
 * index method
 *
 * @param int $frameId frames.id
 * @param int $categoryId categories.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0, $categoryId = 0) {
		$this->set('categoryId', $categoryId);
		$this->__initFaq($categoryId);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param int $faqId faqs.id
 * @return void
 */
	public function view($frameId = 0, $faqId = 0) {
		$options = array(
			'conditions' => array(
				'Faq.id' => $faqId,
				'Faq.block_id' => $this->viewVars['blockId'],
			),
		);
		$faq = $this->Faq->find('first', $options);
		if (! $faq) {
			return;
		}
		$this->set('faq', $faq);
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $faqId faqs.id
 * @return void
 */
	public function edit($frameId = 0, $faqId = 0) {
		$this->__initFaqEdit($faqId);
		if ($this->request->isGet()) {
			CakeSession::write('backUrl', $this->request->referer());
		}

		if ($this->request->isPost()) {
			if (isset($this->data['delete'])) {
				$this->Faq->deleteFaq($faqId);
			} else {
				if (!$status = $this->NetCommonsWorkflow->parseStatus()) {
					return;
				}

				$data = Hash::merge($this->data, array('Faq' =>
					array(
						'block_id' => $this->viewVars['blockId'],
						'status' => $status,
					)));

				if (!$faq = $this->Faq->getFaq($faqId)) {
					$faq = $this->Faq->create(['key' => Security::hash('faq' . mt_rand() . microtime(), 'md5')]);
				}
				$data = Hash::merge($faq, $data);
				$data['Block']['key'] = $this->viewVars['blockKey'];
				$this->Faq->saveFaq($data);
				if (!$this->handleValidationError($this->Faq->validationErrors)) {
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
 * __getLatest method
 *
 * @param int $blockId blocks.id
 * @param int $categoryId selected category id
 * @return array
 */
	private function __getLatest($blockId, $categoryId = null) {
		$faqs = $this->Faq->getFaqs($blockId, $categoryId);
		$categoryOptions = $this->Category->getCategoryList($blockId);

		$results = array(
			'faqs' => $faqs,
			'categoryOptions' => $categoryOptions
		);
		return $results;
	}

/**
 * __initFaq method
 *
 * @param int $categoryId categories.id
 * @return void
 */
	private function __initFaq($categoryId = 0) {
		$results = $this->__getLatest($this->viewVars['blockId'], $categoryId);
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
		if (! $faq = $this->Faq->getFaq($faqId)) {
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
