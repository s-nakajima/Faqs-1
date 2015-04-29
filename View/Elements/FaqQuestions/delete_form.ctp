<?php
/**
 * Element of Question delete form
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->create('FaqQuestion', array(
			'type' => 'delete',
			'controller' => 'faq_questions',
			'action' => 'delete/' . $frameId . '/' . h($faqQuestion['key'])
		)); ?>

	<?php echo $this->Form->hidden('Faq.key', array(
			'value' => $faq['key'],
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

	<?php echo $this->Form->button('<span class="glyphicon glyphicon-trash"> </span>', array(
			'name' => 'delete',
			'class' => 'btn btn-danger',
			'onclick' => 'return confirm(\'' . sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('faqs', 'Question')) . '\')'
		)); ?>
<?php echo $this->Form->end();
