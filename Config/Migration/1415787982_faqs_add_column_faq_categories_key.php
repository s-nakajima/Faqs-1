<?php
/**
 * Migration file
 *
 * @author    Noriko Arai <arai@nii.ac.jp>
 * @author    Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link      http://www.netcommons.org NetCommons Project
 * @license   http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * FaqsAddColumnFaqCategoriesKey CakeMigration
 *
 * @author    Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package   NetCommons\Faqs\Config\Migration
 */
class FaqsAddColumnFaqCategoriesKey extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'faqs_add_column_faq_categories_key';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'faq_categories' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'category key | カテゴリーKey |  | ', 'charset' => 'utf8', 'after' => 'block_id'),
				),
				'faq_frame_settings' => array(
					'display_number' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'display number | 表示桁数 |  | ', 'after' => 'display_category'),
				),
			),
			'drop_field' => array(
				'faq_frame_settings' => array('diplay_number'),
				'faqs' => array('block_id'),
			),
			'alter_field' => array(
				'faqs' => array(
					'faq_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'faq category id | FAQカテゴリーID | faq_categories.id | '),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'faq_categories' => array('key'),
				'faq_frame_settings' => array('display_number'),
			),
			'create_field' => array(
				'faq_frame_settings' => array(
					'diplay_number' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'display number | 表示桁数 |  | '),
				),
				'faqs' => array(
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'block id |  ブロックID | blocks.id | '),
				),
			),
			'alter_field' => array(
				'faqs' => array(
					'faq_category_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'faq category id | FAQカテゴリーID | faq_categories.id | '),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
