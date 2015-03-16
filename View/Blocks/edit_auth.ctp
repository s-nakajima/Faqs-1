<!-- TODO:フレーム設定機能↓ -->
<?php
	echo $this->Html->script('http://rawgit.com/angular/bower-angular-sanitize/v1.2.25/angular-sanitize.js', false);
	echo $this->Html->script('http://rawgit.com/m-e-conroy/angular-dialog-service/v5.2.0/src/dialogs.js', false);
	echo $this->Html->script('/frames/js/frames.js', false);
?>

<?php echo $this->element('Faqs.frame_menu', array('tab' => 'block')); ?>

<?php echo $this->element('Faqs.block_menu', array('tab' => 'auth')); ?>

<form novalidate>

	<div class="form-group">
		<label>記事</label><br/>
		<div class="well well-sm" style="background-color:transparent">
			<div>
				<label>作成者</label><br/>
				<?php echo $this->Form->input('data[content_creatable][room_admin]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('faqs', 'Room Administrator'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[content_creatable][chief_editor]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('faqs', 'Chief Editor'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[content_creatable][editor]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('faqs', 'Editor'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[content_creatable][general_user]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('faqs', 'General User'),
							'style' => 'font-weight:normal',
						),
						'div' => false,
					));?>
			</div>
			<div>
				<label>承認機能</label><br/>
				<label style="font-weight:normal"><input type="radio" name="publishContents" ng-model="publishContents" ng-value="1">あり</label>
				<label style="font-weight:normal"><input type="radio" name="publishContents" ng-model="publishContents" ng-value="0" ng-init="publishContents = 0">なし</label>
			</div>
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
				<fieldset ng-disabled="! publishContents" collapse="! publishContents">
					<label>承認者</label><br/>
					<?php echo $this->Form->input('data[publishContents][room_admin]',
						array(
							'type' => 'checkbox',
							'label' => array(
								'text' => __d('faqs', 'Room Administrator'),
								'style' => 'font-weight:normal',
							),
							'div' => false,
							'checked' => true,
						));?>
					<?php echo $this->Form->input('data[publishContents][chief_editor]',
						array(
							'type' => 'checkbox',
							'label' => array(
								'text' => __d('faqs', 'Chief Editor'),
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
		<label>コメント</label><br/>
		<div class="well well-sm" style="background-color:transparent">
			<div>
				<label>作成者</label><br/>
				<?php echo $this->Form->input('data[comment_creatable][room_admin]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('faqs', 'Room Administrator'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[comment_creatable][chief_editor]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('faqs', 'Chief Editor'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[comment_creatable][editor]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('faqs', 'Editor'),
							'style' => 'font-weight:normal',
						),
						'checked' => true,
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[comment_creatable][general_user]',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => __d('faqs', 'General User'),
							'style' => 'font-weight:normal',
						),
						'div' => false,
					));?>

				<?php echo $this->Form->input('data[comment_creatable][guests',
					array(
						'type' => 'checkbox',
						'label' => array(
							'text' => 'ゲスト',
							'style' => 'font-weight:normal',
						),
						'div' => false,
					));?>
			</div>
			<div>
				<label>承認機能</label><br/>
				<label style="font-weight:normal"><input type="radio" name="publishComments" ng-model="publishComments" ng-value="1">あり</label>
				<label style="font-weight:normal"><input type="radio" name="publishComments" ng-model="publishComments" ng-value="0" ng-init="publishComments = 0">なし</label>
			</div>
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
				<fieldset ng-disabled="! publishComments" collapse="! publishComments">
					<label>承認者</label><br/>
					<?php echo $this->Form->input('data[publishComments][room_admin]',
						array(
							'type' => 'checkbox',
							'label' => array(
								'text' => __d('faqs', 'Room Administrator'),
								'style' => 'font-weight:normal',
							),
							'div' => false,
							'checked' => true,
						));?>
					<?php echo $this->Form->input('data[publishComments][chief_editor]',
						array(
							'type' => 'checkbox',
							'label' => array(
								'text' => __d('faqs', 'Chief Editor'),
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
			<label>メール設定</label><br/>
			<label style="font-weight:normal"><input type="checkbox" name="mail" ng-model="sendMail">登録をメール通知する</label>
		</div>
		<div collapse="! sendMail" class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
			<label>通知する権限</label><br/>
			<?php echo $this->Form->input('data[send_mail][room_admin]',
				array(
					'type' => 'checkbox',
					'label' => array(
						'text' => __d('faqs', 'Room Administrator'),
						'style' => 'font-weight:normal',
					),
					'div' => false,
				));?>

			<?php echo $this->Form->input('data[send_mail][chief_editor]',
				array(
					'type' => 'checkbox',
					'label' => array(
						'text' => __d('faqs', 'Chief Editor'),
						'style' => 'font-weight:normal',
					),
					'div' => false,
				));?>

			<?php echo $this->Form->input('data[send_mail][editor]',
				array(
					'type' => 'checkbox',
					'label' => array(
						'text' => __d('faqs', 'Editor'),
						'style' => 'font-weight:normal',
					),
					'div' => false,
				));?>

			<?php echo $this->Form->input('data[send_mail][general_user]',
				array(
					'type' => 'checkbox',
					'label' => array(
						'text' => __d('faqs', 'General User'),
						'style' => 'font-weight:normal',
					),
					'div' => false,
				));?>
		</div>
	</div>

	<div class="text-center">
		<a class="btn btn-default" href="#" ng-click="cancel()">
			キャンセル
		</a>
		<a class="btn btn-primary"
		   href="<?php echo $this->Html->url('/' . $frame['pluginKey'] . '/blocks/edit/' . $frame['id']); ?>">
			決定
		</a>
	</div>
</form>

