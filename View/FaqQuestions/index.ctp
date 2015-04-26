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
		<div class="row">
			<div class="col-xs-10">
				<h1>
					<small><?php echo h($faq['name']); ?></small>
				</h1>
			</div>
			<div class="col-xs-2 text-right">
				<h2>
					<?php if ($contentCreatable) : ?>
						<span class="nc-tooltip " tooltip="<?php echo __d('faqs', 'Create question'); ?>">
							<a href="<?php echo $this->Html->url('/faqs/faq_questions/add/' . $frameId); ?>" class="btn btn-success">
								<span class="glyphicon glyphicon-plus"> </span>
							</a>
						</span>
					<?php endif; ?>
				</h2>
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
