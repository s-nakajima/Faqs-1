
<!-- TODO:フレーム設定↓ -->

<ul class="nav nav-tabs">
	<li role="presentation" class="<?php echo ($tab === 'block') ? 'active' : ''; ?>">
		<a href="<?php echo $this->Html->url('/' . $frame['pluginKey'] . '/blocks/index/' . $frame['id']);?>">
			一覧表示
		</a>
	</li>
	<li role="presentation" class="">
		<a href="">
			表示方法変更
		</a>
	</li>
</ul>
<br>
