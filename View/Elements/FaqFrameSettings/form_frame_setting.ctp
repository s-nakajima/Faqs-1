<?php
/**
 * FaqFrameSettings form frame setting element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class='form-group'>
	<label>
		<?php echo __d('faqs', 'Display FAQ'); ?>
	</label>
	<div class="row">
		<div class="col-xs-1">
			<input type="checkbox"
				   value="true"
				   id="display_category"
				   ng-model="displaySelectedCategory"
				   ng-click="changeDisplaySelectedCategory()"
				   >
		</div>
		<div class="col-xs-10">
			<label for="display_category">
				<?php echo __d('faqs', 'Display only the selected category.'); ?>
			</label>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-offset-1 col-xs-11">
			<?php
				echo $this->Form->input('category', array(
					'label' => false,
					'type' => 'select',
					'empty' => __d('faqs', 'Please select category.'),
					'ng-options' => 'option.FaqCategory.id as option.FaqCategory.name for option in categoryOptions',
					'class' => 'form-control',
					'ng-model' => 'faqDisplayParams.data.FaqFrameSetting.display_category',
					'ng-disabled' => '!displaySelectedCategory',
				));
			?>
		</div>
	</div>
</div>
{{displaySelectCategory}}
<div class='form-group'>
	<?php
		echo $this->Form->label('display_count', __d('faqs', 'Display number'));

		echo $this->Form->input('display_count', array(
			'label' => false,
			'type' => 'select',
			'options' => FaqFrameSetting::getDisplayNumberOptions(),
			'class' => 'form-control',
			'ng-model' => 'faqDisplayParams.data.FaqFrameSetting.display_number',
		));
	?>
</div>
