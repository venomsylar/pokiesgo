<?php
$object = get_queried_object();
$id = $object->ID ?: $object->taxonomy . '_' .$object->term_id;
$hreflangs = get_field('links_hreflang', $id);
$current_hreflang = get_field('current_language_hreflang', 'option');
?>
<link rel="alternate" hreflang="<?php echo $current_hreflang ?>" href="<?php echo venom_get_current_url() ?>">
<?php if ($hreflangs && count($hreflangs)) {
	foreach ($hreflangs as $hreflang) {
		$hreflang_code = $hreflang['domain'];
		$domain = get_domain_by_hreflang_code($hreflang_code); ?>
		<link rel="alternate" hreflang="<?php echo $hreflang_code ?>" href="<?php echo $domain . $hreflang['slug'] ?>">
	<?php }
}