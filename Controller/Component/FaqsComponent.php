<?php
/**
 * Faqs Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * Faqs Component
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\Faqs\Controller\Component
 */
class FaqsComponent extends Component {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Session',
	);

/**
 * getFaqListOptions method
 *
 * @param int $blockId blocks.id
 * @param int $displayCategoryId faq_frame_settings.display_category
 * @param int $displayNumber faq_frame_settings.display_number
 * @param int $currentPage select page
 * @param int $status faqs.status
 * @return array
 */
	public function getFaqListOptions($blockId, $displayCategoryId = 0, $displayNumber = 10, $currentPage = 1, $status = null) {
		$settings = array(
			'Faq' => array(
				'fields' => array(
					'Faq.id',
					'Faq.faq_category_id',
					'Faq.status',
					'Faq.question',
					'Faq.answer',
					'Faq.created_user',
					'FaqCategory.id',
					'FaqCategory.block_id',
					'FaqOrder.id',
					'FaqOrder.faq_key',
					'FaqOrder.weight',
				),
				'conditions' => array(
					'FaqCategory.block_id' => $blockId,
				),
				'limit' => $displayNumber,
				'page' => $currentPage,
				'order' => 'FaqOrder.weight',
			),
		);

		// 選択されたカテゴリのみ取得する
		if ($displayCategoryId !== '0' && $displayCategoryId !== 'null') {
			$settings['Faq']['conditions']['FaqCategory.id'] = $displayCategoryId;
		}

		if ($status) {
			$settings['Faq']['conditions']['Faq.status'] = $status;
		}

		return $settings;
	}

/**
 * setSession method
 *
 * @param int $frameId frames.id
 * @param int $displayCategoryId faq_frame_settings.display_category
 * @param int $displayNumber faq_frame_settings.display_number
 * @param int $currentPage select page
 * @return void
 */
	public function setSession($frameId, $displayCategoryId, $displayNumber, $currentPage = 1) {
		// セッション保存
		$this->Session->write('faqs.' . $frameId . '.displayCategoryId', $displayCategoryId);
		$this->Session->write('faqs.' . $frameId . '.displayNumber', $displayNumber);
		$this->Session->write('faqs.' . $frameId . '.currentPage', $currentPage);
	}

/**
 * getSession method
 *
 * @param int $frameId frames.id
 * @return array
 */
	public function getSession($frameId) {
		// セッション取得
		return array(
			'displayCategoryId' => $this->Session->read('faqs.' . $frameId . '.displayCategoryId'),
			'displayNumber' => $this->Session->read('faqs.' . $frameId . '.displayNumber'),
			'currentPage' => $this->Session->read('faqs.' . $frameId . '.currentPage'),
		);
	}

/**
 * getFaqCategoryTemplate method
 *
 * @return array
 */
	public function getFaqCategoryTemplate() {
		return array(
			'FaqCategory' => array(
				'id' => null,
				'name' => ''
			),
		);
	}

/**
 * formatToCategoryOptions method
 *
 * @param array $categoryList category list
 * @return array
 */
	public function formatToCategoryOptions($categoryList) {
		return Hash::combine($categoryList, '{n}.FaqCategory.id', '{n}.FaqCategory.name');
	}
}

