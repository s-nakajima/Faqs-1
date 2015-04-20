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
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Blocks.Block',
		'Frames.Frame',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('index', 'add', 'edit', 'delete')
			),
		),
		'Paginator',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');

		$this->layout = 'NetCommons.setting';
		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		try {
			$this->Paginator->settings = array(
				'Block' => array(
					'order' => array('Block.id' => 'desc'),
					'conditions' => array(
						'Block.language_id' => $this->viewVars['languageId'],
						'Block.room_id' => $this->viewVars['roomId'],
						'Block.plugin_key ' => $this->param[''],
					),
					//'limit' => 1
				)
			);
			$faqs = $this->Paginator->paginate('Block');

			if (! $faqs) {
				$this->view = 'Blocks/noBbs';
				return;
			}

			$results = array(
				'faqs' => $faqs,
				'current' => $this->current
			);
			$results = $this->camelizeKeyRecursive($results);
			$this->set($results);

		} catch (Exception $ex) {
			$this->params['named'] = array();
			$this->redirect('/faqs/blocks/index/' . $this->viewVars['frameId']);
		}

//		$frame = $this->Frame->findById($frameId);
//		$this->Paginator->settings = array('FaqBlock' =>
//			array(
//				'recursive' => -1,
//				'limit' => 5,
//				'conditions' => array(
//					'room_id' => $this->viewVars['roomId'],
//					'plugin_key' => 'faqs'
//				)));
//		$blocks = $this->Paginator->paginate('FaqBlock');
//
//		$result = array(
//			'frame' => $frame['Frame'],
//			'blocks' => $blocks,
//		);
//		$result = $this->camelizeKeyRecursive($result);
//		$this->set($result);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
//		$frame = $this->Frame->findById($frameId);
//		$block = ($blockId) ?
//			$this->__getEditBlock($blockId, $this->viewVars['roomId'], 'faqs') :
//			$this->FaqBlock->create(['id' => '']);
//		$categoryList = $this->Category->getCategoryList($blockId);
//
//		$result = array(
//			'frame' => $frame['Frame'],
//			'block' => $block['FaqBlock'],
//			'categoryList' => $categoryList,
//		);
//		$result = $this->camelizeKeyRecursive($result);
//		$this->set($result);
//
//		if ($this->request->isGet()) {
//			CakeSession::write('backUrl', $this->request->referer());
//		}
//
//		if ($this->request->isPost()) {
//			if (isset($this->data['delete'])) {
//				$this->Faq->deleteBlock($block);
//			} else {
//				$this->FaqBlock->saveBlock($this->data, $frame);
//				if (!$this->handleValidationError($this->FaqBlock->validationErrors)) {
//					return;
//				}
//			}
//
//			if (!$this->request->is('ajax')) {
//				$backUrl = CakeSession::read('backUrl');
//				CakeSession::delete('backUrl');
//				$this->redirect($backUrl);
//			}
//		}
	}

/**
 * editAuth method
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return CakeResponse A response object containing the rendered view.
 */
//	public function editAuth($frameId = 0, $blockId = 0) {
//		$frame = $this->Frame->findById($frameId);
//		$block = $this->__getEditBlock($blockId, $this->viewVars['roomId'], 'faqs');
//		$result = array(
//			'frame' => $frame['Frame'],
//			'block' => $block['FaqBlock'],
//		);
//		$result = $this->camelizeKeyRecursive($result);
//		$this->set($result);
//	}

/**
 * setBlock method
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return void
 * @throws MethodNotAllowedException
 * @throws InternalErrorException
 */
//	public function setBlock($frameId, $blockId) {
//		if (! $this->request->isPost()) {
//			throw new MethodNotAllowedException();
//		}
//
//		$options = array('recursive' => -1, 'conditions' => array('id' => $frameId));
//		if (! $frame = $this->Frame->find('first', $options)) {
//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//		}
//
//		$frame['Frame']['block_id'] = $blockId;
//		if (! $this->Frame->save($frame)) {
//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//		}
//	}

/**
 * get block
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms id
 * @param string $pluginKey plugin key
 * @return array block data
 * @throws InternalErrorException
 */
//	private function __getEditBlock($blockId, $roomId, $pluginKey) {
//		$options = array(
//			'recursive' => -1,
//			'conditions' => array(
//				'id' => $blockId,
//				'room_id' => $roomId,
//				'plugin_key' => $pluginKey,
//			));
//		$block = $this->FaqBlock->find('first', $options);
//		if (! $block) {
//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//		}
//
//		$format = 'Y/m/d H:i';
//		$block['FaqBlock']['from'] = $this->__formatStrDate($block['FaqBlock']['from'], $format);
//		$block['FaqBlock']['to'] = $this->__formatStrDate($block['FaqBlock']['to'], $format);
//		return $block;
//	}

/**
 * format string date
 *
 * @param string $str string date
 * @param string $format date format
 * @return string format date
 */
//	private function __formatStrDate($str, $format) {
//		$timestamp = strtotime($str);
//		if ($timestamp === false) {
//			return null;
//		}
//		return date($format, $timestamp);
//	}
}
