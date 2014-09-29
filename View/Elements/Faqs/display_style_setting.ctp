<div class="panel panel-default">
  	<div class="panel-body">
		<div class='form-group'>
			<?php
				//表示方法変更
				echo $this->Form->label('display_type', __('表示方法変更'));

				echo $this->Form->input('display_type', array(
							//'label' => false,
							//'label' => true,
							'legend' => false,
							'type' => 'radio',
							'options' => array(
								0 => '全てのカテゴリーを表示する',
								1 => '表示するカテゴリーを絞り込む',
							),
							//'before' => '<br />'
							'separator' => '<br />',
							//'after' => '<div style="margin-bottom: 30px;"> </div>',
							'selected' => 0,
							'div' => array('class' => 'input radio', 'style' => 'margin-left: 30px;'),
							//'class' => 'form-control',
						)
					);
			?>
			<?php
				echo $this->Form->input('category', array(
							'label' => false,
							'type' => 'select',
							'options' => array(1 => 'カテゴリー1', '2' => 'カテゴリー2', '3' => 'カテゴリー3'),
							'selected' => 1,
							//'class' => 'form-control',
							'style' => 'margin-left: 50px;',
						)
					);
			?>

			<div style="margin-bottom: 30px;"> </div>
		</div>

		<div class='form-group'>
			<?php
				//表示件数
				echo $this->Form->label('display_count', __('表示件数'));

				echo $this->Form->input('display_count', array(
							'label' => false,
							'type' => 'select',
							'options' => array(1 => '1件', '5' => '5件', '10' => '10件', '20' => '20件', '50' => '50件', '100' => '100件'),
							'selected' => 10,
							'class' => 'form-control',
						)
					);
			?>
		</div>
	</div>
</div>

<p class="text-center">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		キャンセル
	</button>
	<button type="button" class="btn btn-primary" data-dismiss="modal">
		設定する
	</button>
</p>
