<?php
/**
 * faq content status element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<span class="text-right inline-block" ng-switch="faq.faq.status">
	<span class="label label-danger"
		  ng-switch-when="<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>">
		<?php echo __d('net_commons', 'Disapproval'); ?>
	</span>
	<span class="label label-info"
		  ng-switch-when="<?php echo NetCommonsBlockComponent::STATUS_IN_DRAFT ?>">
		<?php echo __d('net_commons', 'Temporary'); ?>
	</span>
	<span class="label label-warning"
		  ng-switch-when="<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>">
		<?php echo __d('net_commons', 'Approving'); ?>
	</span>
</span>
