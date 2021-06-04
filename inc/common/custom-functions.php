<?php
/**
 * @param string $filepath
 *
 * @return string
 */
function venom_get_theme_url($filepath = null)
{
    return preg_replace('(https?://)', '//', get_stylesheet_directory_uri() . ($filepath ? '/' . $filepath : ''));
}

/**
 * @param $id
 * @param string $size
 * @param bool $background_image
 * @param bool $height
 *
 * @return string
 */
function venom_get_attachment_css_bg_attr($id, $size = 'full', $background_image = false, $height = false)
{
    if ($image = wp_get_attachment_image_src($id, $size, true)) {
        return $background_image ? 'background-image: url('.$image[0].');' . ($height?'min-height:'.$image[2].'px':'') : $image[0];
    } else return '';
}

/**
 * @return string
 */
function venom_get_meta_robots()
{
    $noindex_tag = false;
	$id = get_queried_object_id();
    if (class_exists(acf::class)) {
        if (!is_tax() && get_field('index_button', $id) || is_preview() || is_404()|| is_attachment() || get_post_status() == 'draft') {
            $noindex_tag = '<meta name="robots" content="noindex,nofollow" />';
        }
    }

    return $noindex_tag;
}

/**
 * @return string
 */
function venom_get_header_logo($footer = false)
{
    $logo_image = get_field('logo_image', 'option');

    if ($logo_image) {
        $alt = $logo_image['alt'] ? $logo_image['alt'] : get_bloginfo('name');
        $logo = '<img src="'.$logo_image['url'].'" alt="'.$alt.'">';

        if (is_front_page() || $footer) {
            $content = '<span class="logo">';
            $content.= $logo;
            $content.= '</span>';
        } else {
            $content = '<a class="logo" href="' . get_option("home") . '/">';
            $content.= $logo;
            $content.= '</a>';
        }

        return $content;
    } else {
        return false;
    }
}

/**
 * @return string
 */
function venom_get_social_media_icons_mock()
{
    $some = get_field('some', 'option');
    $soc = '';

    if ($some) {
        $soc .= '<div class="social_media">';
        foreach ($some as $sm) {
            $soc .= '<a class="i-'.$sm['icon'].'" target="_blank" rel="nofollow noopener" href="'.$sm['link'].'"></a>';
        }
        $soc .= '</div>';
    }

    return $soc;
}

/**
 * @param $id
 *
 * @return mixed
 */
function venom_attachment_alt_attr($id)
{
    $c_alt = get_post_meta($id, '_wp_attachment_image_alt', true);
    $c_tit = get_the_title($id);

    return $c_alt?$c_alt:$c_tit;
}

/**
 * Get Current Url
 *
 * @return string
 */
function venom_get_current_url()
{
    $pageURL = 'http';

    if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }

    $pageURL .= "://";
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

    return str_replace('www.', '', $pageURL);
}

/**
 * Custom Canonical
 *
 * @return string
 */
function venom_get_custom_canonical()
{
    global $paged;

    $str = venom_get_current_url();

    if ($paged > 1 && is_home()) {
        $str = get_permalink(get_option('page_for_posts'));
	    return $str;
    }

    if ($paged > 1) {
	    $str = substr($str, 0, strpos($str, '/page/'));
	    return $str. '/';
    }

    if (strpos($str, '?')) {
        $str = substr($str, 0, strpos($str, '?'));
	    return $str;
    }
	return $str;
}

/**
 * Hide Editor on specific pages
 */
function venom_hook_hide_editor_for_test_page()
{
    // Get the Post ID.
    if (isset($_GET['post'])) {
        $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
    }

    if (!isset($post_id)) {
        return;
    }

    // Hide the editor on the page title
    if (get_the_title($post_id) == 'Home' || get_the_title($post_id) == 'Test Page') {
        remove_post_type_support('page', 'editor');
    }
    // Hide the editor on a page with a specific page template
    // Get the name of the Page Template file.
    $template_file = get_post_meta($post_id, '_wp_page_template', true);
    if ($template_file == 'tpl-blank.php') { // the filename of the page template
        remove_post_type_support('page', 'editor');
    }
}
add_action('admin_init', 'venom_hook_hide_editor_for_test_page');

/**
 * @param $array
 * @return float|int
 */
function get_rating_value($array) {
    $key_value_sum = 0;
    $values_sum = 0;
    foreach($array as $key => $item) {
        $key_value_sum += ($key*$item);
        $values_sum += $item;
    }
    $avg = $key_value_sum / $values_sum;
    return $avg;
}

/**
 * Rating ajax
 */
function pt_ajax_increment_rating()
{
    $id = $_POST['id'];
    $current_rating = $_POST['currentRaiting'];
    $rating_count = get_post_meta($id, 'g_rating_count', true);
    $rating_data = get_post_meta($id, 'g_rating_data', true);
    if($rating_data) {
        if(array_key_exists($current_rating, $rating_data)) {
            $rating_data[$current_rating] = $rating_data[$current_rating] + 1;
        } else {
            $rating_data[$current_rating] = 1;
        }
        update_post_meta( $id, 'g_rating_data', $rating_data );
        if($rating_count) {
            $rating_count++ ;
            update_post_meta( $id, 'g_rating_count', $rating_count );
        } else {
            update_post_meta( $id, 'g_rating_count', 1 );
        }
    } else {
        $meta_value[$current_rating] = 1;
        add_post_meta( $id, 'g_rating_data', $meta_value );
        add_post_meta( $id, 'g_rating_count', 1 );
    }
    update_post_meta( $id, 'g_rating_value', get_rating_value(get_post_meta($id, 'g_rating_data', true)));
    die();
}
add_action('wp_ajax_add_rating_count', 'pt_ajax_increment_rating');
add_action('wp_ajax_nopriv_add_rating_count', 'pt_ajax_increment_rating');

/**
 * Localizes ajax variables for main endpoint
 *
 * @param $cssFiles []
 * @param $jsFiles []
 */
function venom_localize_vars_for_main_ep($cssFiles, $jsFiles) {
    $file = array_pop($jsFiles);
    $file = trim($file, '/');

    wp_localize_script($file, 'ratingObject', [
        'nonce' => wp_create_nonce('rating_nonce')
    ]);
}
add_action('wp-encore/after/ep/main', 'venom_localize_vars_for_main_ep', 10, 2);


/**
 * @return bool
 */
function venom_get_page_index_status() {
    $index_status = true;
	$object = get_queried_object();
	$id = $object->ID ?: $object->taxonomy . '_' .$object->term_id;
    if (class_exists(acf::class)) {
        if (get_option('blog_public') == 0 || get_field('index_button', $id) || is_preview() || is_404()|| is_attachment() || get_post_status() == 'draft') {
            $index_status = false;
        }
    } return $index_status;
}

/**
 * @param $classes
 * @return array
 */
function venom_add_noindex_class_to_body( $classes ) {
    if( !venom_get_page_index_status() && is_user_logged_in() )
        $classes[] = 'has_noindex_tag';

    return $classes;
}
add_filter( 'body_class','venom_add_noindex_class_to_body' );

/**
 * @param $array
 * @return string
 */
function convert_array_to_string_parameters($array) {
    $str = '&';
    $i = 0;
    $numItems = count($array);
    foreach($array as $key => $item) {
        $last_symbol = (++$i === $numItems) ? '' : '&';
        $str.= $key . '=' . $item . $last_symbol;
    } return $str;
}

function get_data_from_template($key, $args) {
    return isset($args[$key]) ? $args[$key] : null;
}

/**
 * @param $common_table
 * @return mixed
 */
function get_table_for_taxonomy_page($common_table) {
    return array_filter($common_table, function ($casino_id) {
        $term = get_query_var( 'term' );
        $taxonomy = get_query_var( 'taxonomy' );
        return has_term( $term, $taxonomy, get_post($casino_id) );
    });
}

function get_toc_headings($key, $table, $entity_id) {
    global $wpdb;
    $id = get_queried_object_id();
    $matches = '';
    $table_name = $wpdb->prefix . $table;
    return $wpdb->get_results( "SELECT meta_value, meta_key, REPLACE(REPLACE( meta_key , 'constructor_' , '' ),'$key','')  AS meta_position
    FROM $table_name 
    WHERE meta_key LIKE '%$key%' 
    AND $entity_id = $id
    AND meta_value <>'' AND substring(meta_key, 1, 1) NOT IN ('_')
    ORDER BY CONVERT(meta_position, SIGNED INTEGER) ASC ;",
            ARRAY_A );
}

/**
 * @param $array
 * @return array
 */
function set_toc_headings_array($array) {
    $selected_headings = [];
    foreach ($array as $item) {
        $d = new DOMDocument('1.0', 'utf-8');
        $d->loadHTML('<?xml encoding="utf-8" ?>' . $item['meta_value']);
        foreach($d->getElementsByTagName('h2') as $tag_item){
            $selected_headings[$item['meta_position']][] = $tag_item->textContent;
        }
    } return $selected_headings;
}

/**
 * @param $first_part
 * @param $second_part
 * @param $index
 * @return string[]
 */
function set_toc_heading_id($first_part, $second_part, $index) {
    $i = 0;
    $first_content_part = '';
    $second_content_part = '';
    $d_first = new DOMDocument('1.0', 'utf-8');
    if ($d_first && $first_part) {
        $d_first->loadHTML('<?xml encoding="utf-8" ?>' . $first_part);
        foreach($d_first->getElementsByTagName('h2') as $key => $tag_item) {
            $id = 'toc_content_'.$index.'_heading_' . $key;
            $tag_item->setAttribute("id", $id);
            $i++;
        }
        $first_content_part = $d_first->saveHTML();
    }

    $d_second = new DOMDocument('1.0', 'utf-8');
    if ($d_second && $second_part) {
        $d_second->loadHTML('<?xml encoding="utf-8" ?>' . $second_part);
        foreach($d_second->getElementsByTagName('h2') as $key => $tag_item) {
            $key = $key + $i;
            $id = 'toc_content_'.$index.'_heading_' . $key;
            $tag_item->setAttribute("id", $id);
        }
        $second_content_part = $d_second->saveHTML();
    }
    return [
        'first' => $first_content_part,
        'second' => $second_content_part
    ];
}

function check_heading_by_key($array, $key) {
    if(array_key_exists($key, $array)) {
        return $array[$key];
    } else {
        return [];
    }
}

/**
 * @param $terms_array
 * @param $terms_string
 * @return array
 */
function split_terms($terms_array, $terms_string) {
    $active_terms_array = [];
    $inactive_terms_array = [];
    foreach ($terms_array as $key => $term) {
        $active_terms_array[$key]['name'] = $term->name;
        $active_terms_array[$key]['link'] = get_term_link($term->term_id, $term->taxonomy);
        $active_terms_array[$key]['term_id'] = $term->term_id;
    }
    $terms_string_exploded = explode(',', $terms_string);

    foreach($terms_string_exploded as $index => $word)
        $terms_string_exploded[$index] = trim($word);

    foreach ($terms_string_exploded as $key => $item) {
        if ($item) {
            $inactive_terms_array[$key]['name'] = $item;
            $inactive_terms_array[$key]['link'] = '';
            $inactive_terms_array[$key]['id'] = null;
        }
    }

    $terms_array = array_merge($active_terms_array, $inactive_terms_array);
    $name = array_column($terms_array, 'name');
    array_multisort($name, SORT_ASC, $terms_array);
    return $terms_array;
}


function href_lang_load_field( $field ) {
	$languages = get_field('languages', 'option');
	if (!$languages || !count($languages)) {
		return $field;
	}
	$field['choices'] = [];
	foreach ($languages as $language) {
		$field['choices'][$language['hreflang']] = $language['country'];
	}
	return $field;
}
add_action('acf/load_field/key=field_60916d579364e', 'href_lang_load_field');


function get_domain_by_hreflang_code($hreflang) {
	$languages = get_field('languages', 'option');
	if (!$languages || !count($languages)) {
		return null;
	}
	foreach ($languages as $language) {
		if ($language['hreflang'] === $hreflang) {
			return $language['domain'];
		}
	}
	return null;
}

function get_slug_by_hreflang_code($hreflang) {
	$object = get_queried_object();
	$id = $object->ID ?: $object->taxonomy . '_' .$object->term_id;
	$hreflangs = get_field('links_hreflang', $id);
	if (!$hreflangs || !count($hreflangs)) {
		return null;
	}
	foreach ($hreflangs as $hr) {
		if ($hr['domain'] === $hreflang) {
			return $hr['slug'];
		}
	}
	return null;
}

function table_filter_controller($data, $sorting, $filter_data) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$payments = $filter_data['payments'] ?: [];
	$software = $filter_data['software']?: [];
	$wpdb->query(table_filter_create_temp_table());
	$wpdb->query($wpdb->prepare(table_filter_fill_temp_table(count($data)), ...$data));

	//Payments filter
	if (count($payments) > 0) {
		$payments_result = $payments;
	} else {
		$payments_result = [];
	}

	if (count($payments_result) > 0) {
		$wpdb->query($wpdb->prepare(table_filter_by_taxonomy(count($payments_result), $prefix), 'casino-payment',  ...$payments_result));
	}

	//Provider filter
	if (count($software) > 0) {
		$software_result = $software;
	} else {
		$software_result = [];
	}
	if (count($software_result) > 0) {
		$wpdb->query($wpdb->prepare(table_filter_by_taxonomy(count($software_result), $prefix), 'casino-provider',  ...$software_result));
	}

	//Sorting
	if ($sorting) {
		$result = $wpdb->get_results(table_filter_get_results($sorting, $prefix), ARRAY_A);
	} else {
		$result = $wpdb->get_results(table_filter_get_results(null, $prefix), ARRAY_A);
	}

	// Result
	$ids = array_map(function ($item) {
		return intval($item['ID']);
	}, $result);

	if (count($ids) === 0) {
		return null;
	}
	$args = [
			'post_type' => 'casino',
			'posts_per_page' => -1,
			'post__in' => $ids,
			'orderby' => 'post__in'
	];
	$filter_query = new WP_Query($args);
	$count = $filter_query->post_count;
	$result = wp_list_pluck( $filter_query->posts, 'ID' );
	return [
		'count' => $count,
		'data' => $result
	];
}