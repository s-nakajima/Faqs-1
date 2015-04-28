<?php
/**
 * Common code of Faq model test
 *
 * @property Faq $Faq
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsBaseModel', 'Faqs.Test/Case/Model');

/**
 * Common code of Faq model test
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Test\Case\Model
 */
class FaqTest extends FaqsBaseModel {

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Faq = ClassRegistry::init('Faqs.Faq');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Faq);
		parent::tearDown();
	}
}
