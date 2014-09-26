<div class="panel panel-default">
 	<div class="panel-heading">
		カテゴリー追加権限設定
	</div>
  	<div class="panel-body">
		<div class='form-group'>
			<div class='form-group bold'>
				<span class="glyphicon glyphicon-ok"></span>
				ルーム管理者
			</div>

			<div class='form-group'>
				<?php
					echo $this->Form->input('category_author[2]', array(
						'type' => 'checkbox',
						'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
						'value' => 2,
						'label' => '編集長',
						'checked' => true,
						'autocomplete' => 'off',
					));
				?>
			</div>

			<div class='form-group'>
				<?php
					echo $this->Form->input('category_author[3]', array(
						'type' => 'checkbox',
						'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
						'value' => 3,
						'label' => '編集者',
						'checked' => true,
						'autocomplete' => 'off',
					));
				?>
			</div>

			<div class='form-group'>
				<?php
					echo $this->Form->input('category_author[4]', array(
						'type' => 'checkbox',
						'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
						'value' => 4,
						'label' => '一般',
						'checked' => false,
						'autocomplete' => 'off',
					));
				?>
			</div>

		</div>
	</div>
</div>

<div class="panel panel-default">
 	<div class="panel-heading">
		FAQ追加権限設定
	</div>
  	<div class="panel-body">
		<div class='form-group'>
			<div class='form-group'>
				<span class="glyphicon glyphicon-ok"></span>
				ルーム管理者
			</div>

			<div class='form-group'>
				<?php
					echo $this->Form->input('category_author[2]', array(
						'type' => 'checkbox',
						'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
						'value' => 2,
						'label' => '編集長',
						'checked' => true,
						'autocomplete' => 'off',
					));
				?>
			</div>

			<div class='form-group'>
				<?php
					echo $this->Form->input('category_author[3]', array(
						'type' => 'checkbox',
						'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
						'value' => 3,
						'label' => '編集者',
						'checked' => true,
						'autocomplete' => 'off',
					));
				?>
			</div>

			<div class='form-group'>
				<?php
					echo $this->Form->input('category_author[4]', array(
						'type' => 'checkbox',
						'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
						'value' => 4,
						'label' => '一般',
						'checked' => false,
						'autocomplete' => 'off',
					));
				?>
			</div>

		</div>
	</div>
</div>

<!--
<p class="text-center">
	<button type="button" class="btn btn-default">
		キャンセル
	</button>
	<button type="button" class="btn btn-primary">
		設定する
	</button>
</p>
-->

<p class="text-center">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		キャンセル
	</button>
	<button type="button" class="btn btn-primary" data-dismiss="modal">
		設定する
	</button>
</p>
