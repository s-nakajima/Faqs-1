<?php
/**
 * Test of FaqQuestionOrder->validateFaqQuestionOrder()
 *
 * @property FaqQuestionOrder $FaqQuestionOrder
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqQuestionOrderTest', 'Faqs.Test/Case/Model');

/**
 * Test of FaqQuestionOrder->validateFaqQuestionOrder()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqQuestionOrderTestValidateFaqQuestionOrder extends FaqQuestionOrderTest {

/**
 * __assertValidationError
 *
 * @param string $field Field name
 * @param array $data Save data
 * @param array $expected Expected value
 * @return void
 */
	//private function __assertValidationError($field, $data, $expected) {
	//	//初期処理
	//	$this->setUp();
	//	//validate処理実行
	//	$result = $this->FaqQuestionOrder->validateFaqQuestionOrder($data);
	//	//戻り値チェック
	//	$expectMessage = 'Expect `' . $field . '` field, error data: ' . print_r($data, true);
	//	$this->assertFalse($result, $expectMessage);
	//	//validationErrorsチェック
	//	$this->assertEquals($this->FaqQuestionOrder->validationErrors, $expected);
	//	//終了処理
	//	$this->tearDown();
	//}

/**
 * Expect to validate the FaqQuestionOrders
 *
 * @return void
 */
	public function test() {
	}

}
