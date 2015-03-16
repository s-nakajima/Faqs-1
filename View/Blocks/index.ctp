<!-- TODO:フレーム設定機能↓ -->
<?php
	echo $this->Html->script('http://rawgit.com/angular/bower-angular-sanitize/v1.2.25/angular-sanitize.js', false);
	echo $this->Html->script('http://rawgit.com/m-e-conroy/angular-dialog-service/v5.2.0/src/dialogs.js', false);
	echo $this->Html->script('/frames/js/frames.js', false);
	echo $this->Html->script('/blocks/js/blocks.js', false);
?>

<?php echo $this->element('Faqs.frame_menu', array('tab' => 'block')); ?>

<p class="text-right">
	<a  class="btn btn-sm btn-success"
		href="<?php echo $this->Html->url('/faqs/blocks/edit/' . $frame['id']);?>">

		<span class="glyphicon glyphicon-plus"></span>
	</a>
</p>

<div id="nc-faq-container-<?php echo $frameId; ?>"
	 ng-controller="BlocksController"
	 ng-init="
		blocks = <?php echo h(json_encode($blocks)); ?>;
		frameId = <?php echo h(json_encode($frameId)); ?>;
	 ">

	<table class="table table-striped">
		<thead>
			<tr>
				<th style="min-width:35px;"></th>
				<th style="min-width:100px;"><a href="#" ng-click="orderBlock('block.name')">名称</a></th>
				<th style="min-width:110px;"><a href="#" ng-click="orderBlock('block.publicType')">公開状況</a></th>
				<th style="min-width:100px;"><a href="#" ng-click="orderBlock('block.modified')">更新日</a></th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->Form->create(null, array(
					'name' => 'BlockForm' . $frameId,
					'novalidate' => true,
				)); ?>

			<tr ng-repeat="block in blocks | orderBy:orderByField:reverseSort">
				<td>
					<?php echo $this->Form->input('Block.id',
						array(
							'type' => 'radio',
							'name' => 'data[Block][id]',
							'options' => false,
							'div' => false,
							'legend' => false,
							'checked' => true,
							'ng-value' => 'block.block.id',
							'ng-click' => 'setBlock(frameId, block.block.id);',
							'ng-checked' => 'block.block.id === frame.blockId',
						)); ?>
				</td>
				<td>
					<div style="width:100px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
						<a href="<?php echo $this->Html->url('/' . $frame['pluginKey'] . '/blocks/edit/' . $frame['id'] . '/{{block.block.id}}');?>" ng-bind="block.block.name"></a>
					</div>
				</td>
				<td>
					<div ng-switch on="block.block.publicType">
						<span ng-switch-when="0">非公開</span>
						<span ng-switch-when="1">公開</span>
						<span ng-switch-when="2">期間限定公開</span>
					</div>
				</td>
				<td>
					<span ng-bind="parseDate(block.block.modified) | date: 'yyyy/MM/dd'"></span>
				</td>
			</tr>

			<?php echo $this->Form->end(); ?>
		</tbody>
	</table>

</div>
