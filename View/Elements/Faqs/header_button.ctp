
<div class="col-xs-4">
	<button class="btn btn-success"
			ng-click="showAddFaq()"
			ng-show="visibleAddFaq"
			tooltip="リンクを追加する">
		<span class="glyphicon glyphicon-plus"></span>
		<span class="hidden">
			FAQ追加
		</span>
	</button>
</div>

<div class="text-right col-xs-7 col-xs-offset-1">

	<?php if (Page::isSetting()) : ?>
		<button class="btn btn-primary"
				ng-click="showManage()"
				ng-hide="visibleManage"
			tooltip="管理">
			<span class="glyphicon glyphicon-cog">
			</span>
			<span class="hidden">
				管理
			</span>
		</button>

		<button class="btn btn-primary ng-hide"
				ng-click="showContainer()"
				ng-show="visibleManage"
			tooltip="管理を終了する">
			<span class="glyphicon glyphicon-cog">
			</span>
			<span class="">
				終了
			</span>
		</button>
	<?php endif; ?>
</div>
