<?php
/**
 * FaqOrders Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * FaqOrders Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Controller
 */
class FaqOrdersController extends FaqsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Faqs.Faq',
		'Faqs.FaqOrder',
		'Faqs.FaqFrameSetting',
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
		return $this->render('FaqOrders/token', false);
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
		$this->FaqOrder->changeFaqOrder($this->data, $this->viewVars['blockKey']);

		// セッション取得
		$session = $this->Faqs->getSession($frameId);

		$faqList = $this->getFaqList($this->viewVars['blockId'], $session['displayCategoryId'], $session['displayNumber'], $session['currentPage']);
		$results = array(
			'faqList' => $faqList,
		);

		$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
	}
}
