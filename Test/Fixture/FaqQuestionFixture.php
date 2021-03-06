<?php
/**
 * FaqQuestionFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * FaqQuestionFixture
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Test\Fixture
 */
class FaqQuestionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'faq_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'faq key | FAQKey |  | ', 'charset' => 'utf8'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'comment' => 'language id | 言語ID | languages.id | '),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'category id | カテゴリーID | categories.id | '),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Is active, 0:deactive 1:acive | アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ | | '),
		'is_latest' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Is latest, 0:not latest 1:latest | 最新コンテンツかどうか 0:最新でない 1:最新 | | '),
		'question' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'question | 質問 |  | ', 'charset' => 'utf8'),
		'answer' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'answer | 回答 |  | ', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'faq_id' => '1',
			'key' => 'faq_question_1',
			'language_id' => '2',
			'category_id' => '100',
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'question' => 'Question value',
			'answer' => 'Answer value',
		),
		array(
			'id' => '2',
			'faq_id' => '1',
			'key' => 'faq_question_2',
			'language_id' => '2',
			'category_id' => '100',
			'status' => '1',
			'is_active' => true,
			'is_latest' => false,
			'question' => 'Question value 2',
			'answer' => 'Answer value 2',
		),
		array(
			'id' => '3',
			'faq_id' => '1',
			'key' => 'faq_question_2',
			'language_id' => '2',
			'category_id' => '100',
			'status' => '3',
			'is_active' => false,
			'is_latest' => true,
			'question' => 'Question value 3',
			'answer' => 'Answer value 3',
		),
		array(
			'id' => '4',
			'faq_id' => '1',
			'key' => 'faq_question_3',
			'language_id' => '2',
			'category_id' => null,
			'status' => '1',
			'is_active' => true,
			'is_latest' => true,
			'question' => 'Question value 4',
			'answer' => 'Answer value 4',
		),
	);

}
