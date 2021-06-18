<?php
if (is_tax()) {
	$obj = get_queried_object();
	$id = $obj->term_id;
	$dateCreated = get_the_date('Y-m-d h:m:s', $id);
	$dateModified = get_the_modified_date('Y-m-d h:m:s', $id);
	$name = $obj->name;
	$link = get_term_link($obj);
	$publisher = get_option('blogname');
	$logo = get_field('logo_image', 'option')['url'];
	?>
	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "Article",
			"author": "<?php echo $publisher ?>",
			"dateCreated": "<?php echo $dateCreated ?>",
			"dateModified": "<?php echo $dateModified ?>",
			"datePublished": "<?php echo $dateCreated ?>",
			"headline": "<?php echo $name ?>",
			"image": "<?php echo $logo ?>",
			"url": "<?php echo $link ?>",
			"mainEntityOfPage": {
				"@type": "WebPage",
				"url": "<?php echo $link ?>"
			},
			"publisher": {
				"@type": "Organization",
				"logo": {
					"@type": "ImageObject",
					"url": "<?php echo $logo ?>"
				},
				"name": "<?php echo $publisher ?>"
			}
		}
	</script>
<?php }