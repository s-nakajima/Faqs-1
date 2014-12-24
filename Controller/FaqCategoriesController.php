<?php
/**
 * FaqCategories Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');
/**
 * FaqCategories Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Controller
 */
class FaqCategoriesController extends FaqsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
		'Faqs.FaqCategory',
		'Faqs.FaqCategoryOrder',
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
				'contentEditable' => array('token', 'edit', 'delete'),
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
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function token($frameId = 0) {
		return $this->render('FaqCategories/token', false);
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
			$results = $this->getCategoryResponseData();
			$this->renderJson($results);
			return;
		}

		$postData = $this->data;

		$category = $this->FaqCategory->saveCategory($postData, $this->viewVars['blockId'], $this->viewVars['blockKey']);
		if (! $category) {
			//バリデーションエラー
			$results = array('validationErrors' => $this->FaqCategory->validationErrors);
			$this->renderJson($results, __d('net_commons', 'Bad Request'), 400);
			return;
		}

		$results = $this->getCategoryResponseData();
		$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
	}

/**
 * delete method
 *
 * @param int $frameId frames.id
 * @param int $faqCategoryId faq_categories.id
 * @return CakeResponse A response object containing the rendered view.
 * @throws MethodNotAllowedException
 */
	public function delete($frameId = 0, $faqCategoryId = 0) {
		if (! $this->request->isDelete()) {
			throw new MethodNotAllowedException();
		}

		$this->FaqCategory->deleteCategory($faqCategoryId);

		$results = $this->getCategoryResponseData();
		$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
	}
}
