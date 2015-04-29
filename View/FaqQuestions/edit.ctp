<?php
/**
 * Question edit form
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false); ?>
<?php echo $this->Html->script('/faqs/js/faqs.js', false); ?>

<div class="frame">
	<div id="nc-faqs-<?php echo $frameId; ?>" class="nc-content-list"
		 ng-controller="FaqQuestions"
		 ng-init="initialize(<?php echo h(json_encode(array('frameId' => $frameId, 'faqQuestion' => $faqQuestion))); ?>)">

		<article>
			<h1>
				<small><?php echo h($faq['name']); ?></small>
			</h1>

			<div class="panel panel-default">
				<?php echo $this->Form->create('FaqQuestion', array('novalidate' => true)); ?>
					<div class="panel-body">

						<?php echo $this->element('FaqQuestions/edit_form'); ?>

						<hr />

						<?php echo $this->element('Comments.form'); ?>

					</div>
					<div class="panel-footer text-center">
						<?php echo $this->element('NetCommons.workflow_buttons'); ?>
					</div>
				<?php echo $this->Form->end(); ?>

				<?php if ($this->request->params['action'] === 'edit') : ?>
					<div class="panel-footer text-right">
						<?php echo $this->element('FaqQuestions/delete_form'); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php echo $this->element('Comments.index'); ?>
		</article>
	</div>
</div>
