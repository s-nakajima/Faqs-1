<?php
/**
 * Faq Model
 *
 * @property Block $Block
 * @property FaqQuestionAnswer $FaqQuestionAnswer
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
class Faq extends FaqsAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey'
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'FaqQuestion' => array(
			'className' => 'FaqQuestion',
			'foreignKey' => 'faq_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
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
		$this->validate = Hash::merge($this->validate, array(
			'key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'name' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'is_auto_translated' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get faq data
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms.id
 * @return array
 */
	public function getFaq($blockId, $roomId) {
		$conditions = array(
			'Block.id' => $blockId,
			'Block.room_id' => $roomId,
		);

		$faq = $this->find('first', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);

		return $faq;
	}

/**
 * Save faq
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveFaq($data) {
		$this->loadModels([
			'Faq' => 'Faqs.Faq',
			'FaqSetting' => 'Faqs.FaqSetting',
			'Block' => 'Blocks.Block',
			'Frame' => 'Frames.Frame',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			if (! $this->validateFaq($data, ['faqSetting', 'block'])) {
				return false;
			}

			//ブロックの登録
			$block = $this->Block->saveByFrameId($data['Frame']['id']);

			//登録処理
			$this->data['Faq']['block_id'] = (int)$block['Block']['id'];
			if (! $faq = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$this->FaqSetting->data['FaqSetting']['faq_key'] = $faq['Faq']['key'];
			if (! $this->FaqSetting->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
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
 * validate faq
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on validation errors
 */
	public function validateFaq($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}

		if (in_array('faqSetting', $contains, true)) {
			if (! $this->FaqSetting->validateFaqSetting($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->FaqSetting->validationErrors);
				return false;
			}
		}

		if (in_array('block', $contains, true)) {
			if (! $this->Block->validateBlock($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Block->validationErrors);
				return false;
			}
		}
		return true;
	}

/**
 * Delete faq
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteFaq($data) {
		$this->setDataSource('master');

		$this->loadModels([
			'Faq' => 'Faqs.Faq',
			'FaqSetting' => 'Faqs.FaqSetting',
			//'FaqPost' => 'Faqs.FaqPost',
			//'FaqPostI18n' => 'Faqs.FaqPostI18n',
			'Block' => 'Blocks.Block',
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
			//'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->deleteAll(array($this->alias . '.key' => $data['Faq']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->FaqSetting->deleteAll(array($this->FaqSetting->alias . '.faq_key' => $data['Faq']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//if (! $this->FaqPost->deleteAll(array($this->FaqPost->alias . '.faq_key' => $data['Faq']['key']), true)) {
			//	throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			//}

			//Blockデータ削除
			$this->Block->deleteBlock($data['Block']['key']);

			//BlockRolePermissionデータ削除
			if (! $this->BlockRolePermission->deleteAll(array($this->BlockRolePermission->alias . '.block_key' => $data['Block']['key']), true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
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

}
