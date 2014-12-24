<?php
/**
 * FaqFrameSettings view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php $this->start('titleForModal'); ?>
<?php echo __d('faqs', 'plugin_name'); ?>
<?php $this->end(); ?>

<?php $this->start('tabIndex'); ?>
<?php echo '2'; ?>
<?php $this->end(); ?>

<?php echo $this->element('manage_tab_list'); ?>

<div ng-init="displayChangeInitialize(faqSetting)">
	<div id="nc-faqs-change-order-move-<?php echo (int)$frameId; ?>"
		 class="tab-pane active">

		<div class="panel panel-default">
			<div class="panel-body">
				<form name="faqDisplayChangeForm{{frameId}}" novalidate>
					<?php echo $this->element('FaqFrameSettings/form_frame_setting'); ?>
				</div>
			</div>
		</div>

		<p class="text-center">
			<button type="button" class="btn btn-default" ng-click="cancel()">
				<span class="glyphicon glyphicon-remove small"></span>
				<?php echo __d('net_commons', 'Cancel'); ?>
			</button>
			<button type="button" class="btn btn-primary" ng-click="saveFrameSetting()">
				<?php echo __d('net_commons', 'OK'); ?>
			</button>
		</p>

	</div>
</div>