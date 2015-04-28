<?php
/**
 * Faq Model Test Case
 *
 * @property Faq $Faq
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsModelTestCase', 'Faqs.Test/Case/Model');

/**
 * Faq Model Test Case
 */
class FaqErrorTest extends FaqsModelTestCase {

/**
 * Expect Faq->testDeleteFaq() by unknown faqId
 *
 * @return void
 */
	public function testDeleteFaqByUnknownFaqId() {
		$this->setExpectedException('InternalErrorException');

		$faqId = 0;

		//処理実行
		$this->Faq->deleteFaq($faqId);
	}

/**
 * Expect Faq->testDeleteFaq() by delete faqOrder error
 *
 * @return void
 */
	public function testDeleteFaqByDeleteFaqOrderError() {
		$this->setExpectedException('InternalErrorException');

		$faqId = 1;
		$faq = $this->Faq->findById($faqId);
		$this->FaqOrder->delete($faq['FaqOrder']['faq_key']);

		//処理実行
		$this->Faq->deleteFaq($faqId);
	}

/**
 * Expect Faq->testDeleteBlock() by delete block Error
 *
 * @return void
 */
	public function testDeleteBlockByDeleteBlockError() {
		$this->setExpectedException('InternalErrorException');

		$blockId = 1;
		$options = array(
			'recursive' => -1,
			'conditions' => array(
				'FaqBlock.id' => $blockId
			),
		);
		$block = $this->FaqBlock->find('first', $options);
		$this->FaqBlock->delete($blockId);

		//処理実行
		$this->Faq->deleteBlock($block);
	}
}
