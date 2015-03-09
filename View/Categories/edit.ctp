<?php
/**
 * Categories view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('http://rawgit.com/angular/bower-angular-sanitize/v1.2.25/angular-sanitize.js', false); ?>
<?php echo $this->Html->script('http://rawgit.com/m-e-conroy/angular-dialog-service/v5.2.0/src/dialogs.js', false); ?>
<?php echo $this->Html->script('/frames/js/frames.js', false); ?>
<?php echo $this->Html->script('/categories/js/categories.js'); ?>

<?php $pluginsName = ucfirst($frame['plugin_key']); ?>

<?php echo $this->element($pluginsName . '.frame_menu', array('tab' => 'block')); ?>
<?php echo $this->element($pluginsName . '.block_menu', array('tab' => 'general')); ?>
<?php echo $this->element('Categories.Categories/edit');