<?php
if (is_singular('casino')) {
	global $post;
	$id = $post->ID;
	$dateCreated = get_the_date('Y-m-d h:m:s', $id);
	$dateModified = get_the_modified_date('Y-m-d h:m:s', $id);
	$name = get_the_title($id);
	$link = get_the_permalink($id);
	$rating = get_field('google_rating', $id);
	$author_id = $post->post_author;
	$author_user_firstname = get_the_author_meta('user_firstname', $author_id);
	$author_user_lastname = get_the_author_meta('user_lastname', $author_id);
	$author_user_url = get_author_posts_url($author_id);

	$thumbnail = get_the_post_thumbnail_url($id, '300x133');
	$logo = get_field('logo_image', 'option')['url'];
	$url_without_protocol = substr(site_url(), strpos(site_url(), "//") + 2);
	?>
	<script type="application/ld+json">
		{
			"@context" : "https://schema.org",
			"@type" : "Review",
			"name" : "<?php echo $name .' Review' ?>",
			"itemReviewed" : {
				"@type" : "Organization",
				"name" : "<?php echo $name  ?>",
				"image" : "<?php echo $thumbnail ?>"
			},
			"reviewRating" : {
				"@type" : "Rating",
				"ratingValue" : "<?php echo round($rating, 2); ?>",
				"bestRating" : "5.0",
				"worstRating" : "0.0"
			},
			"author" : {
				"@type" : "Person",
				"@id" : "<?php echo $url_without_protocol ?>/#person-<?php echo $author_id ?>",
				"name" : "<?php echo $author_user_firstname . ' ' . $author_user_lastname ?>",
				"url" : "<?php echo $author_user_url ?>"
			},
			"publisher" : {
				"@type" : "Organization",
				"@id" : "<?php echo site_url(); ?>#Organization"
			},
			"dateCreated" : "<?php echo $dateCreated ?>",
			"dateModified" : "<?php echo $dateModified ?>"
		}
	</script>
<?php }