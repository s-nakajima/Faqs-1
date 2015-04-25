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
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('edit')
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
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->set('blockId', isset($this->params['pass'][1]) ? (int)$this->params['pass'][1] : null);
		$this->initFaq(['faqSetting']);

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

//		$roles = $this->Role->find('all', array(
//			'recursive' => -1,
//			'conditions' => array(
//				'Role.type' => 2, //後で定数化
//				'Role.language_id' => $this->viewVars['languageId'],
//			),
//		));
//var_dump($roles);
//
//		$roles = Hash::combine($roles, '{n}.Role.key', '{n}.Role');

		$permissions = $this->NetCommonsBlock->getBlockRolePermissions(
			$this->viewVars['blockKey'],
			['content_creatable', 'content_publishable']
		);

		//var_dump($permissions);

		//$rolesRooms = $this->RolesRoom->find('all', array(
		//	'recursive' => -1,
		//	'conditions' => array(
		//		'RolesRoom.room_id' => $this->viewVars['roomId'],
		//	),
		//));
		//$rolesRooms = Hash::combine($rolesRooms, '{n}.RolesRoom.role_key', '{n}.RolesRoom');
		//
		//$defaultPermissions = $this->DefaultRolePermission->find('all', array(
		//	'recursive' => -1,
		//	'conditions' => array(
		//		'DefaultRolePermission.type' => 'bbs_block_role',
		//	),
		//));
		//$defaultPermissions = Hash::combine(
		//	$defaultPermissions,
		//	'{n}.DefaultRolePermission.role_key',
		//	'{n}.DefaultRolePermission',
		//	'{n}.DefaultRolePermission.permission'
		//);
		//
		//$blockPermissions = $this->BlockRolePermission->find('all', array(
		//	'recursive' => -1,
		//	'conditions' => array(
		//		'BlockRolePermission.block_key' => $this->viewVars['blockKey'],
		//	),
		//));
		//$blockPermissions = Hash::combine(
		//	$blockPermissions,
		//	'{n}.BlockRolePermission.roles_room_id',
		//	'{n}.BlockRolePermission',
		//	'{n}.BlockRolePermission.permission'
		//);

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
			//'defaultPermissions' => $defaultPermissions,
			'roles' => $permissions['Roles'],
			//'rolesRooms' => $rolesRooms,
			'current' => $this->current,
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}
}
