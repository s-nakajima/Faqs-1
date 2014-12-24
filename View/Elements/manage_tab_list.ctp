<?php
/**
 * manage tab header element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php $this->startIfEmpty('tabList'); ?>
<li ng-class="{active:tab.isSet(0)}">
	<a href="#" ng-click="showSetting('faqs')">
		<?php echo __d('faqs', 'FAQ edit'); ?>
	</a>
</li>

<?php if ($contentPublishable) : ?>
	<li ng-class="{active:tab.isSet(1)}">
		<a href="#" ng-click="showSetting('faq_categories')">
			<?php echo __d('faqs', 'Category edit'); ?>
		</a>
	</li>
	<li ng-class="{active:tab.isSet(2)}">
		<a href="#" ng-click="showSetting('faq_frame_settings')">
			<?php echo __d('net_commons', 'Display change'); ?>
		</a>
	</li>
	<li ng-class="{active:tab.isSet(3)}">
		<a href="#" ng-click="showSetting('faq_authority_settings')">
			<?php echo __d('faqs', 'Authority setting'); ?>
		</a>
	</li>
<?php endif; ?>

<?php $this->end();