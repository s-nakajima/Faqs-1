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
 * @package NetCommons\Faqs\Controller
 */
class FaqOrdersController extends FaqsAppController {

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
 * beforeFilter
 *
 * @return void
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0) {
		$this->redirect($this->request->referer());
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function edit($frameId = 0) {
		$this->__initFaqOrder();
		if ($this->request->isGet()) {
			CakeSession::write('backUrl', $this->request->referer());
		}
		if ($this->request->isPost()) {
			$this->FaqOrder->saveFaqOrder($this->data, $this->viewVars['blockKey']);

			if (!$this->request->is('ajax')) {
				$backUrl = CakeSession::read('backUrl');
				CakeSession::delete('backUrl');
				$this->redirect($backUrl);
			}
		}
	}

/**
 * __initFaqOrder method
 *
 * @return void
 */
	private function __initFaqOrder() {
		$results['faqs'] = $this->Faq->getFaqs($this->viewVars['blockId']);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

}
