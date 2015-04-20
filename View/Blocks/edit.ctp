<?php
/**
 * Block edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

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
					'block_settings' => '/faqs/blocks/' . h($this->request->params['action']) . '/' . $frameId . '/' . $blockId,
					'role_permissions' => '/faqs/block_role_permissions/index/' . $frameId . '/' . $blockId
				),
				'active' => 'block_settings'
			)); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'Blocks',
				'action' => h($this->request->params['action']) . '/' . $frameId . '/' . $blockId,
				'callback' => 'Faqs.Blocks/edit_form',
				'cancel' => '/faqs/blocks/index/' . $frameId
			)); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'controller' => 'Blocks',
					'action' => 'delete/' . $frameId . '/' . $blockId,
					'callback' => 'Faqs.Blocks/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</div>
