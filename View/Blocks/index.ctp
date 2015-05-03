<?php
/**
 * block index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<div class="text-right">
			<a class="btn btn-success" href="<?php echo $this->Html->url('/faqs/blocks/add/' . $frameId);?>">
				<span class="glyphicon glyphicon-plus"> </span>
			</a>
		</div>

		<div id="nc-faq-setting-<?php echo $frameId; ?>">
			<?php echo $this->Form->create('', array(
					'url' => '/frames/frames/edit/' . $frameId
				)); ?>

				<?php echo $this->Form->hidden('Frame.id', array(
						'value' => $frameId,
					)); ?>

				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>
								<?php echo $this->Paginator->sort('Faq.name', __d('faqs', 'FAQ Name')); ?>
							</th>
							<th>
								<?php echo $this->Paginator->sort('Block.public_type', __d('faqs', 'Public Type')); ?>
							</th>
							<th>
								<?php echo $this->Paginator->sort('Block.modified', __d('faqs', 'Updated Date')); ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($faqs as $faq) : ?>
							<tr<?php echo ($blockId === $faq['block']['id'] ? ' class="active"' : ''); ?>>
								<td>
									<?php echo $this->Form->input('Frame.block_id',
										array(
											'type' => 'radio',
											'name' => 'data[Frame][block_id]',
											'options' => array((int)$faq['block']['id'] => ''),
											'div' => false,
											'legend' => false,
											'label' => false,
											'hiddenField' => false,
											'checked' => (int)$faq['block']['id'] === (int)$blockId,
											'onclick' => 'submit()'
										)); ?>
								</td>
								<td>
									<a href="<?php echo $this->Html->url('/faqs/blocks/edit/' . $frameId . '/' . (int)$faq['block']['id']); ?>">
										<?php echo h($faq['faq']['name']); ?>
									</a>
								</td>
								<td>
									<?php if ($faq['block']['publicType'] === '0') : ?>
										<?php echo __d('blocks', 'Private'); ?>
									<?php elseif ($faq['block']['publicType'] === '1') : ?>
										<?php echo __d('blocks', 'Public'); ?>
									<?php elseif ($faq['block']['publicType'] === '2') : ?>
										<?php echo __d('blocks', 'Limited Public'); ?>
									<?php endif; ?>
								</td>
								<td>
									<?php echo $this->Date->dateFormat($faq['block']['modified']); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo $this->Form->end(); ?>

			<div class="text-center">
				<?php echo $this->element('NetCommons.paginator', array(
						'url' => Hash::merge(
							array('controller' => 'blocks', 'action' => 'index', $frameId),
							$this->Paginator->params['named']
						)
					)); ?>
			</div>
		</div>
	</div>
</div>




