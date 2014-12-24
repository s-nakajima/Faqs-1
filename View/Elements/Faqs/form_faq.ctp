<?php
/**
 * Faqs form faq element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class='form-group'>
	<?php
		echo $this->Form->input('Faq.faq_category_id', array(
			'label' => __d('faqs', 'category'),
			'type' => 'select',
			'class' => 'form-control',
			'ng-options' => 'option.FaqCategory.id as option.FaqCategory.name for option in categoryOptions',
			'ng-model' => 'faq.Faq.faq_category_id',
			'ng-disabled' => 'displayCategoryId != 0',
		));
	?>
	<br />
</div>

<div class='form-group' ng-class="faqForm.question.validationErrors ? 'has-error' : ''">
	<label class="control-label">
		<?php echo __d('faqs', 'question'); ?>
		<?php echo $this->element('NetCommons.required'); ?>
	</label>
	<textarea name="question" class="form-control" rows="2" required
			ng-model="faq.Faq.question"
			ng-change="serverValidationClear(faqForm, 'question')">
	</textarea>

	<div class="help-block">
		<br ng-hide="faqForm.question.validationErrors" />
		<div ng-repeat="errorMessage in faqForm.question.validationErrors">
			<span ng-bind="errorMessage"></span>
		</div>
	</div>
</div>

<div class='form-group' ng-class="faqForm.answer.validationErrors ? 'has-error' : ''">
	<label class="control-label">
		<?php echo __d('faqs', 'answer'); ?>
		<?php echo $this->element('NetCommons.required'); ?>
	</label>
	<textarea name="answer" class="form-control" rows="2" required
			ng-model="faq.Faq.answer"
			ng-change="serverValidationClear(faqForm, 'answer')">
	</textarea>

	<div class="help-block">
		<br ng-hide="faqForm.answer.validationErrors" />
		<div ng-repeat="errorMessage in faqForm.answer.validationErrors">
			<span ng-bind="errorMessage"></span>
		</div>
	</div>
</div>