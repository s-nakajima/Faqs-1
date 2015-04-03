<?php
/**
 * Faq Model
 *
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
 * Faq Model
 */
class Faq extends FaqsAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Publishable'
	);

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
		$this->validate = Hash::merge($this->validate, array(
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				)
			),
			'category_id' => array(
				'inList' => array(
					'rule' => array('inList', $options['idList']),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
					'allowEmpty' => true,
				),
			),
			'key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				)
			),

			//status to set in PublishableBehavior.

			'question' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('faqs', 'Question')),
					'required' => true,
				),
			),
			'answer' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('faqs', 'Answer')),
					'required' => true,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * getFaqs
 *
 * @param int $blockId blocks.id
 * @param int $categoryId categories.id
 * @return array
 */
	public function getFaqs($blockId, $categoryId = null) {
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

		$faqs = $this->find('all', $options);
		return $faqs;
	}

/**
 * getFaq
 *
 * @param int $faqId faqs.id
 * @return array
 */
	public function getFaq($faqId) {
		$options = array(
			'recursive' => -1,
			'conditions' => array('Faq.id' => $faqId),
		);
		return $this->find('first', $options);
	}

/**
 * saveFaq
 *
 * @param array $data received post data
 * @return void
 * @throws InternalErrorException
 */
	public function saveFaq($data) {
		$this->loadModels([
			'Category' => 'Faqs.Category',
			'FaqOrder' => 'Faqs.FaqOrder',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->__validateFaq($data)) {
				return false;
			}
			if (!$this->Comment->validateByStatus($data, array('caller' => $this->name))) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
				return false;
			}

			$faq = $this->save(null, false);
			if (! $faq) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			// FAQ新規登録の場合、FAQ順序の登録
			if (! isset($data['Faq']['id'])) {
				// weightの最大値取得
				$weight = $this->FaqOrder->getMaxWeight($data['Block']['key']);
				$faqOrder = array(
					'FaqOrder' => array(
						'block_key' => $data['Block']['key'],
						'faq_key' => $faq['Faq']['key'],
						'weight' => $weight + 1,
					));
				if (! $this->FaqOrder->save($faqOrder)) {
					// @codeCoverageIgnoreStart
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					// @codeCoverageIgnoreEnd
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

		}
		// @codeCoverageIgnoreStart
		catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
		// @codeCoverageIgnoreEnd
	}

/**
 * validate faq
 *
 * @param array $data received post data
 * @return bool validation result
 */
	private function __validateFaq($data) {
		$this->set($data);

		$options = array('idList' => $this->Category->getCategoryFieldList($data['Faq']['block_id'], 'id'));
		$options['idList'][] = '0';
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
		$this->loadModels(['FaqOrder' => 'Faqs.FaqOrder']);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			// 対象FAQの情報取得
			$this->unbindModel(array('belongsTo' => array('Category')));
			$faq = $this->findById($faqId);
			if (empty($faq)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

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
			$this->FaqOrder->updateAll($fields, $conditions);

			// 対象FAQの削除
			$conditions = array('Faq.key' => $faq['Faq']['key']);
			$this->deleteAll($conditions);

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
			'FaqBlock' => 'Faqs.FaqBlock',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			$exception = new InternalErrorException(__d('net_commons', 'Internal Server Error'));

			// コメントの削除

			// FAQ順の削除
			$conditions = array('FaqOrder.block_key' => $block['FaqBlock']['key']);
			$this->FaqOrder->deleteAll($conditions);

			// FAQの削除
			$conditions = array('Faq.block_id' => $block['FaqBlock']['id']);
			$this->deleteAll($conditions);

			// カテゴリ順の削除
			$conditions = array('CategoryOrder.block_key' => $block['FaqBlock']['key']);
			$this->CategoryOrder->deleteAll($conditions);

			// カテゴリの削除
			$conditions = array('Category.block_id' => $block['FaqBlock']['id']);
			$this->Category->deleteAll($conditions);

			// ブロックの削除
			if (! $this->FaqBlock->delete($block['FaqBlock']['id'])) {
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
