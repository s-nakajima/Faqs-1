
<div class="row">
	<div class="col-xs-6">
		<ul class="pagination pagination-sm">
		  <li class="disabled"><a href="#">&laquo;</a></li>
		  <li class="active"><a href="#">1</a></li>
		  <li><a href="#">2</a></li>
		  <li><a href="#">3</a></li>
		  <li><a href="#">4</a></li>
		  <li><a href="#">5</a></li>
		  <li><a href="#">&raquo;</a></li>
		</ul>
	</div>

	<div class="text-right col-xs-6">
		<form class="form-inline pagination" role="form">
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
</div>