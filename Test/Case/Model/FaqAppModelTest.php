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

App::uses('Faq', 'Faqs.Model');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 *Faq Model Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqAppModelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.faqs.faq',
		'plugin.faqs.faqOrder',
		'plugin.faqs.category',
		'plugin.faqs.categoryOrder',
		'plugin.faqs.block',
		'plugin.faqs.comment',
		'plugin.frames.box',
		/* 'plugin.frames.language', */
		'plugin.m17n.language',
		'plugin.rooms.room',
		'plugin.faqs.user_attributes_user',
		'plugin.faqs.user',
		'plugin.faqs.frame',
		'plugin.faqs.plugin',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Faq = ClassRegistry::init('Faqs.Faq');
		$this->Comment = ClassRegistry::init('Comments.Comment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Faq);
		unset($this->Comment);
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