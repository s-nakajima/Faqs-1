<!-- TODO:フレーム設定機能↓ -->
<?php
	echo $this->Html->script('http://rawgit.com/angular/bower-angular-sanitize/v1.2.25/angular-sanitize.js', false);
	echo $this->Html->script('http://rawgit.com/m-e-conroy/angular-dialog-service/v5.2.0/src/dialogs.js', false);
	echo $this->Html->script('/frames/js/frames.js', false);
	echo $this->Html->script('/blocks/js/blocks.js', false);
?>

<?php echo $this->element('Faqs.frame_menu', array('tab' => 'block')); ?>

<?php if ($block['id']) : ?>
<?php echo $this->element('Faqs.block_menu', array('tab' => 'general')); ?>
<?php endif; ?>

<div id="nc-faq-container-<?php echo $frameId; ?>"
	 ng-controller="BlocksController"
	 ng-init="
	 	block = <?php echo h(json_encode($block)); ?>;
	 	categoryList = <?php echo h(json_encode($categoryList)); ?>;
	 	">

	<?php echo $this->Form->create(null, array(
			'name' => 'FaqBlockForm' . $frameId,
			'novalidate' => true,
		)); ?>

		<?php echo $this->element('Blocks.edit_form'); ?>

		<div class="form-group">
			<label>評価機能（サンプル）</label>
			<div>
				<label style="font-weight:normal"><input type="checkbox" ng-model="isVote">
					<span class="glyphicon glyphicon-thumbs-up"></span>
					高く評価を使用する
				</label>
			</div>
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
				<label style="font-weight:normal"><input type="checkbox" ng-model="isVoteUnLike" ng-disabled="! isVote">
					<span class="glyphicon glyphicon-thumbs-down"></span>
					低く評価も使用する
				</label>
			</div>
		</div>

<?php if ($block['id']) : ?>
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<span>カテゴリ</span>
				<div class="pull-right">
					<a class="btn btn-xs btn-primary"
					   href="<?php echo $this->Html->url('/' . $frame['pluginKey'] . '/categories/edit/' . $frameId . '/' . $block['id']);?>">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<span ng-repeat="c in categoryList">
					<span ng-bind="c.category.name"></span>,
				</span>
			</div>
		</div>

		<accordion close-others="false">
			<accordion-group is-open="dangerSetting.open" class="panel-danger">
				<accordion-heading>
					危険領域
					<i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': dangerSetting.open, 'glyphicon-chevron-right': !dangerSetting.open}"></i>
				</accordion-heading>
				<strong>ブロック削除</strong><br/>
				<div class="inline-block">
					<span>"{{blocks.0.name}}"に関連するデータ全てを削除します。</span><br/>
					<span>一度削除すると元に戻せません。</span>
				</div>
				<?php echo $this->Form->button(
					'削除',
					array('name' => 'delete', 'class' => 'btn btn-danger pull-right')); ?>
			</accordion-group>
		</accordion>
<?php endif; ?>

		<p class="text-center">
			<button type="button" class="btn btn-default" ng-click="cancel()">
				<span class="glyphicon glyphicon-remove small"></span>
				<?php echo __d('net_commons', 'Cancel'); ?>
			</button>
			<?php echo $this->Form->button(
				__d('net_commons', 'OK'),
				array('name' => 'edit', 'class' => 'btn btn-primary')); ?>
		</p>

	<?php echo $this->Form->end(); ?>
</div>

