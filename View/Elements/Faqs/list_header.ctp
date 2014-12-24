<?php
/**
 * Faqs list header element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<form role="form" class="form-inline">
	<div class="form-group"
		ng-hide="faqSetting.FaqFrameSetting.display_category">
		<?php
			echo $this->Form->input('category', array(
						'label' => false,
						'type' => 'select',
						'ng-options' => 'option.FaqCategory.id as option.FaqCategory.name for option in categoryOptions',
						'empty' => __d('faqs', 'Select category'),
						'class' => 'form-control',
						'ng-controller' => 'Faqs.Edit',
						'ng-model' => '$parent.displayCategoryId',
						'ng-change' => 'changeFaqList()',
					)
				);
		?>
	</div>
	<div class="form-group">
		<?php
			echo $this->Form->input('number', array(
						'label' => false,
						'type' => 'select',
						'options' => FaqFrameSetting::getDisplayNumberOptions(),
						'class' => 'form-control',
						'ng-controller' => 'Faqs.Edit',
						'ng-model' => '$parent.displayNumber',
						'ng-change' => 'changeFaqList()',
					)
				);
		?>
	</div>
</form>
