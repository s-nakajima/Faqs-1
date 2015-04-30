<?php
/**
 * Test of FaqQuestionOrder->saveFaqQuestionOrders()
 *
 * @property FaqQuestionOrder $FaqQuestionOrder
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqQuestionOrderTest', 'Faqs.Test/Case/Model');

/**
 * Test of FaqQuestionOrder->saveFaqQuestionOrders()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqQuestionOrderTestSaveFaqQuestionOrders extends FaqQuestionOrderTest {

/**
 * Default save data
 *
 * @var array
 */
	private $__defaultData = array(
		'FaqQuestionOrders' => array(
			0 => array(
				'FaqQuestionOrder' => array(
					'id' => '2',
					'faq_key' => 'faq_1',
					'faq_question_key' => 'faq_question_2',
					'weight' => '1',
				),
			),
			1 => array(
				'FaqQuestionOrder' => array(
					'id' => '3',
					'faq_key' => 'faq_1',
					'faq_question_key' => 'faq_question_3',
					'weight' => '2',
				),
			),
			2 => array(
				'FaqQuestionOrder' => array(
					'id' => '1',
					'faq_key' => 'faq_1',
					'faq_question_key' => 'faq_question_1',
					'weight' => '3',
				)
			),
		)
	);

/**
 * Expect to save the FaqQuestionOrders
 *
 * @return void
 */
	public function test() {
		//データ生成
		$data = Hash::merge($this->__defaultData, array());

		//処理実行
		$result = $this->FaqQuestionOrder->saveFaqQuestionOrders($data);
		$this->assertTrue($result);

		//成否のデータ取得
		$faqKey = 'faq_1';
		$result = $this->FaqQuestionOrder->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'faq_key' => $faqKey
				),
			)
		);

		//期待値の生成
		$expected = Hash::merge($this->__defaultData, array());

		//テスト実施
		$this->_assertArray($expected['FaqQuestionOrders'], $result);
	}

}
