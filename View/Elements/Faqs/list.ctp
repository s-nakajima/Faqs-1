<?php
/**
 * Faqs list element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div ng-repeat="faq in faqList track by $index" ng-cloak>
	<p>
		<div class="row">
			<?php if ($manageMode) : ?>

				<div class="text-left col-xs-12 col-md-1">
					<button class="btn btn-default btn-xs"
							ng-click="changeFaqOrder('up', $index)"
							ng-disabled="$first">

						<span class="glyphicon glyphicon-arrow-up"></span>
					</button>
					<button class="btn btn-default btn-xs"
							ng-click="changeFaqOrder('down', $index)"
							ng-disabled="$last">

						<span class="glyphicon glyphicon-arrow-down"></span>
					</button>
				</div>

			<?php endif ?>

			<div class="text-left col-xs-12 col-md-1">
				<span class="label label-warning">
					Q
				</span>
			</div>

			<div class="col-xs-12
				 <?php echo ($manageMode ? 'col-md-10' : 'col-md-11'); ?>">

				<a href="#" ng-click="switchAnswerDisplay($index)" onclick="return false;">
					{{faq.Faq.question}}
				</a>

				<span ng-switch="faq.Faq.status">
					<span class="label label-danger"
						  ng-switch-when="<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>">
						<?php echo __d('net_commons', 'Disapproval'); ?>
					</span>
					<span class="label label-info"
						  ng-switch-when="<?php echo NetCommonsBlockComponent::STATUS_INDRAFT ?>">
						<?php echo __d('net_commons', 'Temporary'); ?>
					</span>
					<span class="label label-warning"
						  ng-switch-when="<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>">
						<?php echo __d('net_commons', 'Approving'); ?>
					</span>
				</span>
			</div>
		</div>

		<div class="row" ng-show="answerIndex[$index]">
			<br />

			<div class="text-left col-xs-12 col-md-1
				 <?php echo ($manageMode ? 'col-md-offset-1' : ''); ?>">

				<span class="label label-primary">
					A
				</span>
			</div>

			<div class="col-xs-12
				 <?php echo ($manageMode ? 'col-md-10' : 'col-md-11'); ?>">
				{{faq.Faq.answer}}
			</div>

			<br />
		</div>
	</p>

	<div ng-if="'<?php echo $contentEditable; ?>' ||
				'<?php echo CakeSession::read('Auth.User.id'); ?>' == faq.Faq.created_user">

		<?php echo $this->element('Faqs/list_edit_btn'); ?>
	</div>
	<hr>
</div>
