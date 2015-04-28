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

App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('YACakeTestCase', 'NetCommons.TestSuite');
App::uses('AuthComponent', 'Component');
App::uses('Faq', 'Faqs.Model');
App::uses('FaqOrder', 'Faqs.Model');
App::uses('Category', 'Categories.Model');
App::uses('Block', 'Blocks.Model');

/**
 *Faq Model Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqsModelTestCase extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.faqs.block',
		'plugin.faqs.category',
		'plugin.faqs.categoryOrder',
		'plugin.faqs.comment',
		'plugin.faqs.faq',
		'plugin.faqs.faqOrder',
		'plugin.faqs.user_attributes_user',
		'plugin.faqs.user',
		'plugin.faqs.frame',
		'plugin.faqs.plugin',
		'plugin.frames.box',
		'plugin.m17n.language',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Faq = ClassRegistry::init('Faqs.Faq');
		$this->FaqBlock = ClassRegistry::init('Faqs.FaqBlock');
		$this->FaqOrder = ClassRegistry::init('Faqs.FaqOrder');
		$this->Block = ClassRegistry::init('Blocks.Block');
		$this->Category = ClassRegistry::init('Categories.Category');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Faq);
		unset($this->FaqOrder);
		unset($this->Block);
		unset($this->Category);

		parent::tearDown();
	}

/**
 * _assertArray method
 *
 * @param string $key target key
 * @param mixed $value array or string, number
 * @param array $result result data
 * @return void
 */
	protected function _assertArray($key, $value, $result) {
		if ($key !== null) {
			$this->assertArrayHasKey($key, $result);
			$target = $result[$key];
		} else {
			$target = $result;
		}
		if (is_array($value)) {
			foreach ($value as $nextKey => $nextValue) {
				$this->_assertArray($nextKey, $nextValue, $target);
			}
		} elseif (isset($value)) {
			$this->assertEquals($value, $target, 'key=' . print_r($key, true) . 'value=' . print_r($value, true) . 'result=' . print_r($result, true));
		}
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}
}