<?php
/**
 * FaqOrder Model Test Case
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
 * FaqOrder Model Test Case
 */
class FaqOrderTest extends FaqsModelTestCase {

/**
 * Expect FaqOrder->getMaxWeight()
 *
 * @return void
 */
	public function testGetMaxWeight() {
		$blockKey = 'block_1';

		//処理実行
		$result = $this->FaqOrder->getMaxWeight($blockKey);

		//期待値の生成
		$expected = '2';

		//テスト実施
		$this->assertEquals($expected, $result);
	}

/**
 * Expect FaqOrder->saveFaqOrder()
 *
 * @return void
 */
	public function testSaveFaqOrder() {
		$blockKey = 'block_1';

		//データ生成
		$data = array(
			array('FaqOrder' => array(
				'faq_key' => 'faq_2'
			)),
			array('FaqOrder' => array(
				'faq_key' => 'faq_1'
			)),
		);

		//処理実行
		$this->FaqOrder->saveFaqOrders($data, $blockKey);

		//期待値の生成
		$expected = $data;

		//テスト実施
		$result = $this->FaqOrder->find('all', array(
			'fields' => array('faq_key'),
			'recursive ' => -1,
			'conditions' => array(
				'FaqOrder.block_key' => $blockKey
			),
			'order' => 'FaqOrder.weight',
		));
		$this->_assertArray(null, $expected, $result);
	}
}
