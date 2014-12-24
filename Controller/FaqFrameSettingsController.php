<?php
/**
 * FaqFrameSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * FaqFrameSettings Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Controller
 */
class FaqFrameSettingsController extends FaqsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
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
				'contentEditable' => array('token', 'edit'),
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
		'NetCommons.NetCommonsForm'
	);

/**
 * index method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0) {
		return $this->view($frameId);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0) {
		$this->layout = 'NetCommons.modal';
		$this->FaqFrameSetting = ClassRegistry::init('Faqs.FaqFrameSetting');
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function token($frameId = 0) {
		$this->view($frameId);
		return $this->render('FaqFrameSettings/token', false);
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 * @throws MethodNotAllowedException
 */
	public function edit($frameId = 0) {
		if (! $this->request->isPost()) {
			$results = $this->_getResponseData();
			$this->renderJson($results);
			return;
		}

		$postData = $this->data;
		$faqSetting = $this->FaqFrameSetting->save($postData);

		// セッション保存
		$this->Faqs->setSession($frameId, $faqSetting['FaqFrameSetting']['display_category'], $faqSetting['FaqFrameSetting']['display_number']);

		$results = $this->_getResponseData();
		$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
	}

/**
 * _getResponseData method
 *
 * @return CakeResponse A response object containing the rendered view.
 */
	protected function _getResponseData() {
		$faqSetting = $this->FaqFrameSetting->getFaqSetting($this->viewVars['frameKey']);
		$categoryList = $this->FaqCategory->getFaqCategoryList($this->viewVars['blockId']);
		$faqList = $this->getFaqList($this->viewVars['blockId'], $faqSetting['FaqFrameSetting']['display_category'], $faqSetting['FaqFrameSetting']['display_number']);
		$faqListTotal = $this->getFaqListTotal();

		return array(
			'faqSetting' => $faqSetting,
			'categoryOptions' => $categoryList,
			'faqList' => $faqList,
			'faqListTotal' => $faqListTotal,
			'displayCategoryId' => $faqSetting['FaqFrameSetting']['display_category'],
			'displayNumber' => $faqSetting['FaqFrameSetting']['display_number'],
		);
	}
}
