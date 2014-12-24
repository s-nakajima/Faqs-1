<?php
/**
 * FaqCategoryOrders form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$this->NetCommonsForm->create(null);

$this->NetCommonsForm->input('FaqCategoryOrder.type', array(
			'type' => 'number',
		)
	);

$this->NetCommonsForm->input('FaqCategoryOrder.faq_category_key', array(
			'type' => 'text',
		)
	);
$this->NetCommonsForm->input('FaqCategoryOrder.weight', array(
			'type' => 'number',
		)
	);

echo $this->NetCommonsForm->endJson();
