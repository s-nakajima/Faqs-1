<?php
/**
 * Common code of FaqSetting model test
 *
 * @property FaqSetting $FaqSetting
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsBaseModel', 'Faqs.Test/Case/Model');

/**
 * Common code of FaqSetting model test
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqSettingTest extends FaqsBaseModel {

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FaqSetting = ClassRegistry::init('Faqs.FaqSetting');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FaqSetting);
		parent::tearDown();
	}
}
