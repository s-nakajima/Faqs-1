<?php if ($size) : ?>
<div class="text-right col-xs-<?php echo $size; ?>">
<?php endif; ?>

	<?php if ($published) : ?>
		<button class="btn btn-danger btn-xs">
			公開する
		</button>
	<?php endif; ?>
	<button class="btn btn-primary btn-xs"
			ng-click="showEditFaq('<?php echo $modal; ?>', '<?php echo $question; ?>', '<?php echo $answer; ?>')">
		編集
	</button>

	<button class="btn btn-default btn-xs"
			ng-click="deleteEditFaq()">
		削除
	</button>

<?php if ($size) : ?>
</div>
<?php endif; ?>