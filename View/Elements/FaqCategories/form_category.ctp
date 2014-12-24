<?php
/**
 * FaqCategories form category element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php $form = 'FaqCategoryForm' . (int)$frameId; ?>

<div class="row form-group"
	 ng-repeat="category in categoryList track by $index">
	<form name="<?php echo $form; ?>" novalidate>
		<div ng-init="categoryInitialize($index, <?php echo $form; ?>)">

			<div class="text-left col-xs-2 col-md-2">
				<button class="btn btn-default btn-xs"
						ng-click="changeCategoryOrder('up', $index)"
						ng-disabled="$first">
					<span class="glyphicon glyphicon-arrow-up"></span>
				</button>
				<button class="btn btn-default btn-xs"
						ng-click="changeCategoryOrder('down', $index)"
						ng-disabled="$last">
					<span class="glyphicon glyphicon-arrow-down"></span>
				</button>
			</div>
			<div ng-class="faqCategoryForm[$index].name.validationErrors ? 'has-error' : ''">
				<div class="col-xs-7 col-md-7">
					<input type="text" name="name" class="form-control" required
						   ng-model="category.FaqCategory.name"
						   ng-change="serverValidationClear(faqCategoryForm[$index], 'name')"
						/>
				</div>
			</div>

			<?php echo $this->element('FaqCategories/form_category_btn'); ?>

		</div>
	</form>

</div>

<?php $index = 'new'; ?>

<div class="row form-group">
	<form name="<?php echo $form; ?>" novalidate>
		<div ng-init="categoryInitialize(
			<?php echo $index; ?>,
			<?php echo $form; ?>)">

			<div ng-class="faqCategoryForm[<?php echo $index; ?>].name.validationErrors ? 'has-error' : ''">
				<div class="col-xs-offset-2 col-md-offset-2 col-xs-7 col-md-7">
					<input type="text" name="name" class="form-control" required
						   ng-model="categoryTemplate.FaqCategory.name"
						   ng-change="serverValidationClear(faqCategoryForm[<?php echo $index; ?>], 'name')"
						/>
				</div>
			</div>

			<div class="text-left col-xs-2 col-md-1">
				<button class="btn btn-success btn-xs"
						ng-click="saveCategory(<?php echo $index; ?>)"
						tooltip="<?php echo __d('faqs', 'Add'); ?>"
						>
					<span class="glyphicon glyphicon-plus"></span>
				</button>
			</div>

		</div>
	</form>

</div>
