<?php
/**
 * frame setting block menu element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="nc-faqs-tab">
	<ul class="nav nav-pills">
		<li role="presentation" class="<?php echo ($tab === 'general') ? 'active' : ''; ?>">
			<a href="<?php echo $this->Html->url('/' . h($frame['pluginKey']) . '/blocks/edit/' . $frameId . '/' . (int)$block['id']);?>">
				<?php echo __d('frames', 'Content'); ?>
			</a>
		</li>
		<li role="presentation" class="<?php echo ($tab === 'auth') ? 'active' : ''; ?>">
			<a href="<?php echo $this->Html->url('/' . h($frame['pluginKey']) . '/blocks/editAuth/' . $frameId . '/' . (int)$block['id']);?>">
				<?php echo __d('frames', 'Authority Setting'); ?>
			</a>
		</li>
	</ul>
</div>
