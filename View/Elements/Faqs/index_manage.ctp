<!--
<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-<?php echo (int)$frameId; ?>">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-<?php echo (int)$frameId; ?>">
-->

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li class="small active">
				<a href="#nc-faqs-change-order-move-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					FAQ編集
				</a>
			</li>
			<li class="small">
				<a href="#nc-faqs-category-editor-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					カテゴリー編集
				</a>
			</li>
			<li class="small">
				<a href="#nc-faqs-display-style-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					表示方法変更
				</a>
			</li>
			<li class="small">
				<a href="#nc-faqs-role-setting-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					権限設定
				</a>
			</li>
			<li class="small disabled">
				<a href="#" onclick="return false;">
					メール設定
				</a>
			</li>
		</ul>
<!--
	</div>
</nav>
-->

<br />

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="nc-faqs-change-order-move-<?php echo (int)$frameId; ?>">
		<div id="nc-faqs-change-order-view-<?php echo (int)$frameId; ?>"
			 ng-hide="visibleAddLinkForm2">
			<?php echo $this->element('Faqs/change_order'); ?>
		</div>
		<div id="nc-faqs-add-faq-<?php echo (int)$frameId; ?>" class="ng-hide"
			 ng-show="visibleAddLinkForm2">

			<?php echo $this->element('Faqs/index_add_link', array('ngClick' => 'closeEditFaq()')); ?>
		</div>

	</div>
	<div class="tab-pane" id="nc-faqs-category-editor-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Faqs/category_editor'); ?>
	</div>
	<div class="tab-pane" id="nc-faqs-display-style-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Faqs/display_style_setting'); ?>
	</div>
	<div class="tab-pane" id="nc-faqs-role-setting-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Faqs/authority_setting'); ?>
	</div>
	<div class="tab-pane disabled" id="nc-faqs-mail-setting-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Faqs/notification_setting'); ?>
	</div>
</div>

