<?php
$author = get_option('blogname');
$logo = get_field('logo_image', 'option')['url'];
?>
<script type="application/ld+json">
		[
			{
				"@context": "https://schema.org",
				"@type": "Organization",
				"@id": "<?php echo site_url(); ?>#Organization",
				"name": "<?php echo $author ?>",
				"url": "<?php echo site_url(); ?>",
				"sameAs": [],
				"logo": {
					"@type": "ImageObject",
					"url": "<?php echo $logo ?>",
					"width": "137",
					"height": "38"
				}
			}
		]
</script>