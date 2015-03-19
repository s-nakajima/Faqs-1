<?php
/**
 * faq order edit template
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

<div id="nc-faqs-<?php echo $frameId; ?>"
	 ng-controller="Faqs"
	 ng-init="initFaqOrder(<?php echo h(json_encode($this->viewVars)); ?>)">

	<?php echo $this->Form->create('Faq', array('name' => 'faqOrderForm', 'novalidate' => true)); ?>
		<div class="panel panel-default" >
			<div class="panel-body has-feedback">

				<ul class="list-group">
					<li class="list-group-item" ng-repeat="faq in faqs track by $index" ng-cloak>
						<div class="row">
							<div class="col-md-2 col-sm-2 col-xs-2">
								<button class="btn btn-default btn-sm"
										ng-click="sortFaq('up', $index)" ng-disabled="$first" onclick="return false;">
									<span class="glyphicon glyphicon-arrow-up"></span>
								</button>
								<button class="btn btn-default btn-sm"
										ng-click="sortFaq('down', $index)" ng-disabled="$last" onclick="return false;">
									<span class="glyphicon glyphicon-arrow-down"></span>
								</button>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-10">
								<?php echo $this->Form->hidden('', array('name' => 'data[{{$index}}][FaqOrder][faq_key]', 'ng-value' => 'faq.faqOrder.faqKey')); ?>
								{{faq.faq.question}}
							</div>
						</div>
					</li>
				</ul>

			</div>

			<div class="panel-footer text-center">
				<div class="text-center">
					<button type="button" class="btn btn-default" ng-click="cancel()">
						<span class="glyphicon glyphicon-remove small"></span>
						<?php echo __d('net_commons', 'Cancel'); ?>
					</button>
					<?php echo $this->Form->button(
						__d('net_commons', 'OK'),
						array('class' => 'btn btn-primary')) ?>
				</div>
			</div>
		</div>

	<?php echo $this->Form->end(); ?>

</div>
