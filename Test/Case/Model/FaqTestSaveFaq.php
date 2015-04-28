<?php
/**
 * Test of Faq->saveFaq()
 *
 * @property Faq $Faq
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqTest', 'Faqs.Test/Case/Model');

/**
 * Test of Faq->saveFaq()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqTestSaveFaq extends FaqTest {

/**
 * Default save data
 *
 * @var array
 */
	private $__defaultData = array(
		'Frame' => array(
			'id' => '100',
		),
		'Block' => array(
			'id' => '100',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'faqs',
			'key' => 'block_100',
			'public_type' => '1',
			'from' => '2015-04-28 12:09:35',
			'to' => '2016-04-28 01:12:28',
			'name' => '',
		),
		'Faq' => array(
			'id' => '1',
			'key' => 'faq_1',
			'name' => 'faq name 100',
			'is_auto_translated' => false,
			'translation_engine' => null,
		),
		'FaqSetting' => array(
			'id' => '1',
		),
	);

/**
 * Expect to save the Faq
 *
 * @return void
 */
	public function test() {
		//データ生成
		$data = $this->__defaultData;

		//処理実行
		$result = $this->Faq->saveFaq($data);
		$this->assertTrue($result);

		$blockId = '100';
		$roomId = '1';
		$result = $this->Faq->getFaq($blockId, $roomId);

		//期待値の生成
		$expected = $data;
		$expected = Hash::remove($expected, 'Frame');
		$expected = Hash::remove($expected, 'FaqSetting');
		$expected = Hash::insert($expected, 'Faq.block_id', '100');

		//テスト実施
		$this->_assertArray($expected, $result);
	}

/**
 * Expect null block_id
 *
 * @return void
 */
	public function testNullBlockId() {
		$data = Hash::merge($this->__defaultData, array(
			'Block' => array(
				'id' => '',
				'room_id' => '2',
				'key' => '',
			),
		));
	}

}
