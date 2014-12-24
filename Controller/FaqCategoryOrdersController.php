<?php
/**
 * FaqCategoryOrders Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * FaqCategoryOrders Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Controller
 */
class FaqCategoryOrdersController extends FaqsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
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
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function token($frameId = 0) {
		return $this->render('FaqCategoryOrders/token', false);
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
			throw new MethodNotAllowedException();
		}

		// カテゴリ並び替え
		$this->FaqCategoryOrder->changeCategoryOrder($this->data, $this->viewVars['blockKey']);

		$results = $this->getCategoryResponseData();
		$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
	}
}
