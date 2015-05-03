<?php
/**
 * Categories Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * Categories Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Controller
 */
class CategoriesController extends FaqsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
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
				'blockEditable' => array('edit')
			),
		),
		'Categories.Categories',
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
			'active' => 'block_settings'
		);
		$this->set('blockSettingTabs', $blockSettingTabs);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//blockId取得
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);
		$this->Categories->edit();
	}
}
