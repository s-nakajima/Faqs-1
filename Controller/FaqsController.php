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
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
		'Faqs.FaqCategory',
		'Faqs.FaqFrameSetting',
		'Faqs.Faq',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('indexLatest', 'indexSetting', 'edit', 'delete'),
				'contentCreatable' => array('token', 'edit', 'delete'),
			),
		),
		'Faqs.Faqs',
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
		$this->Auth->allow('changeView');
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @param string $lang ex)"en" or "ja" etc.
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0, $lang = '') {
		// ブロックが登録されていない場合
		if (empty($this->viewVars['blockId'])) {
			$block = $this->FaqCategory->saveInitialSetting($this->viewVars['frameId'], $this->viewVars['frameKey']);
			$this->viewVars['blockId'] = (int)$block['Block']['id'];
			$this->viewVars['blockKey'] = $block['Block']['key'];
		}

		$faqSetting = $this->FaqFrameSetting->getFaqSetting($this->viewVars['frameKey']);
		$this->Faqs->setSession($frameId, $faqSetting['FaqFrameSetting']['display_category'], $faqSetting['FaqFrameSetting']['display_number']);

		$faqList = $this->getFaqList($this->viewVars['blockId'], $faqSetting['FaqFrameSetting']['display_category'], $faqSetting['FaqFrameSetting']['display_number']);
		$faqListTotal = $this->getFaqListTotal();

		$categoryList = $this->FaqCategory->getFaqCategoryList($this->viewVars['blockId']);

		$this->set('faqSetting', $faqSetting);
		$this->set('faqList', $faqList);
		$this->set('faqListTotal', $faqListTotal);
		$this->set('categoryOptions', $categoryList);
	}

/**
 * indexLatest method
 *
 * @param int $frameId frames.id
 * @return void
 * @throws MethodNotAllowedException
 */
	public function indexLatest($frameId = 0) {
		// セッション取得
		$session = $this->Faqs->getSession($frameId);

		//最新データ取得
		$results = $this->_getResponseData($this->viewVars['blockId'], $session['displayCategoryId'], $session['displayNumber'], $session['currentPage']);
		$this->renderJson($results);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function indexSetting($frameId = 0) {
		$this->layout = 'NetCommons.modal';
		$this->FaqFrameSetting = ClassRegistry::init('Faqs.FaqFrameSetting');
	}

/**
 * change view method
 *
 * @param int $frameId frames.id
 * @param int $displayCategoryId faq_frame_settings.display_category
 * @param int $displayNumber faq_frame_settings.display_number
 * @param int $currentPage select page
 * @return void
 */
	public function changeView($frameId = 0, $displayCategoryId = '', $displayNumber = '', $currentPage = '') {
		$faqSetting = $this->FaqFrameSetting->findByFrameKey($this->viewVars['frameKey']);
		if ($faqSetting['FaqFrameSetting']['display_category'] &&
			$displayCategoryId !== $faqSetting['FaqFrameSetting']['display_category']) {
			$this->renderJson(null, __d('net_commons', 'Bad Request'), 400);
			return;
		}

		// セッション保存
		$this->Faqs->setSession($frameId, $displayCategoryId, $displayNumber, $currentPage);

		$results = $this->_getResponseData($this->viewVars['blockId'], $displayCategoryId, $displayNumber, $currentPage);
		$this->renderJson($results);
	}

/**
 * delete method
 *
 * @param int $frameId frames.id
 * @param int $faqId faqs.id
 * @return void
 * @throws MethodNotAllowedException
 */
	public function delete($frameId = 0, $faqId = 0) {
		if (! $this->request->isDelete()) {
			throw new MethodNotAllowedException();
		}

		$faq = $this->Faq->deleteFaq($faqId);

		$this->FaqFrameSetting = ClassRegistry::init('Faqs.FaqFrameSetting');
		$this->Session->write('currentPage', FaqFrameSetting::DEFAULT_PAGE);
		$session = $this->Faqs->getSession($frameId);

		$results = $this->_getResponseData($this->viewVars['blockId'], $session['displayCategoryId'], $session['displayNumber'], $session['currentPage']);

		if ($faq) {
			$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
		} else {
			$this->renderJson($results, __d('net_commons', 'Bad Request'), 400);
		}
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param int $manageMode frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0, $manageMode = 0) {
		$this->layout = 'NetCommons.modal';
		$this->set('manageMode', $manageMode);
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function token($frameId = 0) {
		$this->index();
		$categoryList = $this->FaqCategory->getFaqCategoryList($this->viewVars['blockId']);
		$this->set('categoryOptions', $categoryList);
		$this->render('Faqs/token', false);
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $faqId faqs.id
 * @return void
 * @throws MethodNotAllowedException
 */
	public function edit($frameId = 0, $faqId = 0) {
		// セッション取得
		$session = $this->Faqs->getSession($frameId);

		if (! $this->request->isPost()) {
			//最新データ取得
			$frameSetting = $this->FaqFrameSetting->findByFrameKey($this->viewVars['frameKey']);
			$displayCategoryId = $frameSetting['FaqFrameSetting']['display_category'];

			$faq = $this->Faq->getFaq($faqId, $displayCategoryId, $this->viewVars['blockId']);
			$categoryList = $this->FaqCategory->getFaqCategoryList($this->viewVars['blockId']);

			$results = array(
				'faq' => $faq,
				'displayCategoryId' => $displayCategoryId,
				'categoryOptions' => $categoryList,
			);

			$this->request->data = $faq;
			$tokenFields = Hash::flatten($this->request->data);
			$hiddenFields = array('Faq.faq_category_id');
			$this->set('tokenFields', $tokenFields);
			$this->set('hiddenFields', $hiddenFields);
			$this->set('results', $results);
			return;
		}

		// FAQの登録
		$faq = $this->Faq->saveFaq($this->data, $this->viewVars['blockKey']);
		if (! $faq) {
			//バリデーションエラー
			$results = array('validationErrors' => $this->Faq->validationErrors);
			$this->renderJson($results, __d('net_commons', 'Bad Request'), 400);
			return;
		}

		$results = $this->_getResponseData($this->viewVars['blockId'], $session['displayCategoryId'], $session['displayNumber'], $session['currentPage']);
		$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
	}

/**
 * getResponseData method
 *
 * @param int $blockId blocks.id
 * @param int $displayCategoryId faq_frame_settings.display_category
 * @param int $displayNumber faq_frame_settings.display_number
 * @param int $currentPage select page
 * @return array
 */
	protected function _getResponseData($blockId, $displayCategoryId, $displayNumber, $currentPage = 1) {
		$faqList = $this->getFaqList($blockId, $displayCategoryId, $displayNumber, $currentPage);
		$faqListTotal = $this->getFaqListTotal();
		$categoryList = $this->FaqCategory->getFaqCategoryList($this->viewVars['blockId']);

		return array(
			'faqList' => $faqList,
			'faqListTotal' => $faqListTotal,
			'displayCategoryId' => $displayCategoryId,
			'displayNumber' => $displayNumber,
			'currentPage' => $currentPage,
			'categoryOptions' => $categoryList,
		);
	}
}
