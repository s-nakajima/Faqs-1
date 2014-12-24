<?php
/**
 * Faqs list footer element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="text-center">
	<pagination
		class="pagination pagination-sm"
		style="cursor: pointer"
		total-items="faqListTotal"
		items-per-page="displayNumber"
		max-size="5"
		page="currentPage"
		previous-text="<"
		next-text=">"
		ng-controller="Faqs.Edit"
		on-select-page="changeFaqList(page)"
		>
	</pagination>
</div>
