<?php
/**
 * FaqCategoryOrder.php Model
 *
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppModel', 'Faqs.Model');

/**
 * FaqFrameSetting Model
 */
class FaqCategoryOrder extends FaqsAppModel {

	const MIN_WEIGHT = 1;

/**
 * Primary Key
 *
 * @var string
 */
	public $primaryKey = 'faq_category_key';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * getMaxWeight
 *
 * @param string $blockKey blocks.key
 * @return int
 */
	public function getMaxWeight($blockKey) {
		$faqCategoryOrder = $this->find('first', array(
				'fields' => array('MAX(FaqCategoryOrder.weight) as weight'),
				'conditions' => array('FaqCategoryOrder.block_key' => $blockKey),
			));

		// カテゴリ順序が登録されていない場合
		if (! isset($faqCategoryOrder[0]['weight'])) {
			return 0;
		}
		return $faqCategoryOrder[0]['weight'];
	}

/**
 * changeCategoryOrder
 *
 * @param array $postData received post data
 * @param string $blockKey blocks.key
 * @return void
 * @throws InternalErrorException
 */
	public function changeCategoryOrder($postData, $blockKey) {
		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			$changeType = $postData['FaqCategoryOrder']['type'];
			$faqCategoryKey = $postData['FaqCategoryOrder']['faq_category_key'];
			$targetWeight = (int)$postData['FaqCategoryOrder']['weight'];

			$conditionsUp = array(
				'block_key' => $blockKey,
				'weight' => $targetWeight,
			);
			$conditionsDown = array(
				'block_key' => $blockKey,
				'weight' => $targetWeight,
			);

			if ($changeType === 'up') {

				if ($targetWeight <= self::MIN_WEIGHT) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}

				// 繰り上げ：対象カテゴリ
				// 繰り下げ：対象の１段上カテゴリ（KEYと一致しない方）
				$conditionsDown['weight']--;
				$conditionsDown['NOT'] = array('faq_category_key' => $faqCategoryKey);

			} elseif ($changeType === 'down') {

				if ($targetWeight >= $this->getMaxWeight($blockKey)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}

				// 繰り上げ：対象の１段下カテゴリ
				// 繰り下げ：対象カテゴリ（KEYと一致する方）
				$conditionsUp['weight']++;
				$conditionsDown['faq_category_key'] = $faqCategoryKey;

			}

			// 繰り上げ
			$fields = array('weight' => 'weight - 1');
			$result = $this->updateAll($fields, $conditionsUp);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 繰り上げ
			$fields = array('weight' => 'weight + 1');
			$result = $this->updateAll($fields, $conditionsDown);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();

		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}
}
