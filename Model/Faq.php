<?php
/**
 * Faq Model
 *
 * @property FaqCategory $FaqCategory
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppModel', 'Faqs.Model');

/**
 * Faq Model
 */
class Faq extends FaqsAppModel {

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
		'FaqCategory' => array(
			'className' => 'Faqs.FaqCategory',
			'foreignKey' => 'faq_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FaqOrder' => array(
			'className' => 'Faqs.FaqOrder',
			'foreignKey' => 'key',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
			'faq_category_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'status' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
				'inList' => array(
					'rule' => array('inList', NetCommonsBlockComponent::$STATUSES),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
			'question' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('faqs', 'question')),
				),
			),
			'answer' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('faqs', 'answer')),
				),
			),
		);

		return parent::beforeValidate($options);
	}

/**
 * getFaq
 *
 * @param int $faqId faqs.id
 * @param int $displayCategoryId faq_frame_settings.display_category
 * @param int $blockId blocks.id
 * @return array
 */
	public function getFaq($faqId, $displayCategoryId, $blockId = 0) {
		$this->unbindModel(array(
			'belongsTo' => array('FaqCategory'),
		));

		$faq = $this->findById($faqId);
		if (empty($faq)) {
			if (! $displayCategoryId) {
				// デフォルトカテゴリのidを取得
				$displayCategoryId = $this->FaqCategory->getDefaultFaqCategoryId($blockId);
			}

			// 初期情報の設定
			$faq = array(
				'Faq' => array(
					'id' => null,
					'faq_category_id' => $displayCategoryId,
					'status' => null,
					'question' => null,
					'answer' => null,
				)
			);
		}

		return $faq;
	}

/**
 * saveFaq
 *
 * @param array $postData received post data
 * @param int $blockKey blocks.key
 * @return void
 * @throws InternalErrorException
 */
	public function saveFaq($postData, $blockKey) {
		// モデル定義
		$models = array(
			'FaqCategory' => 'Faqs.FaqCategory',
			'FaqOrder' => 'Faqs.FaqOrder',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}

		//validationを実行
		if (! $this->__validateFaq($postData)) {
			return false;
		}

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			$faq = $this->save();
			if (! $faq) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// FAQ新規登録の場合、FAQ順序の登録
			if (isset($faq['Faq']['key'])) {
				// weightの最大値取得
				$weight = $this->FaqOrder->getMaxWeight($blockKey);
				$faqOrder = array(
					'FaqOrder' => array(
						'block_key' => $blockKey,
						'faq_key' => $faq['Faq']['key'],
						'weight' => ++$weight,
					));
				if (! $this->FaqOrder->save($faqOrder)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
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
 * validate faq
 *
 * @param array $postData received post data
 * @return mixed object announcement, false error
 */
	private function __validateFaq($postData) {
		// FAQ新規登録の場合、keyを生成
		if (empty($postData['Faq']['id'])) {
			$postData['Faq']['key'] = hash('sha256', 'faq_' . microtime());
		}
		$this->set($postData);
		return $this->validates();
	}

/**
 * deleteFaq
 *
 * @param int $faqId faqs.id
 * @return boolean
 * @throws InternalErrorException
 */
	public function deleteFaq($faqId) {
		// モデル定義
		$models = array(
			'FaqOrder' => 'Faqs.FaqOrder',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}

		// 対象FAQの情報取得
		$this->unbindModel(array(
			'belongsTo' => array('FaqCategory'),
		));
		$faq = $this->findById($faqId);
		if (empty($faq)) {
			return false;
		}

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {

			// 対象FAQの順序削除
			$result = $this->FaqOrder->delete($faq['FaqOrder']['faq_key']);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 対象FAQより下位の順序を繰り上げる
			$fields = array('FaqOrder.weight' => 'FaqOrder.weight - 1');
			$conditions = array(
				'FaqOrder.block_key' => $faq['FaqOrder']['block_key'],
				'FaqOrder.weight >=' => $faq['FaqOrder']['weight'],
			);
			$result = $this->FaqOrder->updateAll($fields, $conditions);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 対象FAQの削除
			$conditions = array('Faq.key' => $faq['Faq']['key']);
			$result = $this->deleteAll($conditions);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();
			return true;
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}
}
