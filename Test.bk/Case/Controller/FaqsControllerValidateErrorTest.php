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
 * FaqsController Validate Error Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Test\Case\Controller
 */
class FaqsControllerValidateErrorTest extends FaqsControllerTestCase {

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
 * Expect user cannot edit with invalid status
 *
 * @return void
 */
	public function testEditWithInvalidStatus() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = 1;
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
		);

		//テスト実行
		$this->setExpectedException('BadRequestException');
		$this->testAction(
			'/faqs/faqs/edit/' . $frameId,
			array(
				'method' => 'post',
				'data' => $data,
				'return' => 'contents'
			)
		);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user cannot edit with invalid status as ajax request
 *
 * @return void
 */
	public function testEditWithInvalidStatusJson() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = 1;
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
		);

		//テスト実行
		$ret = $this->testAction(
			'/faqs/faqs/edit/' . $frameId . '.json',
			array(
				'method' => 'post',
				'data' => $data,
				'type' => 'json',
				'return' => 'contents'
			)
		);
		$result = json_decode($ret, true);
		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user cannot edit with unknown category
 *
 * @return void
 */
	public function testEditWithUnknownCategory() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = 1;
		$data = array(
			'Faq' => array(
				'block_id' => '1',
				'category_id' => '999',
				'key' => 'faq_1',
				'question' => 'edit question',
				'answer' => 'edit answer',
			),
			'Comment' => array(
				'comment' => 'edit comment',
			),
			sprintf('save_%s', NetCommonsBlockComponent::STATUS_DISAPPROVED) => '',
		);

		//期待値
		$expected = array(
			'category_id' => array(
				__d('net_commons', 'Invalid request.')
			)
		);

		//テスト実行
		$this->testAction(
			'/faqs/faqs/edit/' . $frameId,
			array(
				'method' => 'post',
				'data' => $data,
				'return' => 'contents'
			)
		);
		$this->assertEquals($this->controller->validationErrors, $expected);

		AuthGeneralControllerTest::logout($this);
	}
}
