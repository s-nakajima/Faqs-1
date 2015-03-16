<?php
/**
 * Faq Model
 *
 * @property Category $Category
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
		'FaqOrder' => array(
			'className' => 'Faqs.FaqOrder',
			'foreignKey' => 'key',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Categories.Category',
			'foreignKey' => 'category_id',
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
			'category_id' => array(
				'inList' => array(
					'rule' => array('inList', $options['idList']),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
					'allowEmpty' => true,
				),
			),

			//status to set in PublishableBehavior.

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
 * getFaqList
 *
 * @param int $blockId blocks.id
 * @param int $categoryId categories.id
 * @return array
 */
	public function getFaqList($blockId, $categoryId = null) {
		$options = array(
			'fields' => array(
				'Faq.id',
				'Faq.block_id',
				'Faq.category_id',
				'Faq.status',
				'Faq.question',
				'Faq.answer',
				'Faq.created_user',
				'FaqOrder.id',
				'FaqOrder.faq_key',
				'FaqOrder.weight',
			),
			'conditions' => array(
				'Faq.block_id' => $blockId,
			),
			'order' => 'FaqOrder.weight',
		);
		if ($categoryId) {
			$options['conditions']['Faq.category_id'] = $categoryId;
		}

		// ユーザのロール権限に従って取得データを制御する
		// 編集権限:keyカラムでグループ化 && 最新記事
		// 作成権限:keyカラムでグループ化 && (自分記事：最新記事、他人記事：statusが公開 && 最新記事)
		// 参照権限:keyカラムでグループ化 && statusが公開 && 最新記事

		$faqList = $this->find('all', $options);
		return $faqList;
	}

/**
 * getFaq
 *
 * @param int $faqId faqs.id
 * @param int $blockId blocks.id
 * @return array
 */
	public function getFaq($faqId, $blockId = 0) {
		$options = array(
			'recursive' => -1,
			'conditions' => array('Faq.id' => $faqId),
		);
		$faq = $this->find('first', $options);

		return $faq;
	}

/**
 * saveFaq
 *
 * @param array $data received post data
 * @param int $blockId blocks.id
 * @param int $blockKey blocks.key
 * @return void
 * @throws InternalErrorException
 */
	public function saveFaq($data, $blockId, $blockKey) {
		$this->loadModels([
			'Category' => 'Faqs.Category',
			'FaqOrder' => 'Faqs.FaqOrder',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->__validateFaq($data, $blockId)) {
				return false;
			}
			if (!$this->Comment->validateByStatus($data, array('caller' => $this->name))) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
				return false;
			}

			$faq = $this->save(null, false);
			if (! $faq) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// FAQ新規登録の場合、FAQ順序の登録
			if (! isset($data['Faq']['id'])) {
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
			//コメントの登録
			if ($this->Comment->data) {
				if (! $this->Comment->save(null, false)) {
					// @codeCoverageIgnoreStart
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					// @codeCoverageIgnoreEnd
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
 * @param array $data received post data
 * @param int $blockId blocks.id
 * @return bool validation result
 */
	private function __validateFaq($data, $blockId) {
		$this->set($data);
		$options = array('idList' => $this->Category->getCategoryFieldList($blockId, 'id'));
		$this->validates($options);
		return $this->validationErrors ? false : true;
	}

/**
 * deleteFaq
 *
 * @param int $faqId faqs.id
 * @return bool
 * @throws InternalErrorException
 */
	public function deleteFaq($faqId) {
		// モデル定義
		$models = array('FaqOrder' => 'Faqs.FaqOrder');
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}

		// 対象FAQの情報取得
		$this->unbindModel(array('belongsTo' => array('Category')));
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

/**
 * deleteBlock
 *
 * @param array $block target block
 * @return void
 * @throws InternalErrorException
 */
	public function deleteBlock($block) {
		$this->loadModels([
			'Faq' => 'Faqs.Faq',
			'FaqOrder' => 'Faqs.FaqOrder',
			'Category' => 'Categories.Category',
			'CategoryOrder' => 'Categories.CategoryOrder',
			'Block' => 'Blocks.Block',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			$exception = new InternalErrorException(__d('net_commons', 'Internal Server Error'));

			// コメントの削除

			// FAQ順の削除
			$conditions = array('FaqOrder.block_key' => $block['Block']['key']);
			if (! $this->FaqOrder->deleteAll($conditions)) {
				throw $exception;
			}

			// FAQの削除
			$conditions = array('Faq.block_id' => $block['Block']['id']);
			if (! $this->deleteAll($conditions)) {
				throw $exception;
			}

			// カテゴリ順の削除
			$conditions = array('CategoryOrder.block_key' => $block['Block']['key']);
			if (! $this->CategoryOrder->deleteAll($conditions)) {
				throw $exception;
			}

			// カテゴリの削除
			$conditions = array('Category.block_id' => $block['Block']['id']);
			if (! $this->Category->deleteAll($conditions)) {
				throw $exception;
			}

			// ブロックの削除
			if (! $this->Block->delete($block['Block']['id'])) {
				throw $exception;
			}

			$dataSource->commit();
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}
}
