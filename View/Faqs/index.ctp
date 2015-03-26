<?php
/**
 * faq index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/net_commons/base/js/workflow.js', false); ?>
<?php echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false); ?>
<?php echo $this->Html->script('/faqs/js/faqs.js'); ?>

<?php if(! $blockKey): ?>
	<?php echo __d('faqs', 'Currently FAQ has not been published.'); ?>
<?php else: ?>

		<div id="nc-faqs-<?php echo $frameId; ?>"
			 ng-controller="Faqs"
			 ng-init="initFaq(
				<?php echo h(json_encode($frameId)); ?>,
				<?php echo h(json_encode($categoryId)); ?>
				)">

			<?php if ($contentCreatable) : ?>
				<?php if ($contentPublishable) : ?>
				<p class="text-right">
					<a class="btn btn-default"
						href="<?php echo $this->Html->url('/faqs/blocks/index/' . $frameId);?>">
						<span class="glyphicon glyphicon-cog"></span>
					</a>
				</p>
				<?php endif; ?>
				<p class="text-right">
					<a class="btn btn-success" href="<?php echo $this->Html->url('/faqs/faqs/edit/' . $frameId) ?>">
						<span class="glyphicon glyphicon-plus"></span>
					</a>

					<?php if ($contentEditable) : ?>
					<a class="btn btn-primary" href="<?php echo $this->Html->url('/faqs/faqOrders/edit/' . $frameId) ?>">
						<span class="glyphicon glyphicon-cog"></span>
					</a>
					<?php endif; ?>
				</p>
			<?php endif; ?>

			<div>
				<div class="form-group form-inline text-right">
					<?php echo $this->Form->input('category',
						array(
							'label' => false,
							'type' => 'select',
							'class' => 'form-control',
							'empty' => array(0 => __d('categories', 'Select Category')),
							'options' => $categoryOptions,
							'ng-model' => 'selectedCategoryId',
							'ng-change' => 'selectCategory()',
						)); ?>
				</div>
				<?php if ($faqs): ?>
					<?php echo $this->element('Faqs/list'); ?>
				<?php else: ?>
					<?php echo __d('faqs', 'FAQ does not exist.'); ?>
				<?php endif; ?>
			</div>
		</div>

<?php endif;