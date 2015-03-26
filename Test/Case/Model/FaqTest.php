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
class FaqTest extends FaqsModelTestCase {

/**
 * Expect Faq->getFaqs()
 *
 * @return void
 */
	public function testGetFaqs() {
		$blockId = 1;
		$result = $this->Faq->getFaqs($blockId);

		$expected = array(
			0 => array(
				'Faq' => array(
					'id' => '1',
					'block_id' => '1',
					'category_id' => '1',
					'status' => '1',
					'question' => 'q_1',
					'answer' => 'a_1',
					'created_user' => '1',
				),
				'FaqOrder' => array(
					'id' => '1',
					'faq_key' => 'faq_1',
					'weight' => '1',
				),
			),
			1 => array(
				'Faq' => array(
					'id' => '2',
					'block_id' => '1',
					'category_id' => '2',
					'status' => '1',
					'question' => 'q_2',
					'answer' => 'a_2',
					'created_user' => '1',
				),
				'FaqOrder' => array(
					'id' => '2',
					'faq_key' => 'faq_2',
					'weight' => '2',
				),
			),
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * Expect Faq->getFaqs() by select category
 *
 * @return void
 */
	public function testGetFaqsBySelectCategory() {
		$blockId = 1;
		$categoryId = 2;
		$result = $this->Faq->getFaqs($blockId, $categoryId);

		$expected = array(
			0 => array(
				'Faq' => array(
					'id' => '2',
					'block_id' => '1',
					'category_id' => '2',
					'status' => '1',
					'question' => 'q_2',
					'answer' => 'a_2',
					'created_user' => '1',
				),
				'FaqOrder' => array(
					'id' => '2',
					'faq_key' => 'faq_2',
					'weight' => '2',
				),
			),
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * Expect Faq->getFaq()
 *
 * @return void
 */
	public function testGetFaq() {
		//データ生成
		$faqId = 2;
		//処理実行
		$result = $this->Faq->getFaq($faqId);

		//期待値の生成
		$expected = array(
			'Faq' => array(
				'id' => 2,
				'block_id' => 1,
				'category_id' => 2,
				'key' => 'faq_2',
				'status' => 1,
				'question' => 'q_2',
				'answer' => 'a_2',
				'created_user' => 1,
				'created' => '2014-06-18 02:06:22',
				'modified_user' => 1,
				'modified' => '2014-06-18 02:06:22'
			),
		);

		//テスト実施
		$this->_assertArray(null, $expected, $result);
	}

/**
 * Expect Faq->testSaveFaq()
 *
 * @return void
 */
	public function testSaveFaq() {
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

		//処理実行
		$this->Faq->saveFaq($data);

		//期待値の生成
		$faqId = 3;
		$expected = $data;
		$expected['Faq']['id'] = $faqId;
		unset($expected['Comment']);
		unset($expected['Block']);

		//テスト実施
		$result = $this->Faq->find('first', array(
			'fields' => array('id', 'block_id', 'category_id', 'key', 'status', 'question', 'answer'),
			'recursive ' => -1,
			'conditions' => array(
				'Faq.id' => $faqId
			),
		));
		$this->_assertArray(null, $expected, $result);
	}

/**
 * Expect Faq->testDeleteFaq()
 *
 * @return void
 */
	public function testDeleteFaq() {
		$faqId = 1;
		$faq = $this->Faq->findById($faqId);

		//処理実行
		$this->Faq->deleteFaq($faq['Faq']['id']);

		//期待値の生成
		$expected = true;

		//テスト実施
		$faq = $this->Faq->findById($faqId);
		$result = empty($faq);
		$this->assertEquals($expected, $result);
	}

/**
 * Expect Faq->testDeleteBlock()
 *
 * @return void
 */
	public function testDeleteBlock() {
		$blockId = 1;

		//データ生成
		$options = array(
			'recursive' => -1,
			'conditions' => array(
				'FaqBlock.id' => $blockId
			),
		);
		$block = $this->FaqBlock->find('first', $options);

		//初期処理
		$this->setUp();

		//処理実行
		$this->Faq->deleteBlock($block);

		//期待値の生成
		$expected = true;

		//テスト実施
		$block = $this->FaqBlock->find('first', $options);
		$result = empty($block);
		$this->assertEquals($expected, $result);

		//終了処理
		$this->tearDown();
	}
}
