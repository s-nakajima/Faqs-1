<?php
/**
 * faq block index template
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
	echo $this->Html->script('/blocks/js/blocks.js', false);
?>

<?php echo $this->element('Faqs.frame_menu', array('tab' => 'block')); ?>

<div class="text-right">
	<a  class="btn btn-sm btn-success"
		href="<?php echo $this->Html->url('/faqs/blocks/edit/' . $frameId);?>">

		<span class="glyphicon glyphicon-plus"></span>
	</a>
</div>

<div id="nc-faq-container-<?php echo $frameId; ?>"
	 ng-controller="BlocksController"
	 ng-init="
		blocks = <?php echo h(json_encode($blocks)); ?>;
		frameId = <?php echo h(json_encode($frameId)); ?>;
	 ">

	<table class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th>
					<a href="#" ng-click="orderBlock('block.name')">
						<?php echo __d('blocks', 'Name'); ?>
					</a>
				</th>
				<th>
					<a href="#" ng-click="orderBlock('block.publicType')">
						<?php echo __d('blocks', 'Public Type'); ?>
					</a>
				</th>
				<th>
					<a href="#" ng-click="orderBlock('block.modified')">
						<?php echo __d('net_commons', 'Updated Date'); ?>
					</a>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->Form->create(null, array(
					'name' => 'BlockForm' . $frameId,
					'novalidate' => true,
				)); ?>

			<tr ng-repeat="block in blocks | orderBy:orderByField:isOrderDesc">
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
						<a href="<?php echo $this->Html->url('/' . h($frame['pluginKey']) . '/blocks/edit/' . $frameId . '/{{block.block.id}}');?>" ng-bind="block.block.name"></a>
					</div>
				</td>
				<td>
					<div ng-switch on="block.block.publicType">
						<span ng-switch-when="0">
							<?php echo __d('blocks', 'Private'); ?>
						</span>
						<span ng-switch-when="1">
							<?php echo __d('blocks', 'Public'); ?>
						</span>
						<span ng-switch-when="2">
							<?php echo __d('blocks', 'Limited Public'); ?>
						</span>
					</div>
				</td>
				<td>
					<span ng-bind="parseDate(block.block.modified) | date: 'yyyy/MM/dd'"></span>
				</td>
			</tr>

			<?php echo $this->Form->end(); ?>
		</tbody>
	</table>
	<div>
		<?php echo $this->Paginator->numbers(); ?>
	</div>

</div>
