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
class FaqOrderErrorTest extends FaqsModelTestCase {

/**
 * Expect FaqOrder->saveFaqOrder()
 *
 * @return void
 */
	public function testSaveFaqOrderByUnknownFaqKey() {
		$this->setExpectedException('InternalErrorException');

		$blockKey = 'block_1';

		//データ生成
		$data = array(
			array('FaqOrder' => array(
				'faq_key' => 'faq_unknown'
			)),
			array('FaqOrder' => array(
				'faq_key' => 'faq_1'
			)),
		);

		//処理実行
		$this->FaqOrder->saveFaqOrders($data, $blockKey);
	}
}
