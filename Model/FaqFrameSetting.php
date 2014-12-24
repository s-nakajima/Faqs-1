<?php
/**
 * FaqFrameSetting Model
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
class FaqFrameSetting extends FaqsAppModel {

	const DISPLAY_NUMBER_UNIT = '件';
	const DEFAULT_DISPLAY_CATEGORY_ID = 0;
	const DEFAULT_DISPLAY_NUMBER = 5;
	const DEFAULT_PAGE = 1;

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'frame_key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
			),
		),
		'display_number' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);

/**
 * getFaqSetting
 *
 * @param string $frameKey frames.key
 * @return array
 */
	public function getFaqSetting($frameKey) {
		$fields = array(
			'FaqFrameSetting.id',
			'FaqFrameSetting.frame_key',
			'FaqFrameSetting.display_category',
			'FaqFrameSetting.display_number',
		);
		$conditions = array('FaqFrameSetting.frame_key' => $frameKey);
		$faqSetting = $this->find('first', array(
				'fields' => $fields,
				'conditions' => $conditions,
			));

		return $faqSetting;
	}

/**
 * saveSettingInit
 *
 * @param string $frameKey frames.key
 * @return array
 */
	public function saveSettingInit($frameKey) {
		$faqFrameSetting = array(
			'FaqFrameSetting' => array(
				'frame_key' => $frameKey,
				'display_category' => self::DEFAULT_DISPLAY_CATEGORY_ID,
				'display_number' => self::DEFAULT_DISPLAY_NUMBER,
			)
		);

		return $this->save($faqFrameSetting);
	}

/**
 * getDisplayNumberOptions
 *
 * @return array
 */
	public static function getDisplayNumberOptions() {
		return array(
			1 => 1 . self::DISPLAY_NUMBER_UNIT,
			5 => 5 . self::DISPLAY_NUMBER_UNIT,
			10 => 10 . self::DISPLAY_NUMBER_UNIT,
			20 => 20 . self::DISPLAY_NUMBER_UNIT,
			50 => 50 . self::DISPLAY_NUMBER_UNIT,
			100 => 100 . self::DISPLAY_NUMBER_UNIT,
		);
	}
}
