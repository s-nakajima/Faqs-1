<?php
/**
 * Test of FaqQuestion->validateFaqQuestion()
 *
 * @property FaqQuestion $FaqQuestion
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqQuestionTest', 'Faqs.Test/Case/Model');

/**
 * Test of FaqQuestion->validateFaqQuestion()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqQuestionTestValidateFaqQuestion extends FaqQuestionTest {

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
	//	$result = $this->validateFaqQuestion($data, ['faqQuestionOrder', 'comment']);
	//	//戻り値チェック
	//	$expectMessage = 'Expect `' . $field . '` field, error data: ' . print_r($data, true);
	//	$this->assertFalse($result, $expectMessage);
	//	//validationErrorsチェック
	//	$this->assertEquals($this->FaqQuestion->validationErrors, $expected);
	//	//終了処理
	//	$this->tearDown();
	//}

/**
 * Expect to validate the FaqQuestion
 *
 * @return void
 */
	public function test() {
	}

}
