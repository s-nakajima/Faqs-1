<?php
/**
 * Faqs view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if (! isset($faq)) : ?>
	指定されたFAQは公開されていません。
<?php else : ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="glyphicon glyphicon-question-sign"></span>
				<?php echo $faq['Faq']['question'] ?>
			</div>
			<div class="panel-body">
				<p><?php echo $faq['Faq']['answer'] ?></p>
			</div>
		</div>
<?php endif;
