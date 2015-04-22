<?php
/**
 * BbsSettings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/faqs/js/faqs.js', false); ?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', array(
			'tabs' => array(
				'block_index' => '/faqs/blocks/index/' . $frameId,
			),
			'active' => 'block_index'
		)); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.setting_tabs', array(
				'tabs' => array(
					'block_settings' => '/faqs/blocks/edit/' . $frameId . '/' . $blockId,
					'role_permissions' => '/faqs/block_role_permissions/edit/' . $frameId . '/' . $blockId
				),
				'active' => 'role_permissions'
			)); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'BlockRolePermission',
				'action' => 'edit' . '/' . $frameId . '/' . $blockId,
				'callback' => 'Faqs.BlockRolePermissions/edit_form',
				'cancel' => '/faqs/blocks/index/' . $frameId,
				//'options' => array('ng-controller' => 'Bbses'),
			)); ?>
	</div>
</div>
