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
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$results = $this->camelizeKeyRecursive(['current' => $this->current]);
		$this->set($results);
	}

/**
 * initFaq
 *
 * @param array $contains Optional result sets
 * @return bool True on success, False on failure
 */
	public function initFaq($contains = []) {
		if (! $faq = $this->Faq->getFaq($this->viewVars['blockId'], $this->viewVars['roomId'])) {
			$this->throwBadRequest();
			return false;
		}
		$faq = $this->camelizeKeyRecursive($faq);
		$this->set($faq);

		if (in_array('faqSetting', $contains, true)) {
			if (! $faqSetting = $this->FaqSetting->getFaqSetting($faq['faq']['key'])) {
				$faqSetting = $this->FaqSetting->create(
					array('id' => null)
				);
			}
			$faqSetting = $this->camelizeKeyRecursive($faqSetting);
			$this->set($faqSetting);
		}

		if (in_array('categories', $contains, true)) {
			$categories = array();

			$categories = $this->camelizeKeyRecursive($categories);
			$this->set(['categories' => $categories]);
		}

		$this->set('userId', (int)$this->Auth->user('id'));

		return true;
	}

}
