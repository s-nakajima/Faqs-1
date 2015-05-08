<?php
/**
 * FaqQuestions index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<?php echo $this->Html->script('/faqs/js/faqs.js', false); ?>

<div class="nc-content-list" ng-controller="FaqIndex">
	<article>
		<h1>
			<?php echo h($faq['name']); ?>
		</h1>

		<div class="clearfix">
			<div class="pull-left">
				<?php if ($contentCreatable) : ?>
					<?php echo $this->element('FaqQuestions/select_status'); ?>
				<?php endif; ?>
				<?php echo $this->element('FaqQuestions/select_category'); ?>
			</div>
			<div class="pull-right">
				<?php if ($contentEditable) : ?>
					<span class="nc-tooltip " tooltip="<?php echo __d('faqs', 'Sort question'); ?>">
						<a href="<?php echo $this->Html->url('/faqs/faq_question_orders/edit/' . $frameId); ?>" class="btn btn-default">
							<span class="glyphicon glyphicon-sort"> </span>
						</a>
					</span>
				<?php endif; ?>
				<?php if ($contentCreatable) : ?>
					<span class="nc-tooltip " tooltip="<?php echo __d('faqs', 'Create question'); ?>">
						<a href="<?php echo $this->Html->url('/faqs/faq_questions/add/' . $frameId); ?>" class="btn btn-success">
							<span class="glyphicon glyphicon-plus"> </span>
						</a>
					</span>
				<?php endif; ?>
			</div>
		</div>


		<hr>
		<?php foreach($faqQuestions as $faqQuestion): ?>
			<?php echo $this->element('FaqQuestions/article', array(
					'faqQuestion' => $faqQuestion,
				)); ?>

			<hr>
		<?php endforeach; ?>
	</article>
</div>
