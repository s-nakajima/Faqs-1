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

<?php echo $this->Html->script('/faqs/js/faqs_controller.js'); ?>
<?php echo $this->Html->script('/faqs/js/faqs_service.js'); ?>

<div id="nc-faqs-container-<?php echo (int)$frameId; ?>"
	 ng-controller="Faqs"
	 ng-init="initialize(
		<?php echo (int)$frameId; ?>,
		<?php echo h(json_encode($faqList)); ?>,
		<?php echo (int)$faqListTotal; ?>,
		<?php echo h(json_encode($faqSetting)); ?>,
		<?php echo h(json_encode($categoryOptions)); ?>
	 )">

	<?php if ($contentCreatable) : ?>
		<p class="text-right">
			<button class="btn btn-success"
					tooltip="<?php echo __d('faqs', 'Add FAQ'); ?>"
					ng-click="showFaqView()">

				<span class="glyphicon glyphicon-plus"></span>
			</button>

			<?php if ($contentEditable) : ?>
			<button class="btn btn-primary"
					tooltip="<?php echo __d('net_commons', 'Manage'); ?>"
					ng-click="showSetting('faqs')">

				<span class="glyphicon glyphicon-cog"></span>
			</button>
			<?php endif; ?>
		</p>
	<?php endif; ?>

	<div id="nc-faqs-container-<?php echo (int)$frameId; ?>">
		<div>

			<div class="text-right">
				<?php echo $this->element('Faqs/list_header'); ?>
			</div>
			<hr>

			<div ng-hide="faqListTotal">
				<?php echo __d('faqs', 'FAQ does not exist.'); ?>
			</div>
			<div ng-show="faqListTotal">
				<?php echo $this->element('Faqs/list', array('manageMode' => 0)); ?>

				<?php echo $this->element('Faqs/list_footer'); ?>
			</div>

		</div>
	</div>

</div>
