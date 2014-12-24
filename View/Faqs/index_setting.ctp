<?php
/**
 * Faqs view setting template
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
<?php echo '0'; ?>
<?php $this->end(); ?>

<?php echo $this->element('manage_tab_list'); ?>

<div ng-show="tab.isSet(0)">
	<div id="nc-faqs-change-order-move-<?php echo (int)$frameId; ?>"
		 class="tab-pane active">

		<div class="panel panel-default">
			<div class="panel-body">
				<div class="text-right">
					<?php echo $this->element('Faqs/list_header'); ?>
				</div>
				<hr>
				<?php echo $this->element('Faqs/list', array('manageMode' => 1)); ?>

				<?php echo $this->element('Faqs/list_footer'); ?>
			</div>
		</div>

		<p class="text-center">
			<button type="button" class="btn btn-default" ng-click="cancel()">
				<span class="glyphicon glyphicon-remove small"></span>
				<?php echo __d('net_commons', 'Cancel'); ?>
			</button>
		</p>
	</div>
</div>