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
 * Alias name for model.
 *
 * @var string
 */
	public $alias = 'Block';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Get block data
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms.id
 * @return array
 */
	public function getBlock($blockId, $roomId) {
		$conditions = array(
			$this->alias . '.id' => $blockId,
			$this->alias . '.room_id' => $roomId,
		);

		$block = $this->find('first', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);

		return $block;
	}

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
 * Delete bbses
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteBlock($data) {
		$this->setDataSource('master');

		$this->loadModels([
			'Faq' => 'Faqs.Faq',
			'FaqOrder' => 'Faqs.FaqOrder',
			'Block' => 'Blocks.Block',
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//Faqデータ削除
			$this->Faq->deleteByBlockKey($data['Block']['key']);

			//FaqOrderデータ削除
			if (! $this->FaqOrder->deleteAll(array($this->FaqOrder->alias . '.block_key' => $data['Block']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Blockデータ削除
			$this->Block->deleteBlock($data['Block']['key']);

			//BlockRolePermissionデータ削除
			if (! $this->BlockRolePermission->deleteAll(array($this->BlockRolePermission->alias . '.block_key' => $data['Block']['key']), true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//TODO:Category、Comment

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
