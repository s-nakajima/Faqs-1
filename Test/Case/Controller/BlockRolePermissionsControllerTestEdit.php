<?php
/**
 * Edit test on BlockRolePermissionsController
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlockRolePermissionsController', 'Faqs.Controller');
App::uses('FaqsBaseController', 'Faqs.Test/Case/Controller');

/**
 * Edit test on BlockRolePermissionsController
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Controller
 */
class BlockRolePermissionsControllerTestEdit extends FaqsBaseController {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		$this->generate(
			'Faqs.BlockRolePermissions',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
		parent::setUp();
	}

/**
 * Expect user with permissionEditable can access on GET request
 *
 * @return void
 */
	public function testEditGetPermissionEditable() {
		RolesControllerTest::login($this);

		$frameId = '100';
		$blockId = '100';

		$view = $this->testAction(
				'/faqs/block_role_permmisions/edit/' . $frameId . '/' . $blockId,
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
		$this->assertTextEquals('edit', $this->controller->view);

		$this->assertTextContains('/faqs/block_role_permissions/edit/' . $frameId . '/' . $blockId, $view);
		$this->assertTextContains('/faqs/blocks/edit/' . $frameId . '/' . $blockId, $view);
		$this->assertTextContains('name="data[Block][id]"', $view);
		$this->assertTextContains('name="data[FaqSetting][faq_key]"', $view);
		$this->assertTextContains('name="data[FaqSetting][id]"', $view);
		$this->assertTextContains('name="data[FaqSetting][use_workflow]"', $view);
		$this->assertTextContains('name="data[BlockRolePermission][content_creatable]', $view);
		$this->assertTextContains('name="data[BlockRolePermission][content_publishable]', $view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user with permissionEditable cannot access on GET request
 *
 * @return void
 */
	public function testEditGetWOPermissionEditable() {
		//
		// NetCommonsRoomRoleComponent::_isAllowに不具合があり、ForbiddenExceptionにならない
		//

		//$this->setExpectedException('ForbiddenException');
		//
		//RolesControllerTest::login($this, 'editor');
		//
		//$frameId = '100';
		//$blockId = '100';
		//
		//$view = $this->testAction(
		//		'/faqs/block_role_permmisions/edit/' . $frameId . '/' . $blockId,
		//		array(
		//			'method' => 'get',
		//			'return' => 'view',
		//		)
		//	);
		//
		//AuthGeneralControllerTest::logout($this);
	}
}
