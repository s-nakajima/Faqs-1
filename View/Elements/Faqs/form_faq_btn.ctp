<?php
/**
 * Faqs form faq btn element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="cancel()">
		<?php echo __d('net_commons', 'Cancel'); ?>
	</button>
	<span>
		<button type="button" class="btn btn-danger"
				ng-click="saveFaq('<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>')"
				ng-if="'<?php echo $contentPublishable; ?>' &&
						status == '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>'">
			<?php echo __d('net_commons', 'Disapproval'); ?>
		</button>
		<button type="button" class="btn btn-default"
				ng-click="saveFaq('<?php echo NetCommonsBlockComponent::STATUS_IN_DRAFT ?>')"
				ng-if="! '<?php echo $contentPublishable; ?>' ||
						status != '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>'">
			<?php echo __d('net_commons', 'Save temporally'); ?>
		</button>
	</span>
	<span>
		<button type="button" class="btn btn-primary"
				ng-click="saveFaq('<?php echo NetCommonsBlockComponent::STATUS_PUBLISHED ?>')"
				ng-if="'<?php echo $contentPublishable; ?>'">
			<?php echo __d('net_commons', 'OK'); ?>
		</button>
		<button type="button" class="btn btn-warning"
				ng-click="saveFaq('<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>')"
				ng-if="! '<?php echo $contentPublishable; ?>'">
			<?php echo __d('net_commons', 'OK'); ?>
		</button>
	</span>
</p>