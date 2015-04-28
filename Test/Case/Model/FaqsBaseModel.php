<?php
/**
 * Common code for test of Faqs
 *
 * @property Faq $Faq
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('YACakeTestCase', 'NetCommons.TestSuite');
App::uses('AuthComponent', 'Component');
App::uses('Block', 'Blocks.Model');
App::uses('Faq', 'Faqs.Model');
App::uses('FaqSetting', 'Faqs.Model');
App::uses('FaqQuestion', 'Faqs.Model');
App::uses('FaqQuestionOrder', 'Faqs.Model');

/**
 * Common code for test of Faqs
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqsBaseModel extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.boxes.box',
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.comments.comment',
		'plugin.faqs.faq',
		'plugin.faqs.faq_setting',
		'plugin.faqs.faq_question',
		'plugin.faqs.faq_question_order',
		'plugin.frames.frame',
		'plugin.frames.plugin',
		'plugin.m17n.language',
		'plugin.rooms.room',
		'plugin.users.user_attributes_user',
		'plugin.users.user',
	);

/**
 * Do test assert, after created_date, created_user, modified_date and modified_user fields remove.
 *
 * @param array $expected expected data
 * @param array $result result data
 * @return void
 */
	protected function _assertArray($expected, $result) {
		$result = Hash::remove($result, 'created');
		$result = Hash::remove($result, 'created_user');
		$result = Hash::remove($result, 'modified');
		$result = Hash::remove($result, 'modified_user');
		$result = Hash::remove($result, '{s}.created');
		$result = Hash::remove($result, '{s}.created_user');
		$result = Hash::remove($result, '{s}.modified');
		$result = Hash::remove($result, '{s}.modified_user');
		$result = Hash::remove($result, '{n}.{s}.created');
		$result = Hash::remove($result, '{n}.{s}.created_user');
		$result = Hash::remove($result, '{n}.{s}.modified');
		$result = Hash::remove($result, '{n}.{s}.modified_user');
		$result = Hash::remove($result, 'TrackableCreator');
		$result = Hash::remove($result, 'TrackableUpdater');
		$result = Hash::remove($result, '{n}.TrackableCreator');
		$result = Hash::remove($result, '{n}.TrackableUpdater');

		$this->assertEquals($expected, $result);
	}

/**
 * Called before the test().
 *
 * @return void
 */
	public function test() {
	}
}
