<?php
/**
 * Element of question and answer
 *
 * #### second argument of $this->element()
 * - $faqQuestion: A result data of FaqQestion->getFaqQuestions()
 *     - faqQuestion:
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$viewUrl = $this->Html->url(array(
		'controller' => 'faq_questions',
		'action' => 'view',
		$frameId,
		$faqQuestion['faqQuestion']['key']
	));

$editUrl = $this->Html->url(array(
		'controller' => 'faq_questions',
		'action' => 'edit',
		$frameId,
		$faqQuestion['faqQuestion']['key']
	));

$answerKey = 'faq-answer-' . $frameId . '-' . $faqQuestion['faqQuestion']['id'];

$hidden = $this->params['action'] === 'index' ? 'hidden' : '';
?>

<article>
	<h2>
		<?php if ($this->params['action'] === 'index') : ?>
			<a href="<?php echo $viewUrl; ?>" onclick="return false;"
				ng-click="displayAnswer('#<?php echo $answerKey; ?>')">

				<span class="glyphicon glyphicon-question-sign"> </span>
				<?php echo h($faqQuestion['faqQuestion']['question']); ?>
			</a>

		<?php else : ?>
			<small>
				<span class="glyphicon glyphicon-question-sign"> </span>
				<strong>
					<?php echo h($faqQuestion['faqQuestion']['question']); ?>
				</strong>
			</small>

		<?php endif; ?>

		<small>
			<?php echo $this->element('NetCommons.status_label',
					array('status' => $faqQuestion['faqQuestion']['status'])); ?>
		</small>
	</h2>

	<div id="<?php echo $answerKey; ?>"
		class="<?php echo $hidden; ?>">

		<div>
			<?php echo $faqQuestion['faqQuestion']['answer']; ?>
		</div>

		<div class="text-right">
			<a href="<?php echo $editUrl; ?>" class="btn btn-primary btn-xs"
			   tooltip="<?php echo __d('net_commons', 'Edit'); ?>">

				<span class="glyphicon glyphicon-edit"> </span>
			</a>
		</div>
	</div>
</article>
