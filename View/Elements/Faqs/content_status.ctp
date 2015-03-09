
<span class="text-right inline-block;" ng-switch="faq.faq.status">
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
