<?php
/**
 * Categories index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
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
					'role_permissions' => '/faqs/block_role_permissions/edit/' . $frameId . '/' . $blockId
				),
				'active' => 'block_settings'
			)); ?>

		<?php echo $this->element('Categories.edit_form', array(
				'cancelUrl' => '/faqs/blocks/' . h($this->request->params['action']) . '/' . $frameId . '/' . $blockId,
			)); ?>

	</div>
</div>

