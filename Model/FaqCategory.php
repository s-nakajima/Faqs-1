<?php
/**
 * FaqCategory Model
 *
 * @property Block $Block
 * @property Faq $Faq
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppModel', 'Faqs.Model');

/**
 * FaqCategory Model
 */
class FaqCategory extends FaqsAppModel {

	const CATEGORY_VALUE_UNSELECTED = '0';
	const DEFAULT_FAQ_CATEGORY_KEY = 'default';
	const DEFAULT_FAQ_CATEGORY_NAME = 'デフォルト';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FaqCategoryOrder' => array(
			'className' => 'Faqs.FaqCategoryOrder',
			'foreignKey' => 'key',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Faq' => array(
			'className' => 'Faqs.Faq',
			'foreignKey' => 'faq_category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => array(
				'Faq.id',
				'Faq.faq_category_id',
				'Faq.status',
				'Faq.question',
				'Faq.answer',
			),
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = array(
			'id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				),
			),
			'name' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		);

		return parent::beforeValidate($options);
	}

/**
 * getFaqCategoryList
 *
 * @param int $blockId blocks.id
 * @param boolean $default Whether to get default category
 * @return array
 * @SuppressWarnings(PHPMD)
 */
	public function getFaqCategoryList($blockId, $default = true) {
		$this->unbindModel(array('hasMany' => array('Faq')));
		$fields = array(
			'FaqCategory.id',
			'FaqCategory.key',
			'FaqCategory.name',
			'FaqCategoryOrder.id',
			'FaqCategoryOrder.block_key',
			'FaqCategoryOrder.weight',
		);
		$conditions = array('FaqCategory.block_id' => $blockId);
		$order = array('FaqCategoryOrder.weight');

		// デフォルトカテゴリーを取得しない
		if (! $default) {
			$conditions['NOT'] = array('FaqCategory.key' => 'default');
		}

		return $this->find('all', array(
			'fields' => $fields,
			'conditions' => $conditions,
			'order' => $order,
			'callbacks' => false,
		));
	}

/**
 * getDefaultFaqCategoryId
 *
 * @param int $blockId blocks.id
 * @return int
 */
	public function getDefaultFaqCategoryId($blockId) {
		$conditions = array(
			'FaqCategory.block_id' => $blockId,
			'FaqCategory.key' => self::DEFAULT_FAQ_CATEGORY_KEY,
		);
		$faqCategory = $this->find('first', array('conditions' => $conditions));

		return $faqCategory['FaqCategory']['id'];
	}

/**
 * saveCategory
 *
 * @param array $postData received post data
 * @param int $blockId blocks.id
 * @param string $blockKey blocks.key
 * @return boolean
 * @throws InternalErrorException
 */
	public function saveCategory($postData, $blockId, $blockKey) {
		//validationを実行
		if (! $this->__validateCategory($postData, $blockId)) {
			return false;
		}

		//DBへの登録
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {

			$category = $this->save();
			if (! $category) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// カテゴリ新規登録の場合、カテゴリ順序の登録
			if (isset($category['FaqCategory']['key'])) {
				// weightの最大値取得
				$weight = $this->FaqCategoryOrder->getMaxWeight($blockKey);

				$faqCategoryOrder = array(
					'FaqCategoryOrder' => array(
						'block_key' => $blockKey,
						'faq_category_key' => $category['FaqCategory']['key'],
						'weight' => ++$weight,
					));
				if (! $this->FaqCategoryOrder->save($faqCategoryOrder)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				};

			}

			$dataSource->commit();
			return true;
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}

/**
 * validate category
 *
 * @param array $postData received post data
 * @param int $blockId blocks.id
 * @return mixed object announcement, false error
 */
	private function __validateCategory($postData, $blockId) {
		// カテゴリ新規登録の場合
		if (empty($postData['FaqCategory']['id'])) {
			$postData['FaqCategory']['block_id'] = $blockId;
			// keyの生成
			$postData['FaqCategory']['key'] = hash('sha256', 'faq_' . microtime());
		}

		$this->set($postData);
		return $this->validates();
	}

/**
 * _saveDefaultCategory
 *
 * @param int $blockId blocks.id
 * @return array
 */
	protected function _saveDefaultCategory($blockId) {
		$faqCategory = array(
			'FaqCategory' => array(
				'block_id' => $blockId,
				'key' => self::DEFAULT_FAQ_CATEGORY_KEY,
				'name' => self::DEFAULT_FAQ_CATEGORY_NAME,
			)
		);
		return $this->save($faqCategory);
	}

/**
 * deleteCategory
 *
 * @param int $faqCategoryId faq_categories.id
 * @return void
 * @throws InternalErrorException
 */
	public function deleteCategory($faqCategoryId) {
		$models = array(
			'FaqFrameSetting' => 'Faqs.FaqFrameSetting',
			'FaqCategoryOrder' => 'Faqs.FaqCategoryOrder',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}

		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			// 対象カテゴリの情報取得
			$this->unbindModel(array(
				'belongsTo' => array('Block'),
				'hasMany' => array('Faq'),
			));
			$faqCategory = $this->findById($faqCategoryId);

			//対象カテゴリに属するFAQを、デフォルトカテゴリに属するよう更新
			$fields = array(
				'Faq.faq_category_id' => $this->getDefaultFaqCategoryId($faqCategory['FaqCategory']['block_id'])
			);
			$conditions = array('Faq.faq_category_id' => $faqCategoryId);
			if (! $this->Faq->updateAll($fields, $conditions)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 対象カテゴリが表示カテゴリの場合、表示カテゴリをデフォルトカテゴリに更新
			$fields = array('FaqFrameSetting.display_category' => 0);
			$conditions = array('FaqFrameSetting.display_category' => $faqCategoryId);
			if (! $this->FaqFrameSetting->updateAll($fields, $conditions)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 対象カテゴリの順序削除
			if (! $this->FaqCategoryOrder->delete($faqCategory['FaqCategoryOrder']['faq_category_key'])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 対象カテゴリより下位の順序を繰り上げる
			$fields = array('FaqCategoryOrder.weight' => 'FaqCategoryOrder.weight - 1');
			$conditions = array(
				'FaqCategoryOrder.block_key' => $faqCategory['FaqCategoryOrder']['block_key'],
				'FaqCategoryOrder.weight >=' => $faqCategory['FaqCategoryOrder']['weight'],
			);
			$this->FaqCategoryOrder->updateAll($fields, $conditions);

			// 対象カテゴリの削除
			$conditions = array('FaqCategory.key' => $faqCategory['FaqCategory']['key']);
			if (! $this->deleteAll($conditions)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();

		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}

/**
 * saveInitialSetting
 *
 * @param int $frameId frames.id
 * @param string $frameKey frames.key
 * @return array
 * @throws InternalErrorException
 */
	public function saveInitialSetting($frameId, $frameKey) {
		$this->setDataSource('master');
		//モデル定義
		$models = array(
			'Block' => 'Blocks.Block',
			'FaqFrameSetting' => 'Faqs.FaqFrameSetting',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
			$this->$model->setDataSource('master');
		}

		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			//ブロックの登録
			$block = $this->Block->saveByFrameId($frameId);
			if (! $block) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// フレーム設定の初期登録（frameKey）
			if (! $this->FaqFrameSetting->saveSettingInit($frameKey)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// デフォルトカテゴリの登録（blockId）
			if (! $this->_saveDefaultCategory($block['Block']['id'])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();

			//setDataSource('master')をslave1に戻す
			$this->setDataSource('slave1');
			foreach ($models as $model => $class) {
				$this->$model->setDataSource('slave1');
			}

			return $block;
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}

}
