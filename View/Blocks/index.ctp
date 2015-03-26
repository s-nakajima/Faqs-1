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
	echo $this->Html->script('/net_commons/base/js/workflow.js', false);
	echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false);
	echo $this->Html->script('http://rawgit.com/angular/bower-angular-sanitize/v1.2.25/angular-sanitize.js', false);
	echo $this->Html->script('http://rawgit.com/m-e-conroy/angular-dialog-service/v5.2.0/src/dialogs.js', false);
	echo $this->Html->script('/frames/js/frames.js', false);
	echo $this->Html->script('/faqs/js/faqs.js', false);

	echo $this->Html->css('/faqs/css/faqs.css');
?>

<?php echo $this->element('Faqs.frame_menu', array('tab' => 'block')); ?>

<div class="text-right">
	<a  class="btn btn-sm btn-success"
		href="<?php echo $this->Html->url('/faqs/blocks/edit/' . $frameId);?>">

		<span class="glyphicon glyphicon-plus"></span>
	</a>
</div>

<?php if(! count($blocks)): ?>
	<?php echo __d('faqs', 'Currently FAQ has not been created.'); ?>
<?php else: ?>
		<div id="nc-faq-container-<?php echo $frameId; ?>"
			 ng-controller="Faqs"
			 ng-init="
				blocks = <?php echo h(json_encode($blocks)); ?>;
				frameId = <?php echo h(json_encode($frameId)); ?>;
				selectedBlockId = <?php echo h(json_encode($blockId)); ?>;
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
									'ng-value' => 'block.faqBlock.id',
									'ng-click' => 'setBlock(frameId, block.faqBlock.id);',
									'ng-checked' => 'block.faqBlock.id === selectedBlockId',
								)); ?>
						</td>
						<td>
							<div>
								<a href="<?php echo $this->Html->url('/' . h($frame['pluginKey']) . '/blocks/edit/' . $frameId . '/{{block.faqBlock.id}}');?>" ng-bind="block.faqBlock.name"></a>
							</div>
						</td>
						<td>
							<div ng-switch on="block.faqBlock.publicType">
								<span ng-switch-when="<?php echo FaqBlock::TYPE_PRIVATE; ?>">
									<?php echo __d('blocks', 'Private'); ?>
								</span>
								<span ng-switch-when="<?php echo FaqBlock::TYPE_PUBLIC; ?>">
									<?php echo __d('blocks', 'Public'); ?>
								</span>
								<span ng-switch-when="<?php echo FaqBlock::TYPE_LIMITED_PUBLIC; ?>">
									<?php echo __d('blocks', 'Limited Public'); ?>
								</span>
							</div>
						</td>
						<td>
							<span ng-bind="parseDate(block.faqBlock.modified) | date: 'yyyy/MM/dd'"></span>
						</td>
					</tr>

					<?php echo $this->Form->end(); ?>
				</tbody>
			</table>
			<div>
				<?php echo $this->Paginator->numbers(); ?>
			</div>

		</div>
<?php endif;