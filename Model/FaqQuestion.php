<?php
/**
 * FaqQuestion Model
 *
 * @property Faq $Faq
 * @property Category $Category
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppModel', 'Faqs.Model');

/**
 * Faq Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Model
 */
class FaqQuestion extends FaqsAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Publishable',
		'NetCommons.OriginalKey',
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'FaqQuestionOrder' => array(
			'className' => 'Faqs.FaqQuestionOrder',
			'foreignKey' => false,
			'conditions' => 'FaqQuestionOrder.faq_question_key=FaqQuestion.key',
			'fields' => '',
			'order' => array('FaqQuestionOrder.weight' => 'ASC')
		),
		'Faq' => array(
			'className' => 'Faqs.Faq',
			'foreignKey' => 'faq_id',
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
		'CategoryOrder' => array(
			'className' => 'Categories.CategoryOrder',
			'foreignKey' => false,
			'conditions' => 'CategoryOrder.category_key=Category.key',
			'fields' => '',
			'order' => ''
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
		$this->validate = Hash::merge($this->validate, array(
			'faq_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),

			//status to set in PublishableBehavior.

			'question' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('faqs', 'Question')),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'answer' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('faqs', 'Answer')),
					'allowEmpty' => false,
					'required' => true,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get FaqQuestions
 *
 * @param array $conditions findAll conditions
 * @return array FaqQuestions
 */
	public function getFaqQuestions($conditions) {
		$faqQuestions = $this->find('all', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);
		return $faqQuestions;
	}

/**
 * Get FaqQuestion
 *
 * @param int $faqId faqs.id
 * @param string $faqQuestionKey faq_qestions.key
 * @param array $conditions find conditions
 * @return array FaqQuestion
 */
	public function getFaqQuestion($faqId, $faqQuestionKey, $conditions = []) {
		$conditions[$this->alias . '.faq_id'] = $faqId;
		$conditions[$this->alias . '.key'] = $faqQuestionKey;

		$faqQuestion = $this->find('first', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);

		return $faqQuestion;
	}

/**
 * Save FaqQuestion
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveFaqQuestion($data) {
		$this->loadModels([
			'FaqQuestion' => 'Faqs.FaqQuestion',
			'FaqQuestionOrder' => 'Faqs.FaqQuestionOrder',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			if (! $this->validateFaqQuestion($data, ['faqQuestionOrder', 'comment'])) {
				return false;
			}

			//FaqQuestion登録
			if (! $faqQuestion = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//FaqQuestionOrder登録
			if (! $data['FaqQuestionOrder']['faq_question_key']) {
				$this->FaqQuestionOrder->data['FaqQuestionOrder']['faq_question_key'] = $faqQuestion[$this->alias]['key'];
				$this->FaqQuestionOrder->data['FaqQuestionOrder']['weight'] = $this->FaqQuestionOrder->getMaxWeight($data['Faq']['key']) + 1;
			}
			if (! $this->FaqQuestionOrder->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//Comment登録
			if (isset($data['Comment']) && $this->Comment->data) {
				$this->Comment->data[$this->Comment->name]['content_key'] = $faqQuestion[$this->name]['key'];
				if (! $this->Comment->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * validate of FaqQuestion
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on validation errors
 */
	public function validateFaqQuestion($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		if (in_array('faqQuestionOrder', $contains, true)) {
			if (! $this->FaqQuestionOrder->validateFaqQuestionOrder($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->FaqQuestionOrder->validationErrors);
				return false;
			}
		}
		if (in_array('comment', $contains, true) && isset($data['Comment'])) {
			if (! $this->Comment->validateByStatus($data, array('plugin' => 'faqs', 'caller' => $this->name))) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
				return false;
			}
		}
		return true;
	}

/**
 * Delete FaqQuestion
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteFaqQuestion($data) {
		$this->loadModels([
			'FaqQuestion' => 'Faqs.FaqQuestion',
			'FaqQuestionOrder' => 'Faqs.FaqQuestionOrder',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->deleteAll(array($this->alias . '.key' => $data['FaqQuestion']['key']), true, true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$this->FaqQuestionOrder->data = array(
				$this->FaqQuestionOrder->name => array(
					'faq_question_key' => $data['FaqQuestion']['key'],
				)
			);
			if (! $this->FaqQuestionOrder->deleteAll(
				$this->FaqQuestionOrder->data[$this->FaqQuestionOrder->name], true, true
			)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

}
