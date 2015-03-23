<?php
/**
 * FaqsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsController', 'Faqs.Controller');
App::uses('FaqsControllerTestCase', 'Faqs.Test/Case/Controller');

/**
 * FaqsController Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Test\Case\Controller
 */
class FaqsControllerTest extends FaqsControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		$this->generate(
			'Faqs.Faqs',
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
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction(
				'/faqs/faqs/index/1',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
		$this->assertTextEquals('index', $this->controller->view);
	}

/**
 * Expect visitor can access view action
 *
 * @return void
 */
	public function testView() {
		$this->testAction(
				'/faqs/faqs/view/1/1',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
		$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect user cannot access view action with unknown faq id
 *
 * @return void
 */
	public function testViewByUnknownFaqId() {
		$this->testAction(
				'/faqs/faqs/view/1/999',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
		$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect user cannot access view action with unknown frame id
 *
 * @return void
 */
	public function testViewByUnknownFrameId() {
		$this->setExpectedException('InternalErrorException');
		$this->testAction(
				'/faqs/faqs/view/999',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
	}

/**
 * Expect admin user can access edit action
 *
 * @return void
 */
	public function testEditGet() {
		RolesControllerTest::login($this);

		$this->testAction(
			'/faqs/faqs/edit/1',
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can access edit action
 *
 * @return void
 */
	public function testEditPost() {
		RolesControllerTest::login($this);

		$data = array(
			'Faq' => array(
				'block_id' => '1',
				'category_id' => '1',
				'key' => 'faq_1',
				'question' => 'edit question',
				'answer' => 'edit answer',
			),
			'Comment' => array(
				'comment' => 'edit comment',
			),
			sprintf('save_%s', NetCommonsBlockComponent::STATUS_PUBLISHED) => '',
		);

		$this->testAction(
			'/faqs/faqs/edit/1',
			array(
				'method' => 'post',
				'data' => $data,
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can access edit action as delete
 *
 * @return void
 */
	public function testEditPostByDelete() {
		RolesControllerTest::login($this);

		$data = array(
			'Faq' => array(
				'block_id' => '1',
				'category_id' => '1',
				'key' => 'faq_1',
				'question' => 'edit question',
				'answer' => 'edit answer',
			),
			'Comment' => array(
				'comment' => 'edit comment',
			),
			sprintf('save_%s', NetCommonsBlockComponent::STATUS_PUBLISHED) => '',
			'delete' => '',
		);

		$this->testAction(
			'/faqs/faqs/edit/1/1',
			array(
				'method' => 'post',
				'data' => $data,
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}
}
