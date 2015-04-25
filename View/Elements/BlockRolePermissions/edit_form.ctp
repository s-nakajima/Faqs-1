<?php
/**
 * Faq edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('FaqSetting.id', array(
		'value' => isset($faqSetting['id']) ? (int)$faqSetting['id'] : null,
	)); ?>

<?php echo $this->element('Blocks.content_role_setting', array(
		'roles' => $roles,
		'permissions' => isset($blockRolePermissions) ? $blockRolePermissions : null,
		'useWorkflow' => array(
			'name' => 'FaqSetting.use_workflow',
			'value' => $faqSetting['useWorkflow']
		),
	));
