<?php
/**
 * faq block authority edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php
	echo $this->Html->script('http://rawgit.com/angular/bower-angular-sanitize/v1.2.25/angular-sanitize.js', false);
	echo $this->Html->script('http://rawgit.com/m-e-conroy/angular-dialog-service/v5.2.0/src/dialogs.js', false);
	echo $this->Html->script('/frames/js/frames.js', false);
?>

<?php echo $this->element('Faqs.frame_menu', array('tab' => 'block')); ?>

<?php echo $this->element('Faqs.block_menu', array('tab' => 'auth')); ?>

<form novalidate>

	<div class="form-group">
		<label>
			<?php echo __d('blocks', 'Article'); ?>
		</label><br/>
		<div class="well well-sm" style="background-color:transparent">
			<div>
				<label>
					<?php echo __d('blocks', 'Author'); ?>
				</label><br/>
				<?php echo $this->Form->input('data[content_creatable][room_admin]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('blocks', 'Room Administrator'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[content_creatable][chief_editor]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('blocks', 'Chief Editor'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[content_creatable][editor]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('blocks', 'Editor'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[content_creatable][general_user]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('blocks', 'General User'),
							'style' => 'font-weight:normal',
						),
						'div' => false,
					));?>
			</div>
			<div>
				<label>
					<?php echo __d('blocks', 'Approval'); ?>
				</label><br/>
				<label style="font-weight:normal">
					<input type="radio" name="publishContents" ng-model="publishContents" ng-value="1">
					<?php echo __d('blocks', 'Used'); ?>
				</label>
				<label style="font-weight:normal">
					<input type="radio" name="publishContents" ng-model="publishContents" ng-value="0" ng-init="publishContents = 0">
					<?php echo __d('blocks', 'Unused'); ?>
				</label>
			</div>
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
				<fieldset ng-disabled="! publishContents" collapse="! publishContents">
					<label>
						<?php echo __d('blocks', 'Approver'); ?>
					</label><br/>
					<?php echo $this->Form->input('data[publishContents][room_admin]',
						array(
							'type' => 'checkbox',
							'label' => array(
								'text' => __d('blocks', 'Room Administrator'),
								'style' => 'font-weight:normal',
							),
							'div' => false,
							'checked' => true,
						));?>
					<?php echo $this->Form->input('data[publishContents][chief_editor]',
						array(
							'type' => 'checkbox',
							'label' => array(
								'text' => __d('blocks', 'Chief Editor'),
								'style' => 'font-weight:normal',
							),
							'div' => false,
							'checked' => true,
						));?>
				</fieldset>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label>
			<?php echo __d('blocks', 'Comment'); ?>
		</label><br/>
		<div class="well well-sm" style="background-color:transparent">
			<div>
				<label>
					<?php echo __d('blocks', 'Author'); ?>
				</label><br/>
				<?php echo $this->Form->input('data[comment_creatable][room_admin]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('blocks', 'Room Administrator'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[comment_creatable][chief_editor]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('blocks', 'Chief Editor'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[comment_creatable][editor]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('blocks', 'Editor'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[comment_creatable][general_user]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('blocks', 'General User'),
							'style' => 'font-weight:normal',
						),
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[comment_creatable][guests',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('blocks', 'Guests'),
							'style' => 'font-weight:normal',
						),
						'div' => false,
					));?>
			</div>
			<div>
				<label>
					<?php echo __d('blocks', 'Approval'); ?>
				</label><br/>
				<label style="font-weight:normal">
					<input type="radio" name="publishComments" ng-model="publishComments" ng-value="1">
					<?php echo __d('blocks', 'Used'); ?>
				</label>
				<label style="font-weight:normal">
					<input type="radio" name="publishComments" ng-model="publishComments" ng-value="0" ng-init="publishComments = 0">
					<?php echo __d('blocks', 'Unused'); ?>
				</label>
			</div>
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
				<fieldset ng-disabled="! publishComments" collapse="! publishComments">
					<label>
						<?php echo __d('blocks', 'Approver'); ?>
					</label><br/>
					<?php echo $this->Form->input('data[publishComments][room_admin]',
						array(
							'type' => 'checkbox',
							'label' => array(
								'text' => __d('blocks', 'Room Administrator'),
								'style' => 'font-weight:normal',
							),
							'div' => false,
							'checked' => true,
						));?>
					<?php echo $this->Form->input('data[publishComments][chief_editor]',
						array(
							'type' => 'checkbox',
							'label' => array(
								'text' => __d('blocks', 'Chief Editor'),
								'style' => 'font-weight:normal',
							),
							'div' => false,
							'checked' => true,
						));?>
				</fieldset>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div>
			<label>
				<?php echo __d('blocks', 'Mail'); ?>
			</label><br/>
			<label style="font-weight:normal">
				<input type="checkbox" name="mail" ng-model="sendMail">
				<?php echo __d('blocks', 'E-mail notification of registration'); ?>
			</label>
		</div>
		<div collapse="! sendMail" class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
			<label>
				<?php echo __d('blocks', 'Notified of authority'); ?>
			</label><br/>
			<?php echo $this->Form->input('data[send_mail][room_admin]',
				array(
					'type' => 'checkbox',
					'label' => array(
						'text' => __d('blocks', 'Room Administrator'),
						'style' => 'font-weight:normal',
					),
					'div' => false,
				));?>

			<?php echo $this->Form->input('data[send_mail][chief_editor]',
				array(
					'type' => 'checkbox',
					'label' => array(
						'text' => __d('blocks', 'Chief Editor'),
						'style' => 'font-weight:normal',
					),
					'div' => false,
				));?>

			<?php echo $this->Form->input('data[send_mail][editor]',
				array(
					'type' => 'checkbox',
					'label' => array(
						'text' => __d('blocks', 'Editor'),
						'style' => 'font-weight:normal',
					),
					'div' => false,
				));?>

			<?php echo $this->Form->input('data[send_mail][general_user]',
				array(
					'type' => 'checkbox',
					'label' => array(
						'text' => __d('blocks', 'General User'),
						'style' => 'font-weight:normal',
					),
					'div' => false,
				));?>
		</div>
	</div>

	<p class="text-center">
		<button type="button" class="btn btn-default" ng-click="cancel()">
			<span class="glyphicon glyphicon-remove small"></span>
			<?php echo __d('net_commons', 'Cancel'); ?>
		</button>
		<?php echo $this->Form->button(
			__d('net_commons', 'OK'),
			array('name' => 'edit', 'class' => 'btn btn-primary')); ?>
	</p>
</form>

