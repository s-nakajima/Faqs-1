
<!-- TODO:フレーム設定↓ -->
<ul class="nav nav-pills">
	<li role="presentation" class="<?php echo ($tab === 'general') ? 'active' : ''; ?>">
		<a href="<?php echo $this->Html->url('/' . $frame['pluginKey'] . '/blocks/edit/' . $frame['id'] . '/' . $blockId);?>">
			コンテンツ
		</a>
	</li>
	<li role="presentation" class="<?php echo ($tab === 'auth') ? 'active' : ''; ?>">
		<!-- TODO:ブロック一覧画面ができてから修正 -->
		<a href="<?php echo $this->Html->url('/' . $frame['pluginKey'] . '/blocks/editAuth/' . $frame['id'] . '/' . $blockId);?>">
			権限設定
		</a>
	</li>
</ul>
<br>
