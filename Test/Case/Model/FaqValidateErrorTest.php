<?php
/**
 * Faq Model Test Case
 *
 * @property Faq $Faq
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsModelTestCase', 'Faqs.Test/Case/Model');

/**
 * Faq Model Test Case
 */
class FaqValidateErrorTest extends FaqsModelTestCase {

/**
 * Expect Faq->testSaveFaq() by not empty
 *
 * @return void
 */
	public function testSaveFaqByNotEmpty() {
		//Checkカラム
		$fields = array(
			'key' => __d('net_commons', 'Invalid request.'),
			'question' => sprintf(__d('net_commons', 'Please input %s.'), __d('faqs', 'Question')),
			'answer' => sprintf(__d('net_commons', 'Please input %s.'), __d('faqs', 'Answer')),
		);
		//Check項目
		$checks = array(
			null, '', false,
		);

		foreach ($fields as $field => $message) {
			//データ生成
			$data = array(
				'Faq' => array(
					'block_id' => '1',
					'category_id' => '1',
					'key' => 'faq_new',
					'status' => NetCommonsBlockComponent::STATUS_APPROVED,
					'question' => 'q_new',
					'answer' => 'a_new',
				),
				'Comment' => array('comment' => 'Edit comment'),
				'Block' => array('key' => 'block_1'),
			);

			//期待値
			$expected = array($field => array($message));

			//テスト実施(カラムなし)
			unset($data['Faq'][$field]);
			$this->__assertSaveFaq($field, $data, $expected);

			//テスト実施
			foreach ($checks as $check) {
				$data['Faq'][$field] = $check;
				$this->__assertSaveFaq($field, $data, $expected);
			}
		}
	}

/**
 * Expect Faq->saveFaq() by comment
 *
 * @return void
 */
	public function testSaveFaqByComment() {
		//データ生成
		$data = array(
			'Faq' => array(
				'block_id' => '1',
				'category_id' => '1',
				'key' => 'faq_new',
				'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
				'question' => 'q_new',
				'answer' => 'a_new',
			),
			'Comment' => array('comment' => ''),
			'Block' => array('key' => 'block_1'),
		);

		//期待値
		$expected = array(
			'comment' => array(
				__d('net_commons', 'If it is not approved, comment is a required input.')
			)
		);

		//テスト実施
		$this->__assertSaveFaq('comment', $data, $expected);
	}

/**
 * __assertSaveFaq
 *
 * @param string $field Field name
 * @param array $data Save data
 * @param array $expected Expected value
 * @return void
 */
	private function __assertSaveFaq($field, $data, $expected) {
		//初期処理
		$this->setUp();
		//登録処理実行
		$result = $this->Faq->saveFaq($data);
		//戻り値テスト
		$this->assertFalse($result, 'Result error: ' . $field . ' ' . print_r($data, true));
		//validationErrorsテスト
		$this->assertEquals($this->Faq->validationErrors, $expected,
							'Validation error: ' . $field . ' ' . print_r($this->Faq->validationErrors, true) . print_r($data, true));
		//終了処理
		$this->tearDown();
	}
}
