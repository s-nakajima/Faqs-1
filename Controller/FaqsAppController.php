<?php
/**
 * FaqsApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * FaqsApp Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Controller
 */
class FaqsAppController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Security',
	);

/**
 * _setFrame method
 *
 * @param int $frameId frames.id
 * @return void
 */
	protected function _setFrame($frameId) {
		$frame = $this->Frame->getFrame($frameId, $this->plugin);
		$this->set('frame', $this->camelizeKeyRecursive($frame['Frame']));
	}

	protected function _initSetting($frame, $block) {
		$frame = $this->Frame->getFrame($frameId, $this->plugin);
		$this->set('frame', $this->camelizeKeyRecursive($frame['Frame']));
	}
}
