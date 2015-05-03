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
		'Faqs.Faq',
		'Faqs.FaqSetting',
		'Categories.Category',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('index', 'add', 'edit', 'delete')
			),
		),
		'Paginator',
		'Categories.Categories',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Date',
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

		//タブの設定
		$settingTabs = array(
			'tabs' => array(
				'block_index' => array(
					'plugin' => $this->params['plugin'],
					'controller' => 'blocks',
					'action' => 'index',
					$this->viewVars['frameId'],
				),
			),
			'active' => 'block_index'
		);
		$this->set('settingTabs', $settingTabs);

		$blockSettingTabs = array(
			'tabs' => array(
				'block_settings' => array(
					'plugin' => $this->params['plugin'],
					'controller' => 'blocks',
					'action' => $this->params['action'],
					$this->viewVars['frameId'],
					$this->viewVars['blockId']
				),
				'role_permissions' => array(
					'plugin' => $this->params['plugin'],
					'controller' => 'block_role_permissions',
					'action' => 'edit',
					$this->viewVars['frameId'],
					$this->viewVars['blockId']
				),
			),
			'active' => 'block_settings'
		);
		$this->set('blockSettingTabs', $blockSettingTabs);
	}

/**
 * index
 *
 * @return void
 * @throws Exception
 */
	public function index() {
		try {
			$this->Paginator->settings = array(
				'Faq' => array(
					'order' => array('Block.id' => 'desc'),
					'conditions' => array(
						'Block.language_id' => $this->viewVars['languageId'],
						'Block.room_id' => $this->viewVars['roomId'],
						'Block.plugin_key ' => $this->params['plugin'],
					),
					//'limit' => 1
				)
			);
			$faqs = $this->Paginator->paginate('Faq');
			if (! $faqs) {
				$this->view = 'Blocks/not_found';
				return;
			}

			$results = array(
				'faqs' => $faqs
			);
			$results = $this->camelizeKeyRecursive($results);
			$this->set($results);

		} catch (Exception $ex) {
			if ($this->params['named']) {
				$this->params['named'] = array();
				$this->redirect('/faqs/blocks/index/' . $this->viewVars['frameId']);
			} else {
				CakeLog::error($ex);
				throw $ex;
			}
		}
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'Blocks/edit';

		$this->set('blockId', null);
		$faq = $this->Faq->create(
			array(
				'id' => null,
				'key' => null,
				'block_id' => null,
				'name' => __d('faqs', 'New FAQ %s', date('YmdHis')),
			)
		);
		$block = $this->Block->create(
			array('id' => null, 'key' => null)
		);

		$data = Hash::merge($faq, $block);

		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();

			$this->Faq->saveFaq($data);
			if ($this->handleValidationError($this->Faq->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/faqs/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
			$data['Block']['id'] = null;
			$data['Block']['key'] = null;
		}

		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		if (! $this->initFaq(['faqSetting'])) {
			return;
		}
		$this->Categories->initCategories();

		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();
			$data['FaqSetting']['faq_key'] = $data['Faq']['key'];

			$this->Faq->saveFaq($data);
			if ($this->handleValidationError($this->Faq->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/faqs/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}

			$results = $this->camelizeKeyRecursive($data);
			$this->set($results);
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		if (! $this->initFaq()) {
			return;
		}

		if ($this->request->isDelete()) {
			if ($this->Faq->deleteFaq($this->data)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/faqs/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
		}

		$this->throwBadRequest();
	}

/**
 * Parse data from request
 *
 * @return array
 */
	private function __parseRequestData() {
		$data = $this->data;
		if ($data['Block']['public_type'] === Block::TYPE_LIMITED) {
			//$data['Block']['from'] = implode('-', $data['Block']['from']);
			//$data['Block']['to'] = implode('-', $data['Block']['to']);
		} else {
			unset($data['Block']['from'], $data['Block']['to']);
		}

		return $data;
	}

}
