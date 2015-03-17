<?php
/**
 * frame setting frame menu element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ul class="nav nav-tabs">
	<li role="presentation" class="<?php echo ($tab === 'block') ? 'active' : ''; ?>">
		<a href="<?php echo $this->Html->url('/' . $frame['pluginKey'] . '/blocks/index/' . $frame['id']);?>">
			<?php echo __d('frames', 'List'); ?>
		</a>
	</li>
	<li role="presentation" class="">
		<a href="">
			<?php echo __d('frames', 'Display Change'); ?>
		</a>
	</li>
</ul>
<br>
