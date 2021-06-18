<?php
$id = get_queried_object_id();
$rating_value = get_post_meta($id, 'g_rating_value', true) ? get_post_meta($id, 'g_rating_value', true) : 1;
if (get_field('rating_on', $id)) {?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Review",
            "itemReviewed": {
                "@type": "Thing",
                "name": "<?php echo get_the_title() ?>"
            },
            "author": {
                "@type": "Organization",
                "name": "<?php bloginfo('name'); ?>",
                "url": "<?php echo site_url(); ?>"
            },
            "reviewRating": {
                "@type": "Rating",
                "ratingValue": "<?php echo round($rating_value, 2); ?>",
                "bestRating": "5",
                "worstRating": "1"
            }
        }
    </script>
<?php } ?>