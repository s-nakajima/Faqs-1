<?php
/**
 * Categories Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');
/**
 * Categories Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Controller
 */
class CategoriesController extends FaqsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
		'Blocks.Block',
		'Categories.Category',
		'Categories.CategoryOrder',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit'),
			),
		),
		'Categories.CategoryAction',
		'Security' => array('validatePost' => false),
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token'
	);

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function edit($frameId = 0, $blockId = 0) {
		$this->layout = 'Frames.setting';

		$frame = $this->Frame->getFrame($frameId, $this->plugin);
		$block = $this->Block->find('first', array(
			'conditions' => array('id' => $blockId),
			'recursive' => -1
		));
		$result = array(
			'frame' => $frame['Frame'],
			'block' => $block['Block'],
		);
		$result = $this->camelizeKeyRecursive($result);
		$this->set($result);

		$this->CategoryAction->edit($block);
	}
}
