<?php
/**
 * Blocks edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->element('Blocks.form_hidden'); ?>

<?php echo $this->Form->hidden('Faq.id', array(
		'value' => isset($faq['id']) ? (int)$faq['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('Faq.key', array(
		'value' => isset($faq['key']) ? $faq['key'] : null,
	)); ?>

<?php echo $this->Form->hidden('FaqSetting.id', array(
		'value' => isset($faqSetting['id']) ? (int)$faqSetting['id'] : null,
	)); ?>

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->input(
				'Faq.name', array(
					'type' => 'text',
					'label' => __d('faqs', 'FAQ Name') . $this->element('NetCommons.required'),
					'error' => false,
					'class' => 'form-control',
					'autofocus' => true,
					'value' => (isset($faq['name']) ? $faq['name'] : '')
				)
			); ?>
	</div>

	<div class="col-xs-12">
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'Faq',
				'field' => 'name',
			]); ?>
	</div>
</div>

<?php echo $this->element('Blocks.public_type'); ?>

<?php echo $this->element('Categories.edit_form', array(
		'categories' => isset($categories) ? $categories : null
	));
