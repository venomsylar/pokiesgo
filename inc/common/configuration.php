<?php

/**
 * Clean header
 */
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rel_canonical');

// Remove Emoji js/styles
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');


add_action( 'after_setup_theme', function() {
	get_template_part( 'inc/classes/Updater' );
});


add_action('widgets_init', 'venom_remove_recent_comments_style');

function venom_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

/**
 * Deregister Gutenberg style
 */
add_action( 'wp_print_styles', 'wps_deregister_gutenberg_styles', 100 );
function wps_deregister_gutenberg_styles() {
    wp_dequeue_style( 'wp-block-library' );
}
/**
 * Deregister Gutenberg js
 */
add_action( 'wp_print_scripts', 'deregister_js', 100 );
function deregister_js(){
	if (is_admin()) {
		return;
	}
	wp_dequeue_script( 'wp-polyfill' );
	wp_deregister_script( 'wp-polyfill' );

	wp_dequeue_script( 'wp-hooks' );
	wp_deregister_script( 'wp-hooks' );

	wp_dequeue_script( 'wp-i18n' );
	wp_deregister_script( 'wp-i18n' );

	wp_dequeue_script( 'lodash' );
	wp_deregister_script( 'lodash' );

	wp_dequeue_script( 'wp-embed' );
	wp_deregister_script( 'wp-embed' );
}


/*Fix Custom Field Block*/
add_filter('acf/settings/remove_wp_meta_box', '__return_false', 9999);

// Remove ID and classes in menu list
add_filter('nav_menu_css_class', 'venom_remove_menu_attributes', 100, 1);
add_filter('nav_menu_item_id', 'venom_remove_menu_attributes', 100, 1);
add_filter('page_css_class', 'venom_remove_menu_attributes', 100, 1);
function venom_remove_menu_attributes($var)
{
    return is_array($var) ? array_intersect($var, array('current-menu-item','menu-item-has-children')) : '';
}

/* ACF Repeater Styles */
function venom_hook_add_acf_repeater_even_colors()
{
    $scheme = get_user_option('admin_color');
    $color = '';

    if ($scheme == 'fresh') {
        $color = '#0073aa';
    } elseif ($scheme == 'light') {
        $color = '#d64e07';
    } elseif ($scheme == 'blue') {
        $color = '#52accc';
    } elseif ($scheme == 'coffee') {
        $color = '#59524c';
    } elseif ($scheme == 'ectoplasm') {
        $color = '#523f6d';
    } elseif ($scheme == 'midnight') {
        $color = '#e14d43';
    } elseif ($scheme == 'ocean') {
        $color = '#738e96';
    } elseif ($scheme == 'sunrise') {
        $color = '#dd823b';
    }
    echo '<style>.acf-repeater > table > tbody > tr:nth-child(even) > td.order {color: #fff !important;background-color: '.$color.' !important; text-shadow: none}.acf-fc-layout-handle {color: #fff !important;background-color: #23282d!important; text-shadow: none}</style>';
}
add_action('admin_footer', 'venom_hook_add_acf_repeater_even_colors');

/**
 * Restore SVG & CSV upload functionality for WordPress 4.9.9 and up
 */

function venom_hook_allow_svg_mimetype($mimes)
{
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}
add_filter('upload_mimes', 'venom_hook_allow_svg_mimetype');

function venom_wpa_fix_svg_thumb()
{
    echo '<style>td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {width: 100% !important;height: auto !important}</style>';
}
add_action('admin_head', 'venom_wpa_fix_svg_thumb');

/**
 * Add noindex tax to admin
 */
function venom_add_noindex_tag_to_admin_bar()
{
    if (is_admin()) { ?>
		<meta name="robots" content="noindex, nofollow" />
	<?php }
}
add_action('admin_head', 'venom_add_noindex_tag_to_admin_bar');

// Show empty categories in category widget
function venom_show_empty_categories_links($args)
{
    $args['hide_empty'] = 0;

    return $args;
}

add_filter('widget_categories_args', 'venom_show_empty_categories_links');

/**
 * @param $title
 * @return string
 */
function venom_remove_spaces_from_widget_title($title)
{
    return $title == '&nbsp;' ? '' : $title;
}

add_filter('widget_title', 'venom_remove_spaces_from_widget_title');

/**
 * Menu change a[src="#"] to span
 */
function venom_hook_replace_empty_link_on_span_tag($item_output, $item, $depth, $args)
{
    if (empty($item->url) || '#' === $item->url || $item->current) {
        $item_output = $args->before;
        $item_output .= '<span class="empty_link">';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</span>';
        $item_output .= $args->after;
    }
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'venom_hook_replace_empty_link_on_span_tag', 10, 4);

/**
 * ACF json auto import and update
 */
function venom_get_acf_json_save_point($path)
{
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    // return
    return $path;
}
add_filter('acf/settings/save_json', 'venom_get_acf_json_save_point');

function venom_get_acf_json_load_point($paths)
{
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';
    // return
    return $paths;
}
add_filter('acf/settings/load_json', 'venom_get_acf_json_load_point');

/**
 * Set default permalink structure
 */
function venom_hook_set_permalink()
{
    update_option('permalink_structure', '/%postname%/');
}
add_action('after_switch_theme', 'venom_hook_set_permalink');

/**
 * Remove Yoast SEO comment
 */
if (defined('WPSEO_VERSION')) {
    add_action('wp_head', function () {
        ob_start(function ($o) {
            return preg_replace('/^\n?<!--.*?[Y]oast.*?-->\n?$/mi', '', $o);
        });
    }, ~PHP_INT_MAX);
}

/**
 * Disable canonical (Yoast SEO)
 */
add_filter('wpseo_canonical', '__return_false');

/**
 * Disable Feed
 */
function venom_hook_disable_feed()
{
    wp_redirect(home_url(), '301');
}
add_action('do_feed', 'venom_hook_disable_feed', 1);
add_action('do_feed_rdf', 'venom_hook_disable_feed', 1);
add_action('do_feed_rss', 'venom_hook_disable_feed', 1);
add_action('do_feed_rss2', 'venom_hook_disable_feed', 1);
add_action('do_feed_atom', 'venom_hook_disable_feed', 1);
add_action('do_feed_rss2_comments', 'venom_hook_disable_feed', 1);
add_action('do_feed_atom_comments', 'venom_hook_disable_feed', 1);

/**
 * Remove Comments Support
 */
function venom_hook_remove_comment_from_admin_bar()
{
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'venom_hook_remove_comment_from_admin_bar');

// Removes from post and pages
function venom_hook_remove_comment_support()
{
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}
add_action('init', 'venom_hook_remove_comment_support', 100);

// Removes from admin bar
function venom_hook_remove_comments_from_admin_bar()
{
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'venom_hook_remove_comments_from_admin_bar');

/**
 * HTML Minify (DON`T use comments in html)
 */
function venom_minify_output_html() {
    if(class_exists(acf::class)) {
        get_field('compress_html','option') ? ob_start('venom_minify_output_html_callback') : false;
    }
}
function venom_minify_output_html_callback($buf){
    return preg_replace(array('/<!--(?>(?!\[).)(.*)(?>(?!\]).)-->/Uis','/[[:blank:]]+/'),array('',' '),str_replace(array("\n","\r","\t"),'',$buf));
}
if(!is_admin()) {
    add_action('get_header','venom_minify_output_html',99999);
}

/**
 * @param WP_Query $query
 * @return bool
 */
function venom_is_query_404(\WP_Query $query) {
    return !$query->have_posts() || $query->get('error') === '404';
}

/**
 * Import settings for editor
 */
function venom_tinymce_custom_settings() {
    global $current_screen;
    if($current_screen && $current_screen->id == 'settings_page_tinymce-advanced') {
        $json_string = file_get_contents('plugins/tinymce-advanced-preconfig.json', true); ?>
        <script type="text/javascript">jQuery(function($) {
                let tcs_json = '<?php echo trim($json_string); ?>';
                $('textarea#tadv-import').val(tcs_json);
            });</script>
    <?php }
}
add_action('admin_head', 'venom_tinymce_custom_settings', 10);


/**
 * REDIRECTION
 */

function prefix_movie_rewrite_rule() {
    add_rewrite_rule( ' \?/go-to\?/', 'index.php?go-to=$matches[1]', 'top' );
}

add_action( 'init', 'prefix_movie_rewrite_rule' );
function prefix_register_query_var( $vars ) {
    $vars[] = 'go-to';

    return $vars;
}
add_filter( 'query_vars', 'prefix_register_query_var' );
add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    if ( $url_path === 'go-to' ) {
        // load the file if exists
        $load = locate_template('tpl-redirection.php', true);
        if ($load) {
            exit(); // just exit if template was found and loaded
        }
    }
});


add_action('admin_head', 'slots_tax_field'); // admin_head is a hook my_custom_fonts is a function we are adding it to the hook

function slots_tax_field() {
    echo '<style>
    .acf-field-5f9d1f7e32107 ul.ui-sortable li {
            float: none!important;
            display: block!important;
        }
  </style>';
}

add_action( 'admin_notices', 'my_plugin_notice' );
function my_plugin_notice() {
    if (isset($_GET['post_type']) && count($_GET) === 1 && $_GET['post_type'] === 'casino') { ?>
        <div class="notice notice-warning is-dismissible">
            <p>Після додавання нового казино, для відображення його у таблицях це казино слід додати у головну таблицю, яка знаходиться у
                <a href="/wp-admin/admin.php?page=acf-options-constructor" target="_blank" rel="nofollow noopener">Theme Settings (Constructor)</a>
            </p>
        </div>
    <?php }
}

// define the bcn_breadcrumb_title callback
function filter_bcn_breadcrumb_title( $title, $this_type, $this_id ) {
//	var_dump($this_type);
	if ($this_type[1] === 'taxonomy') {
		$tax = $this_type[2];
		$short_name = get_field('short_name', $tax . '_' . $this_id);
		if ($short_name) {
			return $short_name;
		} else {
			return $title;
		}
	} else {
		$short_name = get_field('short_title', $this_id);
		if ($short_name) {
			return $short_name;
		}
	}
	return $title;
};

// add the filter
add_filter( 'bcn_breadcrumb_title', 'filter_bcn_breadcrumb_title', 10, 3 );

add_filter('acf/fields/relationship/query', 'post_status_acf_fields_relationship_query', 10, 3);
function post_status_acf_fields_relationship_query( $args, $field, $post_id ) {
	$args['post_status'] = 'publish';
	return $args;
}