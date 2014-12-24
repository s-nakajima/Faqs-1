<?php
/**
 * Faq Model Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqAppModelTest', 'Faqs.Test/Case/Model');

/**
 * Faq Model Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqTest extends FaqAppModelTest {

/**
 * testGetFaq method
 *
 * @return void
 */
	public function testGetFaq() {
		$faqId = 1;
		$displayCategoryId = 1;
		$blockId = 1;
		$result = $this->Faq->getFaq($faqId, $displayCategoryId, $blockId);

		$expected = array(
			'Faq' => array(
					'id' => '1',
					'faq_category_id' => '1',
					'key' => 'faq_1',
					'status' => '1',
					'question' => 'question_1',
					'answer' => 'answer_1',
			),
			'FaqOrder' => array(
					'id' => '1',
					'faq_key' => 'faq_1',
					'block_key' => 'block_1',
					'weight' => '1',
			)
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * testGetFaqInit method
 *
 * @return void
 */
	public function testGetFaqInit() {
		$faqId = null;
		$displayCategoryId = 0;
		$blockId = 1;
		$result = $this->Faq->getFaq($faqId, $displayCategoryId, $blockId);

		$expected = array(
			'Faq' => array(
				'id' => null,
				'faq_category_id' => 1,
				'status' => null,
				'question' => null,
				'answer' => null,
			)
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * testSaveFaq method
 *
 * @return void
 */
	public function testSaveFaqByAdd() {
		$faqId = null;
		$faqCategoryId = 1;
		$blockKey = 'block_1';
		$blockId = 1;

		$postData = array(
			'Faq' => array(
				'id' => $faqId,
				'faq_category_id' => $faqCategoryId,
				'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
				'question' => 'add question',
				'answer' => 'add answer',
			),
		);
		$this->Faq->saveFaq($postData, $blockKey);

		$faqId = 2;
		$result = $this->Faq->getFaq($faqId, $faqCategoryId, $blockId);

		$expected = array(
			'Faq' => array(
					'id' => $faqId,
					'faq_category_id' => $faqCategoryId,
					'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
					'question' => 'add question',
					'answer' => 'add answer',
			),
			'FaqOrder' => array(
					'id' => '2',
					'block_key' => 'block_1',
					'weight' => '2',
			)
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * testSaveFaqByEdit method
 *
 * @return void
 */
	public function testSaveFaqByEdit() {
		$faqId = 1;
		$faqCategoryId = 1;
		$blockKey = 'block_1';
		$blockId = 1;

		$postData = array(
			'Faq' => array(
				'id' => $faqId,
				'faq_category_id' => $faqCategoryId,
				'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
				'question' => 'edit question',
				'answer' => 'edit answer',
			),
		);
		$this->Faq->saveFaq($postData, $blockKey);

		$result = $this->Faq->getFaq($faqId, $faqCategoryId, $blockId);

		$expected = array(
			'Faq' => array(
					'id' => $faqId,
					'faq_category_id' => $faqCategoryId,
					'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
					'question' => 'edit question',
					'answer' => 'edit answer',
			),
			'FaqOrder' => array(
					'id' => '1',
					'block_key' => 'block_1',
					'weight' => '1',
			)
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * testDeleteFaqSuccess method
 *
 * @return void
 */
	public function testDeleteFaqSuccess() {
		$faqId = 1;
		$faqCategoryId = 1;
		$blockId = 1;

		$result = $this->Faq->deleteFaq($faqId);
		$this->assertTrue($result);

		$result = $this->Faq->getFaq($faqId, $faqCategoryId, $blockId);
		$expected = array(
			'Faq' => array(
				'id' => null,
				'faq_category_id' => $faqCategoryId,
				'status' => null,
				'question' => null,
				'answer' => null,
			)
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * testDeleteFaqFailure method
 *
 * @return void
 */
	public function testDeleteFaqFailure() {
		$faqId = 0;
		$result = $this->Faq->deleteFaq($faqId);

		$this->assertFalse($result);
	}
}
