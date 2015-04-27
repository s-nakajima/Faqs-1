<?php
/**
 * Element of Question edit form
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Faq.id', array(
		'value' => $faq['id'],
	)); ?>

<?php echo $this->Form->hidden('Faq.key', array(
		'value' => $faq['key'],
	)); ?>

<?php echo $this->Form->hidden('Frame.id', array(
		'value' => $frameId,
	)); ?>

<?php echo $this->Form->hidden('FaqQuestion.id', array(
		'value' => isset($faqQuestion['id']) ? (int)$faqQuestion['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('FaqQuestion.faq_id', array(
		'value' => $faq['id'],
	)); ?>

<?php echo $this->Form->hidden('FaqQuestion.key', array(
		'value' => $faqQuestion['key'],
	)); ?>

<?php echo $this->Form->hidden('FaqQuestion.language_id', array(
		'value' => $languageId,
	)); ?>

<?php echo $this->Form->hidden('FaqQuestionOrder.id', array(
		'value' => isset($faqQuestionOrder['id']) ? (int)$faqQuestionOrder['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('FaqQuestionOrder.faq_key', array(
		'value' => $faq['key'],
	)); ?>

<?php echo $this->Form->hidden('FaqQuestionOrder.faq_question_key', array(
		'value' => isset($faqQuestion['key']) ? $faqQuestion['key'] : null,
	)); ?>

<?php if (is_array($categories) && count($categories) > 0) : ?>
	<div class='form-group'>
		<?php $categories = Hash::combine($categories, '{n}.category.id', '{n}.category.name'); ?>

		<?php echo $this->Form->input('FaqQuestion.category_id',
			array(
				'label' => __d('categories', 'Category'),
				'type' => 'select',
				'error' => false,
				'class' => 'form-control',
				'empty' => array(0 => __d('categories', 'Select Category')),
				'options' => $categories,
				'value' => (isset($faqQuestion['categoryId']) ? $faqQuestion['categoryId'] : '0')
			)); ?>
		<div>
			<?php echo $this->element(
				'NetCommons.errors', [
					'errors' => $this->validationErrors,
					'model' => 'FaqQuestion',
					'field' => 'question',
				]); ?>
		</div>
	</div>
<?php endif; ?>

<div class="form-group">
	<div>
		<label class="control-label">
			<?php echo __d('faqs', 'Question'); ?>
			<?php echo $this->element('NetCommons.required'); ?>
		</label>
	</div>
	<div>
		<?php echo $this->Form->textarea('FaqQuestion.question', array(
				'label' => false,
				'class' => 'form-control',
				'rows' => 2,
				'value' => (isset($faqQuestion['question']) ? $faqQuestion['question'] : '')
			)); ?>
	</div>
	<div>
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'FaqQuestion',
				'field' => 'question',
			]); ?>
	</div>
</div>

<div class="form-group">
	<div>
		<label class="control-label">
			<?php echo __d('faqs', 'Answer'); ?>
			<?php echo $this->element('NetCommons.required'); ?>
		</label>
	</div>
	<div>
		<?php echo $this->Form->textarea('FaqQuestion.answer', array(
				'label' => false,
				'class' => 'form-control',
				'ui-tinymce' => 'tinymce.options',
				'ng-model' => 'faqQuestion.answer',
				'rows' => 5,
				'required' => 'required',
			)); ?>
	</div>
	<div>
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'FaqQuestion',
				'field' => 'answer',
			]); ?>
	</div>
</div>
