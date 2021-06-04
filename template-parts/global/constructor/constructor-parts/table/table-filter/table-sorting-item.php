<?php
function table_sorting_item($args) {
	ob_start();
	$title = $args['title'];
	$data = $args['data'];
	?>
	<div class="table_sorting_item" datatype="sorting">
		<strong class="table_sorting_item_title"><?php echo $title ?></strong>
		<div class="table_sorting_item_list">
			<ul>
				<?php
				foreach ($data as $item) { ?>
					<li data-slug="<?php echo $item['slug'] ?>"><?php echo $item['title'] ?></li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<?php return ob_get_clean();
}