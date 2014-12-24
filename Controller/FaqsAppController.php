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
//		'Security',
		'Paginator',
		'Faqs.Faqs',
	);

/**
 * getFaqList method
 *
 * @param int $blockId blocks.id
 * @param int $displayCategoryId faq_frame_settings.display_category
 * @param int $displayNumber faq_frame_settings.display_number
 * @param int $currentPage select page
 * @return array
 */
	public function getFaqList($blockId, $displayCategoryId, $displayNumber, $currentPage = 1) {
		$status = $this->viewVars['contentCreatable'] ? null : NetCommonsBlockComponent::STATUS_PUBLISHED;

		$this->Paginator->settings = $this->Faqs->getFaqListOptions($blockId, $displayCategoryId, $displayNumber, $currentPage, $status);
		return $this->Paginator->paginate('Faq');
	}

/**
 * getFaqListTotal method
 *
 * @return int
 */
	public function getFaqListTotal() {
		//$this->Viewを使用可能にする
		$this->View = $this->_getViewObject();
		return $this->View->Paginator->params()["count"];
	}

/**
 * getCategoryResponseData method
 *
 * @return CakeResponse A response object containing the rendered view.
 */
	public function getCategoryResponseData() {
		$categoryList = $this->FaqCategory->getFaqCategoryList($this->viewVars['blockId'], false);
		$categoryTemplate = $this->Faqs->getFaqCategoryTemplate();
		$faqSetting = $this->FaqFrameSetting->getFaqSetting($this->viewVars['frameKey']);
		$faqList = $this->getFaqList($this->viewVars['blockId'], $faqSetting['FaqFrameSetting']['display_category'], $faqSetting['FaqFrameSetting']['display_number']);

		return array(
			'categoryList' => $categoryList,
			'categoryTemplate' => $categoryTemplate,
			'faqSetting' => $faqSetting,
			'faqList' => $faqList,
			'categoryOptions' => $categoryList,
		);
	}
}
