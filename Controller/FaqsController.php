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
 * index
 *
 * @return void
 */
	public function index() {
		$html = $this->requestAction(
			array('controller' => 'faq_questions', 'action' => 'index', $this->viewVars['frameId']),
			array('return')
		);

		$this->set('html', $html);
	}
}
