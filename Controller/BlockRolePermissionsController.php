<?php
/**
 * BlockRolePermissions Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * BlockRolePermissions Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Controller
 */
class BlockRolePermissionsController extends FaqsAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Roles.Role',
		'Roles.DefaultRolePermission',
		'Blocks.Block',
		'Blocks.BlockRolePermission',
		'Rooms.RolesRoom',
		'Faqs.Faq',
		'Faqs.FaqSetting'
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
				'permissionEditable' => array('edit')
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
 */
	public function beforeFilter() {
		parent::beforeFilter();

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
			'active' => 'role_permissions'
		);
		$this->set('blockSettingTabs', $blockSettingTabs);
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

		if (! $block = $this->Block->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'Block.id' => $this->viewVars['blockId'],
			),
		))) {
			$this->throwBadRequest();
			return false;
		};
		$this->set('blockId', $block['Block']['id']);
		$this->set('blockKey', $block['Block']['key']);

		$permissions = $this->NetCommonsBlock->getBlockRolePermissions(
			$this->viewVars['blockKey'],
			['content_creatable', 'content_publishable']
		);

		if ($this->request->isPost()) {
			$data = $this->data;
			$this->FaqSetting->saveFaqSetting($data);
			if ($this->handleValidationError($this->FaqSetting->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/faqs/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
		}

		$results = array(
			'BlockRolePermissions' => $permissions['BlockRolePermissions'],
			'roles' => $permissions['Roles'],
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}
}
