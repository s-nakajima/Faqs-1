<?php
/**
 * FaqFrameSettings form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$this->NetCommonsForm->create(null);

$this->NetCommonsForm->input('BlockRolePermission.id', array(
			'type' => 'number',
		)
	);

$this->NetCommonsForm->input('BlockRolePermission.value', array(
			'type' => 'checkbox',
		)
	);

echo $this->NetCommonsForm->endJson();
