<div class="row">
	<div class="text-left col-xs-12 col-md-1 h4">
		<span class="label label-warning">Q</span>
	</div>
	<div class="col-xs-12 col-md-11">
		<a href="#" ng-click="changeAnswer(<?php echo $answerIndex; ?>)" onclick="return false;">
		<?php echo $question ?>
		</a>
		<?php echo (isset($status) ? $status : ''); ?>
	</div>
</div>

<div class="row ng-hide"
	 ng-show="answerIndex.<?php echo $answerIndex; ?>">

	<br />

	<div class="text-left col-xs-12 col-md-1 h4">
		<span class="label label-primary">A</span>
	</div>
	<div class="col-xs-12 col-md-11">
		<?php echo $answer ?>
	</div>

	<br />
	<?php echo $this->element('Faqs/content_edit_btn_faq', array(
								'published' => $published,
								'size' => 12,
								'modal' => true,
								'question' => $question,
								'answer' => $answer)); ?>
</div>

<hr>
