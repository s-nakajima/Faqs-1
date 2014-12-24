<?php
/**
 * Faqs list edit btn element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="text-right">
	<button class="btn btn-warning btn-xs"
			tooltip="<?php echo __d('faqs', 'Publish'); ?>"
			ng-controller="Faqs.Edit"
			ng-click="publishFaq(faq)"
			ng-if="'<?php echo $contentPublishable; ?>' &&
					faq.Faq.status === '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>'">

		<span class="glyphicon glyphicon-ok"></span>
	</button>
	<button class="btn btn-primary btn-xs"
			tooltip="<?php echo __d('faqs', 'Edit'); ?>"
			ng-click="showFaqView(faq.Faq.id)">

		<span class="glyphicon glyphicon-edit"> </span>
	</button>
	<button class="btn btn-default btn-xs"
			tooltip="<?php echo __d('faqs', 'Delete'); ?>"
			ng-click="deleteFaq(faq.Faq.id)">

		<span class="glyphicon glyphicon-trash"> </span>
	</button>
</div>