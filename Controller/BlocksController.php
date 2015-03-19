<?php
/**
 * BlocksController
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * BlocksController
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Controller
 */
class BlocksController extends FaqsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
		'Blocks.Block',
		'Faqs.Faq',
		'Categories.Category',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
		'Blocks.BlockCommon',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'Frames.setting';
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0) {
		$frame = $this->Frame->getFrame($frameId, $this->plugin);
		$blocks = $this->Block->getBlocksByFrame($this->viewVars['roomId'], 'faqs');

		$result = array(
			'frame' => $frame['Frame'],
			'blocks' => $blocks,
		);
		$result = $this->camelizeKeyRecursive($result);
		$this->set($result);
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function edit($frameId = 0, $blockId = 0) {
		$frame = $this->Frame->getFrame($frameId, $this->plugin);
		$block = ($blockId) ?
			$this->Block->getEditBlock($blockId, $this->viewVars['roomId'], 'faqs') :
			$this->Block->create(['id' => '']);
		$categoryList = $this->Category->getCategoryList($blockId);

		$result = array(
			'frame' => $frame['Frame'],
			'block' => $block['Block'],
			'categoryList' => $categoryList,
		);
		$result = $this->camelizeKeyRecursive($result);
		$this->set($result);

		if ($this->request->isGet()) {
			CakeSession::write('backUrl', $this->request->referer());
		}

		if ($this->request->isPost()) {
			if (isset($this->data['delete'])) {
				$this->Faq->deleteBlock($block);
			} else {
				$this->Block->saveBlock($this->data, $frame);
				if (!$this->__handleValidationError($this->Block->validationErrors)) {
					return;
				}
			}
//
//			if (!$this->request->is('ajax')) {
//				$backUrl = CakeSession::read('backUrl');
//				CakeSession::delete('backUrl');
//				$this->redirect($backUrl);
//			}
		}
	}

/**
 * editAuth method
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function editAuth($frameId = 0, $blockId = 0) {
		$frame = $this->Frame->getFrame($frameId, $this->plugin);
		$block = $this->Block->getEditBlock($blockId, $this->viewVars['roomId'], 'faqs');
		$result = array(
			'frame' => $frame['Frame'],
			'block' => $block['Block'],
		);
		$result = $this->camelizeKeyRecursive($result);
		$this->set($result);
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
}