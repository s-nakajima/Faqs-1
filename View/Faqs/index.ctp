<?php
	//echo $this->Html->script('/net_commons/bower-angular-sanitize/angular-sanitize.min.js');
	//echo $this->Html->script('/net_commons/angular-dialog-service/src/dialogs.js');
?>
<?php echo $this->Html->script('/faqs/js/faqs.js'); ?>

<div id="nc-faqs-container-<?php echo (int)$frameId; ?>"
	 ng-controller="Faqs"
	 ng-init="initialize(<?php echo (int)$frameId; ?>)">

	<div id="nc-faqs-add-link-modal-<?php echo (int)$frameId; ?>" class="modal fade">
		<div class="ng-scope">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button data-dismiss="modal" class="close" type="button">
							<span aria-hidden="true">×</span>
							<span class="sr-only">Close</span>
						</button>
						<h4 id="myModalLabel" class="modal-title">
							{{modalTitle}}
						</h4>
					</div>
					<div class="modal-body">
						<?php echo $this->element('Faqs/index_add_link'); ?>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div id="nc-faqs-manage-modal-<?php echo (int)$frameId; ?>" class="modal fade">
		<div class="ng-scope">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button data-dismiss="modal" class="close" type="button">
							<span aria-hidden="true">×</span>
							<span class="sr-only">Close</span>
						</button>
						<h4 id="myModalLabel" class="modal-title">
							編集
						</h4>
					</div>
					<div class="modal-body">
						<?php echo $this->element('Faqs/index_manage'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row"
		 ng-show="visibleHeaderBtn">
		<?php echo $this->element('Faqs/header_button'); ?>
	</div>

		<br />

	<div id="nc-faqs-container-<?php echo (int)$frameId; ?>"
		 ng-show="visibleContainer">

		<div>
			<?php echo $this->element('Faqs/list'); ?>
		</div>
	</div>


	<div id="nc-faqs-add-link-<?php echo (int)$frameId; ?>" class="ng-hide"
		 ng-show="visibleAddFaqForm">
		<?php echo $this->element('Faqs/index_add_link'); ?>
	</div>

	<div id="nc-faqs-edit-<?php echo (int)$frameId; ?>" class="ng-hide"
		 ng-show="visibleEdit">

		<?php echo $this->element('Faqs/index_edit'); ?>

	</div>


	<div id="nc-faqs-manage-<?php echo (int)$frameId; ?>" class="ng-hide"
		 ng-show="visibleManage">

		<?php echo $this->element('Faqs/index_manage'); ?>

	</div>
</div>
