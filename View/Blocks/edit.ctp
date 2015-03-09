<!-- TODO:フレーム設定機能↓ -->
<?php
	echo $this->Html->script('http://rawgit.com/angular/bower-angular-sanitize/v1.2.25/angular-sanitize.js', false);
	echo $this->Html->script('http://rawgit.com/m-e-conroy/angular-dialog-service/v5.2.0/src/dialogs.js', false);
	echo $this->Html->script('/frames/js/frames.js', false);
?>

<?php echo $this->element('Faqs.frame_menu', array('tab' => 'block')); ?>

<?php echo $this->element('Faqs.block_menu', array('tab' => 'general')); ?>

<form novalidate>

	<div class="form-group">
		<label>名称</label>
		<input type="text" class="form-control" value="FAQ_A">
	</div>

	<div class="form-group">

		<label>公開設定</label><br/>
		<label style="font-weight:normal"><input type="radio" name="publishStatus" ng-model="publishStatus" ng-value="1" ng-init="publishStatus = 1">公開中</label>
		<label style="font-weight:normal"><input type="radio" name="publishStatus" ng-model="publishStatus" ng-value="2">期間限定公開</label>
		<label style="font-weight:normal"><input type="radio" name="publishStatus" ng-model="publishStatus" ng-value="0">非公開</label>

		<div class="row">
			<div class="col-md-5 col-sm-5">
				<p class="input-group">
					<input type="text" class="form-control"
						ng-model="publishedStart"
						datepicker-popup
						is-open="isStartDate"
						ng-disabled="publishStatus != 2">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default"
								ng-click="dateOpen($event, 'start')"
								ng-disabled="publishStatus != 2">
							<i class="glyphicon glyphicon-calendar"></i>
						</button>
					</span>
				</p>
			</div>
			<div class="col-md-2 col-sm-2 text-center">
			～
			</div>
			<div class="col-md-5 col-sm-5">
				<p class="input-group">
					<input type="text" class="form-control"
						ng-model="publishedEnd"
						datepicker-popup
						is-open="isEndDate"
						ng-disabled="publishStatus != 2">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default"
								ng-click="dateOpen($event, 'end')"
								ng-disabled="publishStatus != 2">
							<i class="glyphicon glyphicon-calendar"></i>
						</button>
					</span>
				</p>
			</div>
		</div>

	</div>

	<div class="form-group">
		<label>評価機能</label>
		<div>
			<label style="font-weight:normal"><input type="checkbox" name="isVote" ng-model="isVote">
				<span class="glyphicon glyphicon-thumbs-up"></span>
				高く評価を使用する
			</label>
		</div>
		<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
			<label style="font-weight:normal"><input type="checkbox" name="isVoteUnLike" ng-model="isVoteUnLike" ng-disabled="! isVote">
				<span class="glyphicon glyphicon-thumbs-down"></span>
				低く評価も使用する
			</label>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<span>カテゴリ</span>
			<div class="pull-right">
				<a class="btn btn-xs btn-primary"
				   href="<?php echo $this->Html->url('/' . $frame['plugin_key'] . '/categories/edit/' . $frame['id'] . '/3');?>">
					<span class="glyphicon glyphicon-edit"></span>
				</a>
			</div>
		</div>
		<div class="panel-body">
			<span ng-repeat="category in categories">
				<span ng-bind="category.name"></span>,
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
			<button type="button" class="btn btn-danger pull-right" ng-click="deleteBlock(blocks.0.name)">
				削除
			</button>
		</accordion-group>
	</accordion>

	<div class="text-center">
		<a  class="btn btn-default"
			href="<?php echo $this->Html->url('/' . $frame['plugin_key'] . '/blocks/index/' . $frame['id']);?>">
			キャンセル
		</a>
		<a  class="btn btn-primary"
			href="<?php echo $this->Html->url('/' . $frame['plugin_key'] . '/blocks/index/' . $frame['id']);?>">
			決定
		</a>
	</div>

</form>

