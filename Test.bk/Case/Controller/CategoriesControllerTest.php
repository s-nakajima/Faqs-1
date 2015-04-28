<?php
/**
 * CategoriesController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoriesController', 'Faqs.Controller');
App::uses('FaqsControllerTestCase', 'Faqs.Test/Case/Controller');

/**
 * CategoriesController Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Test\Case\Controller
 */
class CategoriesControllerTest extends FaqsControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		$this->generate(
			'Faqs.Categories',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
		parent::setUp();
	}

/**
 * test
 *
 * @return void
 */
	public function test() {
		$this->assertTrue(true);
	}
}
