
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
		<!-- Nav tabs -->
		<ul class="nav navbar-nav" role="tablist">
			<li class="small active">
				<a href="#nc-faqs-change-order-move-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					表示順変更
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
			<li class="small">
				<a href="#nc-faqs-mail-setting-<?php echo (int)$frameId; ?>"
						role="tab" data-toggle="tab">
					メール設定
				</a>
			</li>
		</ul>
	</div>
</nav>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="nc-faqs-change-order-move-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Faqs/change_order'); ?>
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
	<div class="tab-pane" id="nc-faqs-mail-setting-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('Faqs/notification_setting'); ?>
	</div>
</div>

