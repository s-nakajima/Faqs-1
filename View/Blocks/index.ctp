<!-- TODO:フレーム設定機能↓ -->
<?php
	echo $this->Html->script('http://rawgit.com/angular/bower-angular-sanitize/v1.2.25/angular-sanitize.js', false);
	echo $this->Html->script('http://rawgit.com/m-e-conroy/angular-dialog-service/v5.2.0/src/dialogs.js', false);
	echo $this->Html->script('/frames/js/frames.js', false);
?>

<?php echo $this->element('Faqs.frame_menu', array('tab' => 'block')); ?>

<p class="text-right">
	<a  class="btn btn-sm btn-success"
		href="<?php echo $this->Html->url('/faqs/blocks/edit/' . $frame['id']);?>">

		<span class="glyphicon glyphicon-plus"></span>
	</a>
</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th style="min-width:35px;"></th>
			<th style="min-width:100px;"><a href="" ng-click="orderBlock('name')">名称</a></th>
			<th style="min-width:110px;"><a href="" ng-click="orderBlock('isPublished')">公開状況</a></th>
			<th style="min-width:100px;"><a href="" ng-click="orderBlock('modified')">更新日時</a></th>
			<th style="min-width:50px;">管理</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="block in blocks | orderBy:orderByField:reverseSort">
			<td>
				<input type="radio" name="displayBlock" ng-model="blockId" ng-value="block.id" ng-change="displayBlock(block.name)">
			</td>
			<td>
				<div style="width:100px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
					<a href="<?php echo $this->Html->url('/' . $frame['plugin_key'] . '/blocks/edit/' . $frame['id']);?>" ng-bind="block.name"></a>
				</div>
			</td>
			<td><span ng-bind="block.isPublished"></span></td>
			<td><span ng-bind="block.modified"></span></td>
			<td><a href="#">CSV出力</a></td>
		</tr>
	</tbody>
</table>
