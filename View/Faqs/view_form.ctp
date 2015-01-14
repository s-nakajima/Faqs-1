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
			<div ng-init="faqInitialize(
				<?php echo h(json_encode($faq)); ?>,
				<?php echo $form; ?>)">

				<?php echo $this->element('Faqs/form_faq'); ?>
			</div>
		</form>
	</div>
</div>

<!-- TODO:ボタン要確認 -->
<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="cancel()">
		<?php echo __d('net_commons', 'Cancel'); ?>
	</button>
	<button type="button" class="btn btn-danger" ng-click="saveFaq('<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>')">
		<?php echo __d('net_commons', 'Disapproval'); ?>
	</button>
	<button type="button" class="btn btn-default" ng-click="saveFaq('<?php echo NetCommonsBlockComponent::STATUS_IN_DRAFT ?>')">
		<?php echo __d('net_commons', 'Save temporally'); ?>
	</button>
	<button type="button" class="btn btn-warning" ng-click="saveFaq('<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>')">
		<?php echo __d('net_commons', 'OK'); ?>
	</button>
	<button type="button" class="btn btn-primary" ng-click="saveFaq('<?php echo NetCommonsBlockComponent::STATUS_PUBLISHED ?>')">
		<?php echo __d('net_commons', 'OK'); ?>
	</button>
</p>
