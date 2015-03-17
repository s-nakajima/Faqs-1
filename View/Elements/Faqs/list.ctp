<?php
/**
 * faq list element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<accordion close-others="true">
	<?php foreach($faqList as $index => $faq): ?>
	<div class="row" style="margin:4px;">
		<div class="col-md-12 col-xs-12">
			<accordion-group>

				<accordion-heading>
					<div>
						<span class="glyphicon glyphicon-question-sign"></span>
						<a ng-href="/faqs/faqs/view/{{frameId}}/<?php echo $faq['faq']['id'];?>" onClick="return false;">
							<?php echo $faq['faq']['question'];?>
						</a>

						<?php echo $this->element('Faqs/content_status'); ?>
					</div>
				</accordion-heading>

				<?php echo $faq['faq']['answer'];?>
				<div ng-if="'<?php echo $contentEditable; ?>' ||
							'<?php echo CakeSession::read('Auth.User.id'); ?>' == faq.faq.createdUser">
					<div class="text-right">
						<a class="btn btn-xs btn-primary"
						   href="<?php echo $this->Html->url('/faqs/faqs/edit/' . $frameId . '/' . $faq['faq']['id']); ?>">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</div>
				</div>

			</accordion-group>
		</div>
	</div>
	<?php endforeach; ?>
</accordion>
