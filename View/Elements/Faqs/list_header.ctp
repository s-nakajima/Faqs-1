
<div class="text-right">
	<form class="form-inline" role="form">
		<div class='form-group'>
			<?php
				echo $this->Form->input('category', array(
							'label' => false,
							'type' => 'select',
							'options' => array(1 => 'カテゴリー1', '2' => 'カテゴリー2', '3' => 'カテゴリー3'),
							'selected' => 1,
							'class' => 'form-control',
							//'style' => 'margin-left: 50px;',
						)
					);
			?>
		</div>

		<div class='form-group'>
			<?php
				echo $this->Form->input('category', array(
							'label' => false,
							'type' => 'select',
							'options' => array(1 => '1件', '5' => '5件', '10' => '10件', '20' => '20件', '50' => '50件', '100' => '100件'),
							'selected' => 10,
							'class' => 'form-control',
							//'style' => 'margin-left: 50px;',
						)
					);
			?>
		</div>
	</form>
</div>