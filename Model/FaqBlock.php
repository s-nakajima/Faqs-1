<?php
/**
 * FaqBlock Model
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
 * FaqBlock Model
 */
class FaqBlock extends FaqsAppModel {

/**
 * type private
 *
 * @var string
 */
	const TYPE_PRIVATE = '0';

/**
 * type public
 *
 * @var string
 */
	const TYPE_PUBLIC = '1';

/**
 * type limited public
 *
 * @var string
 */
	const TYPE_LIMITED_PUBLIC = '2';

/**
 * Custom database table name
 *
 * @var string
 */
	public $useTable = 'blocks';

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
			'name' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('Blocks', 'name')),
					'required' => false,
				),
			),
			'public_type' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
				'inList' => array(
					'rule' => array('inList', array('0', '1', '2')),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'from' => array(
				'datetime' => array(
					'rule' => array('datetime', 'ymd'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
			),
			'to' => array(
				'datetime' => array(
					'rule' => array('datetime', 'ymd'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
				'custom' => array(
					'rule' => array('checkFromTo', 'FaqBlock'),
					'message' => '開始日より大きい日付を入力してください。',
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * custom validate check from to
 *
 * @param array $target target form
 * @param string $modelName model name
 * @return bool True if the operation should continue, false if it should abort
 */
	public function checkFromTo($target, $modelName) {
		$from = $this->data[$modelName]['from'];
		$to = $this->data[$modelName]['to'];
		if ($from <= $to) {
			return true;
		}
		return false;
	}

/**
 * before save
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if the operation should continue, false if it should abort
 */
	public function beforeSave($options = array()) {
		if (! isset($this->data[$this->name]['id']) && ! isset($this->data[$this->name]['key'])) {
			$this->data[$this->name]['key'] = Security::hash($this->name . mt_rand() . microtime());
		}
		return true;
	}

	/* frame setting START */

/**
 * save block
 *
 * @param array $data received post data
 * @param array $frame frames data
 * @return bool True on success, false on error
 * @throws InternalErrorException
 */
	public function saveBlock($data, $frame) {
		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			if ($data['FaqBlock']['public_type'] !== self::TYPE_LIMITED_PUBLIC) {
				unset($data['FaqBlock']['from']);
				unset($data['FaqBlock']['to']);
			}

			// バリデーション
			if (! $this->__validateBlock($data)) {
				return false;
			}

			if (empty($data['FaqBlock']['id'])) {
				$this->data['FaqBlock']['language_id'] = $frame['Frame']['language_id'];
				$this->data['FaqBlock']['room_id'] = $frame['Frame']['room_id'];
				$this->data['FaqBlock']['plugin_key'] = $frame['Frame']['plugin_key'];
				$this->data['FaqBlock']['key'] = Security::hash('block' . mt_rand() . microtime(), 'md5');
			}
			if (! $this->save(null, false)) {
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
 * validate block
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	private function __validateBlock($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

	/* frame setting E N D */
}