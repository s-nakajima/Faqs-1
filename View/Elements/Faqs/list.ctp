<?php
/**
 * Faqs list element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<accordion close-others="true">
	<div class="row" style="margin:4px;"
		 ng-repeat="faq in faqList track by $index" ng-cloak>

		<div class="col-md-12 col-xs-12">
			<accordion-group id="/{{frameId}}/{{faq.faq.id}}">

				<accordion-heading>
					<div>
						<span class="glyphicon glyphicon-question-sign"></span>
						<a ng-href="/faqs/faqs/view/{{frameId}}/{{faq.faq.id}}" onClick="return false;"
							ng-bind="faq.faq.question">
						</a>

						<?php echo $this->element('Faqs/content_status'); ?>
					</div>
				</accordion-heading>

				<span ng-bind-html="faq.faq.answer"></span>

				<div ng-if="'<?php echo $contentEditable; ?>' ||
							'<?php echo CakeSession::read('Auth.User.id'); ?>' == faq.faq.createdUser">
					<div class="text-right">
						<a class="btn btn-xs btn-primary"
						   href="<?php echo $this->Html->url('/faqs/faqs/edit/' . $frameId . '/' . '{{faq.faq.id}}') ?>">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</div>
				</div>
			</accordion-group>
		</div>
	</div>
</accordion>



<!--
<a href="##123">test</a>
<div id="123">test</div>

	<div ng-repeat="faq in faqList track by $index">
		<div>
			<a ng-href="/faqs/faqs/view/{{frameId}}/{{faq.Faq.id}}"
				onClick="return false;"
				ng-click="link(frameId, faq.Faq.id)"
				ng-bind="faq.Faq.question"
				></a>
		</div>
		<div ng-show="faq.Faq.id == $state.params.faqId">
			<span ng-bind=faq.Faq.answer></span>
		</div>
		<hr/>
	</div>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default"
							 ng-repeat="faq in faqList track by $index" ng-cloak
							 id="heading{{$index}}">
							<div class="panel-heading" role="tab">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion"
										aria-expanded="true" aria-controls="collapseOne"
										ng-href="##heading{{$index}}"
										ng-bind="faq.Faq.question">
									</a>
								</h4>
								<?php echo $this->element('Faqs/content_status'); ?>
							</div>
							<div id="collapse{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$index}}">
								<div class="panel-body">
									<div class="panel-heading" ng-if="'<?php echo $contentEditable; ?>' ||
												'<?php echo CakeSession::read('Auth.User.id'); ?>' == faq.Faq.created_user">
										<?php echo $this->element('Faqs/list_edit_btn'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>


					<div ng-repeat="faq in faqList track by $index" ng-cloak>

							<div class="row"id="/{{frameId}}/{{faqId}}">
								<?php if ($manageMode) : ?>

									<div class="text-left col-xs-12 col-md-1">
										<button class="btn btn-default btn-xs"
												ng-click="changeFaqOrder('up', $index)"
												ng-disabled="$first">

											<span class="glyphicon glyphicon-arrow-up"></span>
										</button>
										<button class="btn btn-default btn-xs"
												ng-click="changeFaqOrder('down', $index)"
												ng-disabled="$last">

											<span class="glyphicon glyphicon-arrow-down"></span>
										</button>
									</div>

								<?php endif ?>

								<div class="text-left col-xs-12 col-md-1">
									<span class="label label-warning">
										Q
									</span>
								</div>

								<div class="col-xs-12
									 <?php echo ($manageMode ? 'col-md-10' : 'col-md-11'); ?>">

									<a ui-sref="detail({frameId: 17, faqId: faq.Faq.id})">
										{{faq.Faq.question}}
									</a>

									<?php echo $this->element('Faqs/content_status'); ?>

								</div>
							</div>

							<div class="row" ng-show="faq.Faq.id == $state.params.faqId">

								<div class="text-left col-xs-12 col-md-1
									 <?php echo ($manageMode ? 'col-md-offset-1' : ''); ?>">

									<span class="label label-primary">
										A
									</span>
								</div>

								<div class="col-xs-12
									 <?php echo ($manageMode ? 'col-md-10' : 'col-md-11'); ?>">
									{{faq.Faq.answer}}

								</div>

								<br />
								<div ng-if="'<?php echo $contentEditable; ?>' ||
											'<?php echo CakeSession::read('Auth.User.id'); ?>' == faq.Faq.created_user">

									<?php echo $this->element('Faqs/list_edit_btn'); ?>
								</div>
							</div>

						<hr>
					</div>
-->