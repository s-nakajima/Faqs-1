<?php
/**
 * FaqCategories form category btn element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="text-center col-xs-1 col-md-1">
	<button class="btn btn-primary btn-xs"
			tooltip="<?php echo __d('net_commons', 'OK'); ?>"
			ng-click="saveCategory($index)">

		<span class="glyphicon glyphicon-ok"></span>
	</button>
</div>

<div class="text-center col-xs-1 col-md-1">
	<button class="btn btn-default btn-xs"
			tooltip="<?php echo __d('faqs', 'Delete'); ?>"
			ng-click="deleteCategory(category.FaqCategory.id, $index)">

		<span class="glyphicon glyphicon-trash"> </span>
	</button>
</div>
