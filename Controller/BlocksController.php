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
		'Faqs.Faq',
		'Faqs.FaqBlock',
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
		'Paginator',
		'Security' => array(
			'validatePost' => false,
			'csrfCheck' => false
		),
	);

/**
 * beforeFilter
 *
 * @return void
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
		$frame = $this->Frame->findById($frameId);
		$this->Paginator->settings = array('FaqBlock' =>
			array(
				'recursive' => -1,
				'limit' => 5,
				'conditions' => array(
					'room_id' => $this->viewVars['roomId'],
					'plugin_key' => 'faqs'
				)));
		$blocks = $this->Paginator->paginate('FaqBlock');

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
		$frame = $this->Frame->findById($frameId);
		$block = ($blockId) ?
			$this->__getEditBlock($blockId, $this->viewVars['roomId'], 'faqs') :
			$this->FaqBlock->create(['id' => '']);
		$categoryList = $this->Category->getCategoryList($blockId);

		$result = array(
			'frame' => $frame['Frame'],
			'block' => $block['FaqBlock'],
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
				$this->FaqBlock->saveBlock($this->data, $frame);
				if (!$this->handleValidationError($this->FaqBlock->validationErrors)) {
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
 * editAuth method
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function editAuth($frameId = 0, $blockId = 0) {
		$frame = $this->Frame->findById($frameId);
		$block = $this->__getEditBlock($blockId, $this->viewVars['roomId'], 'faqs');
		$result = array(
			'frame' => $frame['Frame'],
			'block' => $block['FaqBlock'],
		);
		$result = $this->camelizeKeyRecursive($result);
		$this->set($result);
	}

/**
 * setBlock method
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return void
 * @throws MethodNotAllowedException
 * @throws InternalErrorException
 */
	public function setBlock($frameId, $blockId) {
		if (! $this->request->isPost()) {
			throw new MethodNotAllowedException();
		}

		$options = array('recursive' => -1, 'conditions' => array('id' => $frameId));
		if (! $frame = $this->Frame->find('first', $options)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$frame['Frame']['block_id'] = $blockId;
		if (! $this->Frame->save($frame)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
	}

/**
 * get block
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms id
 * @param string $pluginKey plugin key
 * @return array block data
 * @throws InternalErrorException
 */
	private function __getEditBlock($blockId, $roomId, $pluginKey) {
		$options = array(
			'recursive' => -1,
			'conditions' => array(
				'id' => $blockId,
				'room_id' => $roomId,
				'plugin_key' => $pluginKey,
			));
		$block = $this->FaqBlock->find('first', $options);
		if (! $block) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$format = 'Y/m/d H:i';
		$block['FaqBlock']['from'] = $this->__formatStrDate($block['FaqBlock']['from'], $format);
		$block['FaqBlock']['to'] = $this->__formatStrDate($block['FaqBlock']['to'], $format);
		return $block;
	}

/**
 * format string date
 *
 * @param string $str string date
 * @param string $format date format
 * @return string format date
 */
	private function __formatStrDate($str, $format) {
		$timestamp = strtotime($str);
		if ($timestamp === false) {
			return null;
		}
		return date($format, $timestamp);
	}
}