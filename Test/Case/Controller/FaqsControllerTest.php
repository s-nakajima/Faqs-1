<?php
/**
 * FaqsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsController', 'Faqs.Controller');

/**
 * FaqsController Test Case
 */
class FaqsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.faqs.faq',
		'plugin.faqs.site_setting',
		'plugin.faqs.site_setting_value'
	);

}
