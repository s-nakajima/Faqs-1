<?php
/**
 * Index test on FaqsController
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsController', 'Faqs.Controller');
App::uses('FaqsBaseController', 'Faqs.Test/Case/Controller');

/**
 * Index test on FaqsController
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Controller
 */
class FaqsControllerTestIndex extends FaqsBaseController {

/**
 * setUp
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
 * Expect index action
 *
 * @return void
 */
	public function testIndex() {
//		RolesControllerTest::login($this);

//		$frameId = '100';
//		$view = $this->testAction(
//				'/faqs/blocks/index/' . $frameId,
//				array(
//					'method' => 'get',
//					'return' => 'view',
//				)
//			);
//		$this->assertTextEquals('index', $this->controller->view);
//
//		$this->assertTextContains('/frames/frames/edit/' . $frameId, $view);
//		$this->assertTextContains('/faqs/blocks/add/' . $frameId, $view);
//		$this->assertTextContains('/faqs/blocks/edit/' . $frameId . '/100', $view);
//		$this->assertTextContains('/faqs/blocks/edit/' . $frameId . '/101', $view);

//		AuthGeneralControllerTest::logout($this);
	}
}
