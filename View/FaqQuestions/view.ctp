<?php
/**
 * FaqQuestions view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="nc-content-list" ng-controller="FaqIndex">
	<article>
		<h1>
			<small><?php echo h($faq['name']); ?></small>
		</h1>

		<hr>
		<?php echo $this->element('FaqQuestions/article', array(
				'faqQuestion' => ['faqQuestion' => $faqQuestion],
			)); ?>

		<hr>
	</article>
</div>
