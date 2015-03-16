<?php
/**
 * FaqsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsController', 'Iframes.Controller');
App::uses('FaqsAppTest', 'Faqs.Test/Case/Controller');

/**
 * FaqsController Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Iframes\Test\Case\Controller
 */
class FaqsControllerTest extends FaqsAppTest {

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction(
				'/faqs/faqs/index/1',
				array(
					'method' => 'get',
					'return' => 'view',
				)
			);
		$this->assertTextEquals('index', $this->controller->view);
	}
}
