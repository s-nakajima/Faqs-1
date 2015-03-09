<?php
/**
 * Faqs view template
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

<?php if(! $blockId): ?>
	FAQは操作しないようお願いします。（フレーム設定機能取込中のため）
<?php else: ?>
		<div id="nc-faqs-<?php echo $frameId; ?>"
			 ng-controller="Faqs"
			 ng-init="initFaq(<?php echo h(json_encode($this->viewVars)); ?>)">

			<?php if ($contentCreatable) : ?>
				<p class="text-right">
					<a class="btn btn-success" href="<?php echo $this->Html->url('/faqs/faqs/edit/' . $frameId) ?>">
						<span class="glyphicon glyphicon-plus"></span>
					</a>

					<?php if ($contentEditable) : ?>
					<a class="btn btn-primary" href="<?php echo $this->Html->url('/faqs/faqOrders/edit/' . $frameId) ?>">
						<span class="glyphicon glyphicon-sort"></span>
					</a>
					<?php endif; ?>
				</p>
			<?php endif; ?>

			<div>
				<div class="form-inline text-right">
					<?php echo $this->Form->input('category',
						array(
							'label' => false,
							'type' => 'select',
							'ng-options' => 'opt as opt.category.name for opt in categoryOptions track by opt.category.id',
							'empty' => __d('faqs', 'Select category'),
							'class' => 'form-control',
							'ng-model' => 'selectedCategory',
							'ng-change' => 'selectCategory()',
						)); ?>
				</div>
				<hr>
				<div ng-hide="faqList">
					<?php echo __d('faqs', 'FAQ does not exist.'); ?>
				</div>
				<div ng-show="faqList">
					<?php echo $this->element('Faqs/list', array('manageMode' => 0)); ?>
				</div>
			</div>
		</div>
<?php endif;