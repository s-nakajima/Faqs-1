<?php
/**
 * FaqQuestionOrders Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FaqsAppController', 'Faqs.Controller');

/**
 * FaqQuestionOrders Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Controller
 */
class FaqQuestionOrdersController extends FaqsAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Faqs.Faq',
		'Faqs.FaqQuestion',
		'Faqs.FaqQuestionOrder',
		'Categories.Category',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit'),
			),
		),
		'Categories.Categories',
		'Paginator',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->Categories->initCategories();

		if (! $this->initFaq()) {
			return;
		}

		$this->Paginator->settings = array(
			'FaqQuestion' => array(
				'order' => array('FaqQuestionOrder.weight' => 'desc'),
				'conditions' => array(
					'FaqQuestion.faq_id' => $this->viewVars['faq']['id'],
					'FaqQuestion.is_latest' => true,
				),
//				'joins' => array(
//					'Category',
//					array(
//						'table' => 'category_orders',
//						'alias' => 'CategoryOrder',
//						'type' => 'left',
//						'conditions' => array(
//							'Category.key = CategoryOrder.category_key'
//						)
//					)
//				),
				'limit' => -1
			)
		);
		$faqQuestions = $this->Paginator->paginate('FaqQuestion');

		$results = array(
			'faqQuestions' => $faqQuestions
		);
		//Viewにセット
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

}
