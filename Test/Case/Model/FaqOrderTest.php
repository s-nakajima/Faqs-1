<?php
/**
 * FaqOrderTest Model Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqAppModelTest', 'Faqs.Test/Case/Model');

/**
 * FaqOrderTest Model Test Case
 */
class FaqOrderTest extends FaqAppModelTest {

/**
 * tesTargetMaxWeight method
 *
 * @return void
 */
	public function testGetMaxWeight() {
		$blockKey = 'block_1';
		$result = $this->FaqOrder->getMaxWeight($blockKey);

		$expected = 1;

		$this->assertEquals($expected, $result);
	}
}
