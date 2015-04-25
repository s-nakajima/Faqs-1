<?php
/**
 * FaqSetting Model
 *
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('FaqsAppModel', 'Faqs.Model');

/**
 * Summary for FaqSetting Model
 */
class FaqSetting extends FaqsAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

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
			'faq_key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					//'message' => 'Your custom message here',
					'allowEmpty' => false,
					'required' => false,
					//'last' => false, // Stop validation after this rule
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'use_workflow' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'use_comment' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'is_comment_auto_approval' => array(
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
 * Get faq setting data
 *
 * @param string $faqKey faq.key
 * @return array
 */
	public function getFaqSetting($faqKey) {
		$conditions = array(
			'faq_key' => $faqKey
		);

		$faqSetting = $this->find('first', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);

		return $faqSetting;
	}

/**
 * Save faq settings
 *
 * @param array $data received post data
 * @return bool True on success, false on failure
 * @throws InternalErrorException
 */
	public function saveFaqSetting($data) {
		$this->loadModels([
			'FaqSetting' => 'Faqs.FaqSetting',
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->validateFaqSetting($data)) {
				return false;
			}
			foreach ($data[$this->BlockRolePermission->alias] as $value) {
				if (! $this->BlockRolePermission->validateBlockRolePermissions($value)) {
					$this->validationErrors = Hash::merge($this->validationErrors, $this->BlockRolePermission->validationErrors);
					return false;
				}
			}

			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			foreach ($data[$this->BlockRolePermission->alias] as $value) {
				if (! $this->BlockRolePermission->saveMany($value, ['validate' => false])) {
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
 * validate faqSettings
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
	public function validateFaqSetting($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}

}
