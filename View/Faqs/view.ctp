<?php
/**
 * Faqs view form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php $form = 'FaqForm' . (int)$frameId; ?>

<?php $this->start('titleForModal'); ?>
<?php echo __d('faqs', 'plugin_name'); ?>
<?php $this->end(); ?>

<?php if($manageMode): ?>
	<?php $this->start('tabIndex'); ?>
	<?php echo '0'; ?>
	<?php $this->end(); ?>

	<?php echo $this->element('manage_tab_list'); ?>
<?php endif; ?>

<div class="panel panel-default">
	<div class="panel-body">
		<form name="<?php echo $form; ?>" novalidate>
			<div ng-init="faqInitialize(<?php echo $form; ?>)">

				<?php echo $this->element('Faqs/form_faq'); ?>
			</div>
		</form>
	</div>
</div>

<?php echo $this->element('Faqs/form_faq_btn');
