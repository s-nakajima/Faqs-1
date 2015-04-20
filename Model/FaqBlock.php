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
 * Save block
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function saveBlock($data) {
		$this->loadModels([
			'Block' => 'Blocks.Block',
			'Frame' => 'Frames.Frame',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			if (! $this->Block->validateBlock($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Block->validationErrors);
				return false;
			}
			//ブロックの登録
			$this->Block->saveByFrameId($data['Frame']['id']);

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
 * validate block
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
//	private function __validateBlock($data) {
//		$this->set($data);
//		$this->validates();
//		return $this->validationErrors ? false : true;
//	}

	/* frame setting E N D */
}
