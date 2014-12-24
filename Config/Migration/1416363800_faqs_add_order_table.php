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
 * FaqsAddOrderTable CakeMigration
 *
 * @author    Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package   NetCommons\Faqs\Config\Migration
 */
class FaqsAddOrderTable extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'faqs_add_order_table';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'faq_category_orders' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'faq_category_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'category key | カテゴリーKey | faq_categories.key | ', 'charset' => 'utf8'),
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'block key | ブロックKey | blocks.key | ', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'The weight of the display(display order) | 表示の重み(表示順序) |  | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'faq_orders' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'faq_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'faq key | FAQKey | faqs.key | ', 'charset' => 'utf8'),
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'block key | ブロックKey | blocks.key | ', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'The weight of the display(display order) | 表示の重み(表示順序) |  | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'create_field' => array(
				'faqs' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'faq key | FAQKey |  | ', 'charset' => 'utf8', 'after' => 'faq_category_id'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'faq_category_orders', 'faq_orders',
			),
			'drop_field' => array(
				'faqs' => array('key'),
			),
		),
	);

/**
 * recodes
 *
 * @var array $migration
 */
	public $records = array(
		'Plugin' => array(
			array(
				'language_id' => 2,
				'key' => 'faqs',
				'namespace' => 'netcommons/faqs',
				'name' => 'FAQ',
				'type' => 1,
			),
		),

		'PluginsRole' => array(
			array(
				'role_key' => 'room_administrator',
				'plugin_key' => 'faqs'
			),
		),

		'PluginsRoom' => array(
			array(
				'room_id' => '1',
				'plugin_key' => 'faqs'
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
		if ($direction === 'down') {
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
	}

/**
 * Update model records
 *
 * @param string $model model name to update
 * @param string $records records to be stored
 * @param string $scope ?
 * @return boolean Should process continue
 */
	public function updateRecords($model, $records, $scope = null) {
		$Model = $this->generateModel($model);
		foreach ($records as $record) {
			$Model->create();
			if (!$Model->save($record, false)) {
				return false;
			}
		}

		return true;
	}
}
