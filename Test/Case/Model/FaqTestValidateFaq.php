<?php
/**
 * Test of Faq->validateFaq()
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
 * Test of Faq->validateFaq()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqTestValidateFaq extends FaqTest {

/**
 * Default validate data
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
 * Expect to validate the Faq
 *
 * @return void
 */
	public function test() {
	}

}
