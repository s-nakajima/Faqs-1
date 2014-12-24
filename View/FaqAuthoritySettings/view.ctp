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
<?php echo '3'; ?>
<?php $this->end(); ?>

<?php echo $this->element('manage_tab_list'); ?>

<div ng-show="tab.isSet(3)">

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo __d('faqs', 'FAQ Add Authority'); ?>
		</div>
		<div class="panel-body">
			<div class='form-group'>
				<div class='form-group'>
					<span class="glyphicon glyphicon-ok"></span>
					<?php echo __d('faqs', 'Room Administrator'); ?>
				</div>

				<div class='form-group'>
					<span class="glyphicon glyphicon-ok"></span>
					<?php echo __d('faqs', 'Chief Editor'); ?>
				</div>

				<div class='form-group'>
					<span class="glyphicon glyphicon-ok"></span>
					<?php echo __d('faqs', 'Editor'); ?>
				</div>

				<div class='form-group'>
					<?php
						echo $this->Form->input('general_user', array(
							'type' => 'checkbox',
							'label' => __d('faqs', 'General User'),
							'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
							'ng-model' => 'blockRolePermission.BlockRolePermission.value',
						));
					?>
				</div>
			</div>
		</div>
	</div>

	<p class="text-center">
		<button type="button" class="btn btn-default" ng-click="cancel()">
			<span class="glyphicon glyphicon-remove small"></span>
			<?php echo __d('net_commons', 'Cancel'); ?>
		</button>
		<button type="button" class="btn btn-primary" ng-click="saveAuthority()">
			<?php echo __d('net_commons', 'OK'); ?>
		</button>
	</p>
</div>