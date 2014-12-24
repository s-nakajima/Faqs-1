<?php
/**
 * FaqAuthoritySettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * FaqAuthoritySettings Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Controller
 */
class FaqAuthoritySettingsController extends FaqsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Blocks.BlockRolePermission',
		'Rooms.RolesRoom',
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
		$this->view($frameId);
		return $this->render('FaqAuthoritySettings/token', false);
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
			$results = $this->_getResponseData();
			$this->renderJson($results);
			return;
		}

		$data = $this->data;

		// 新規登録時
		if (empty($data['BlockRolePermission']['id'])) {
			$options = array(
				'conditions' => array(
					'RolesRoom.room_id' => $this->viewVars['roomId'],
					'RolesRoom.role_key' => 'general_user',
				),
			);
			$rolesRoom = $this->RolesRoom->find('first', $options);

			$data['BlockRolePermission']['roles_room_id'] = $rolesRoom['RolesRoom']['id'];
			$data['BlockRolePermission']['block_key'] = $this->viewVars['blockKey'];
			$data['BlockRolePermission']['permission'] = 'content_creatable';
		}

		$this->BlockRolePermission->save($data);

		$results = $this->_getResponseData();
		$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
	}

/**
 * _getResponseData method
 *
 * @return CakeResponse A response object containing the rendered view.
 */
	protected function _getResponseData() {
		$options = array(
			'conditions' => array(
				'BlockRolePermission.block_key' => $this->viewVars['blockKey'],
				'BlockRolePermission.permission' => 'content_creatable',
				'RolesRoom.role_key' => 'general_user',
			),
		);
		$blockRolePermission = $this->BlockRolePermission->find('first', $options);

		// 登録されていない場合、初期値を設定
		if (empty($blockRolePermission)) {
			$blockRolePermission = array(
				'BlockRolePermission' => array(
					'id' => null,
					'value' => false,
				)
			);
		}

		return array('blockRolePermission' => $blockRolePermission);
	}
}
