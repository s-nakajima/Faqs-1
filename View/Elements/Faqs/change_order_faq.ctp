<div class="row">
	<?php echo $this->element('Faqs/content_move_btn', array(
		'size' => '12 col-md-1',
		'upDisabled' => (isset($upDisabled) ? $upDisabled : false),
		'downDisabled' => (isset($downDisabled) ? $downDisabled : false))); ?>

	<div class="text-left col-xs-12 col-md-1 h4">
		<span class="label label-warning h4">Q</span>
	</div>
	<div class="col-xs-12 col-md-10">
		<a href="#" ng-click="changeAnswer(<?php echo $answerIndex; ?>)" onclick="return false;">
		<?php echo $question ?>
		</a>
		<?php echo (isset($status) ? $status : ''); ?>
	</div>
</div>

<div class="row ng-hide"
	 ng-show="answerIndex.<?php echo $answerIndex; ?>">

	<br />

	<div class="text-left col-xs-12 col-md-offset-1 col-md-1 h4">
		<span class="label label-primary">A</span>
	</div>
	<div class="col-xs-12 col-md-10">
		<?php echo $answer ?>
	</div>

	<br />
	<?php echo $this->element('Faqs/content_edit_btn_faq', array(
								'published' => $published,
								'size' => 12,
								'modal' => false,
								'question' => $question,
								'answer' => $answer)); ?>
</div>

<hr>
