
<!-- TODO:フレーム設定↓ -->

<ul class="nav nav-pills">
	<li role="presentation" class="<?php echo ($tab === 'general') ? 'active' : ''; ?>">
		<a href="<?php echo $this->Html->url('/' . $frame['plugin_key'] . '/blocks/edit/' . $frame['id']);?>">
			コンテンツ
		</a>
	</li>
	<li role="presentation" class="<?php echo ($tab === 'auth') ? 'active' : ''; ?>">
		<!-- TODO:ブロック一覧画面ができてから修正 -->
		<a href="<?php echo $this->Html->url('/' . $frame['plugin_key'] . '/blocks/editAuth/' . $frame['id'] . '/3');?>">
			権限設定
		</a>
	</li>
</ul>
<br>
