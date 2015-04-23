<?php
/**
 * FaqOrder Model
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

		return (isset($faqOrder[0]['weight'])) ? $faqOrder[0]['weight'] : 0;
	}

/**
 * saveFaqOrders
 *
 * @param array $dataList received post data
 * @param int $blockKey blocks.key
 * @return void
 * @throws InternalErrorException
 */
	public function saveFaqOrders($dataList, $blockKey) {
		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			foreach ($dataList as $index => $data) {
				$options = array('conditions' =>
					array(
						'faq_key' => $data['FaqOrder']['faq_key'],
						'block_key' => $blockKey,
					));
				if (!$faqOrder = $this->find('first', $options)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
				// FAQ順の更新
				$faqOrder['FaqOrder']['weight'] = $index + 1;
				if (! $this->save($faqOrder, false)) {
					// @codeCoverageIgnoreStart
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					// @codeCoverageIgnoreEnd
				}
			}
			$dataSource->commit();
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}
}
