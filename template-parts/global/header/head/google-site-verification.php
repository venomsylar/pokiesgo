<?php
/**
 * Google site verification
 */
$google_site_verification = get_field('google_site_verification', 'option');
if ($google_site_verification) {
    echo '<meta name="google-site-verification" content="'.$google_site_verification.'">';
}
