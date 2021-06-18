<?php
if (is_author()) {
	$author_id = get_queried_object_id();
	$author_user_firstname = get_the_author_meta('user_firstname', $author_id);
	$author_user_lastname = get_the_author_meta('user_lastname', $author_id);
	$author_user_url = get_author_posts_url($author_id);
	$author_user_email = get_the_author_meta('user_email', $author_id);
	$publisher = get_option('blogname');
	$url_without_protocol = substr(site_url(), strpos(site_url(), "//") + 2);
	$image = get_avatar_url($author_id) ?: get_field('default_image', 'option')['url'];
	?>
	<script type="application/ld+json">
		{
			"@context" : "https://schema.org",
			"@type" : "Person",
			"@id" : "<?php echo $url_without_protocol ?>/#person-<?php echo $author_id ?>",
			"name" : "<?php echo $author_user_firstname . ' ' . $author_user_lastname ?>",
			"email" : "<?php echo $author_user_email ?>",
			"url" : "<?php echo $author_user_url ?>",
			"image" : "<?php echo $image ?>",
			"jobTitle" : "Author",
			"worksFor" : "<?php echo $publisher ?>"
		}
	</script>
<?php }