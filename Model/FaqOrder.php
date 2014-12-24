<?php
/**
 * FaqOrder Model
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
 * FaqOrder Model
 */
class FaqOrder extends FaqsAppModel {

	const MIN_WEIGHT = 1;

/**
 * Primary Key
 *
 * @var string
 */
	public $primaryKey = 'faq_key';

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
		$faqOrder = $this->find('first', array(
				'fields' => array('MAX(FaqOrder.weight) as weight'),
				'conditions' => array('FaqOrder.block_key' => $blockKey),
			));

		// カテゴリ順序が登録されていない場合
		if (! isset($faqOrder[0]['weight'])) {
			return 0;
		}

		return $faqOrder[0]['weight'];
	}

/**
 * changeFaqOrder
 *
 * @param array $postData received post data
 * @param int $blockKey blocks.key
 * @return void
 * @throws InternalErrorException
 */
	public function changeFaqOrder($postData, $blockKey) {
		$changeType = $postData['FaqOrder']['type'];
		$destinationWeight = $postData['FaqOrder']['destinationWeight'];
		$target = $postData['FaqOrder']['target'];

		$targetFields = array('weight' => $destinationWeight);
		$targetConditions = array(
			'block_key' => $blockKey,
			'weight' => $target['weight'],
		);
		$otherFields = array();
		$otherConditions = array();

		if ($changeType === 'up') {

			if ($target['weight'] <= self::MIN_WEIGHT) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 対象FAQを繰り上げた後、移動範囲内のFAQを1繰り下げる
			$otherFields = array('weight' => 'weight + 1');
			$otherConditions = array(
				'block_key' => $blockKey,
				'weight >=' => $destinationWeight,
				'weight <=' => $target['weight'],
				'NOT' => array('faq_key' => ($target['faq_key'])),
			);

		} elseif ($changeType === 'down') {

			if ($target['weight'] >= $this->getMaxWeight($blockKey)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 対象FAQを繰り下げた後、移動範囲内のFAQを1繰り上げる
			$otherFields = array('weight' => 'weight - 1');
			$otherConditions = array(
				'block_key' => $blockKey,
				'weight >=' => $target['weight'],
				'weight <=' => $destinationWeight,
				'NOT' => array('faq_key' => ($target['faq_key'])),
			);
		}

		// 対象FAQの移動
		$result = $this->updateAll($targetFields, $targetConditions);
		if (! $result) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		// 移動範囲内FAQの移動
		$result = $this->updateAll($otherFields, $otherConditions);
		if (! $result) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
	}
}
