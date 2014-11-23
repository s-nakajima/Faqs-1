<?php
/**
 * Faqs Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * Faqs Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Faqs\Controller
 */
class FaqsController extends FaqsAppController {

/**
 * use model
 *
 * @var array
 */
	//public $uses = array();

/**
 * use component
 *
 * @var array
 */
	//public $components = array();

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @param string $lang ex)"en" or "ja" etc.
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0, $lang = '') {
		//$this->_initializeFrame($frameId);
		$this->set('frameId', $frameId);
		return $this->render('Faqs/index');
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param string $lang ex)"en" or "ja" etc.
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0, $lang = '') {
		return $this->render('Faqs/view');
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @param int $languageId languages.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0, $languageId = 0) {
		return $this->render('Faqs/form');
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function edit($frameId = 0) {
		//return;
	}
}
