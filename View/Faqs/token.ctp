<?php
/**
 * Faqs form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$this->NetCommonsForm->create('Faq' . (int)$frameId);

$this->NetCommonsForm->input('Faq.id', array(
			'type' => 'number',
		)
	);

$this->NetCommonsForm->input('Faq.faq_category_id', array(
			'type' => 'select',
			'options' => $categoryOptions,
		)
	);

$this->NetCommonsForm->input('Faq.question', array(
			'type' => 'textarea',
		)
	);

$this->NetCommonsForm->input('Faq.answer', array(
			'type' => 'textarea',
		)
	);

$this->NetCommonsForm->input('Faq.status', array(
			'type' => 'number',
		)
	);

echo $this->NetCommonsForm->endJson();
