<?php
/**
 * FaqFrameSetting Model Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqAppModelTest', 'Faqs.Test/Case/Model');

/**
 * FaqFrameSetting Model Test Case
 */
class FaqFrameSettingTest extends FaqAppModelTest {

/**
 * testGetFaqSetting method
 *
 * @return void
 */
	public function testGetFaqSetting() {
		$frameKey = 'frame_1';
		$result = $this->FaqFrameSetting->getFaqSetting($frameKey);

		$expected = array(
			'FaqFrameSetting' => array(
				'id' => '1',
				'frame_key' => $frameKey,
				'display_category' => '0',
				'display_number' => '1'
			)
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * testSaveSettingInit method
 *
 * @return void
 */
	public function testSaveSettingInit() {
		$frameKey = 'frame_2';
		$this->FaqFrameSetting->saveSettingInit($frameKey);

		$result = $this->FaqFrameSetting->getFaqSetting($frameKey);
		$expected = array(
			'FaqFrameSetting' => array(
				'id' => '2',
				'frame_key' => $frameKey,
				'display_category' => FaqFrameSetting::DEFAULT_DISPLAY_CATEGORY_ID,
				'display_number' => FaqFrameSetting::DEFAULT_DISPLAY_NUMBER
			)
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * testGetDisplayNumberOptions method
 *
 * @return void
 */
	public function testGetDisplayNumberOptions() {
		$result = $this->FaqFrameSetting->getDisplayNumberOptions();

		$expected = array(
			1 => 1 . FaqFrameSetting::DISPLAY_NUMBER_UNIT,
			5 => 5 . FaqFrameSetting::DISPLAY_NUMBER_UNIT,
			10 => 10 . FaqFrameSetting::DISPLAY_NUMBER_UNIT,
			20 => 20 . FaqFrameSetting::DISPLAY_NUMBER_UNIT,
			50 => 50 . FaqFrameSetting::DISPLAY_NUMBER_UNIT,
			100 => 100 . FaqFrameSetting::DISPLAY_NUMBER_UNIT,
		);

		$this->_assertArray(null, $expected, $result);
	}
}
