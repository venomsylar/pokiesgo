<?php
/**
 * Add fields to admin pages list
 *
 * @param $columns
 * @return array
 */
function pt_add_thumbnail_columns($columns)
{
    if(isset($_GET['meta_key'])) {
        if($_GET['order'] == 'desc') {
            $template_btn = '<span onclick="updateURL(\'&order=asc&orderby=meta_value_num&meta_key=_wp_page_template\')" class="tpl_filter_title">Template</span>';
        } else {
            $template_btn = '<span onclick="updateURL(\'&order=desc&orderby=meta_value_num&meta_key=_wp_page_template\')" class="tpl_filter_title">Template</span>';
        }
    } else {
        $template_btn = '<span onclick="updateURL(\'&order=desc&orderby=meta_value_num&meta_key=_wp_page_template\')" class="tpl_filter_title">Template</span>';
    }
    $columns = array();
    $columns['cb'] = '<input type="checkbox" />';
    $columns['title'] = 'Title';
    $columns['featured_thumb'] = 'Thumbnail';
	if ($_GET['post_type'] == 'casino') {
		$columns['hide_casino'] = 'Hide Link';
	}
    if ($_GET['post_type'] == 'page') {
        $columns['tpl_page'] = $template_btn . '<span class="sorting-indicator"></span>';
    }
    $columns['page_link'] = 'Permalink';
    $columns['index_no_index'] = 'Index';
    $columns['date'] = 'Date';
    $columns['modified_by'] = 'Modified by';
    return $columns;
}


function pt_add_posts_additional_features_collumns($column, $post_id)
{
    switch ($column) {
        case 'featured_thumb':
            if(has_post_thumbnail()) {
                echo '<div class="admin_thumb" data-id="'.get_the_ID().'">';
                echo the_post_thumbnail('180x80');
                echo '<span class="delete_thumb dashicons dashicons-no-alt"></span>';
                echo '</div>';
            } else {
                echo '<span class="spinner"></span>';
                echo '<button data-id="'. get_the_ID() .'" class="add_img_from_url dashicons dashicons-admin-links"></button>
                <button data-id="'. get_the_ID() .'" class="dashicons dashicons-admin-media aw_upload_image_button"></button>
                   ';
            }
            break;
        case 'page_link':
            $link = get_the_permalink();
            $link_name = preg_replace('(https?://)', '', $link);
            echo '<a href="'.$link.'" target="_blank" rel="nofollow">'.$link_name.'</a>';
        break;
        case 'modified_by':
            $last_id =  get_post_meta( get_the_ID(), '_edit_last', true );
	        if ( $last_id ) {
		        $last_user = get_userdata($last_id);
		        echo $last_user->display_name;
	        }
        break;
	    case 'hide_casino':
	    	$hide_casino = get_field('hide_review_in_table', get_the_ID());
	    	if ($hide_casino) {
			    echo '<input type="checkbox" name="'.get_the_ID().'" class="hide_casino_button" autocomplete="off" checked="checked">';
		    } else {
			    echo '<input type="checkbox" name="'.get_the_ID().'" class="hide_casino_button" autocomplete="off">';
		    }
	    	break;
        case 'index_no_index':
            if (class_exists('acf')) {
                echo '<span>';
                echo get_field('index_button') ? '<span style="color: #FF0000" class="dashicons dashicons-chart-bar"></span>' : '<span style="color:#7ad03a" class="dashicons dashicons-chart-bar"></span>';
                echo '</span>';
            }
            break;
        case 'tpl_page':
            if ($tpl = str_replace('.php', '', get_post_meta(get_the_ID(), '_wp_page_template'))) {
                $tpl = str_replace('tpl-', '', $tpl);
                echo '<span style="color:#333; font-weight: 700;text-transform: capitalize;">';
                echo $tpl[0];
                echo '</span>';
            }
            break;
    }
}
if (function_exists('add_theme_support')) {
    add_filter('manage_posts_columns', 'pt_add_thumbnail_columns');
    add_action('manage_posts_custom_column', 'pt_add_posts_additional_features_collumns', 10, 2);
    add_filter('manage_pages_columns', 'pt_add_thumbnail_columns');
    add_action('manage_pages_custom_column', 'pt_add_posts_additional_features_collumns', 10, 2);
}

function pt_add_image_from_url()
{
	?>

	<form action="#" class="add_image_from_url_popup">
		<div class="flex_wrap">
			<input type="text" placeholder="Add thumbnail URL" required>
			<div class="spinner"></div>
			<button class="upload_image_button button button-large button-primary" data-id="<?php echo $_POST['add_image_from_url_id'] ?>">Upload</button>
		</div>
		<span class="cross dashicons dashicons-no-alt"></span>
	</form>

	<?php
	die();
}
add_action('wp_ajax_add_image_from_url', 'pt_add_image_from_url');

function pt_upload_image_from_url()
{
	require_once 'helpers.php';
	if(isset($_POST['img_source_value'])&&isset($_POST['el_id'])) {
		$url = $_POST['img_source_value'];
		$thumbnail_id = add_img_to_the_folder($url);
		$post_id = $_POST['el_id'];
		if($thumbnail_id) {
			set_post_thumbnail($post_id,$thumbnail_id);
			echo '<div class="admin_thumb" data-id="'.$post_id.'">';
			echo get_the_post_thumbnail($post_id,'180x80');
			echo '<span class="delete_thumb dashicons dashicons-no-alt"></span>';
			echo '</div>';
		} else {
			return false;
		}
	} else {
		return false;
	}

	die();
}
add_action('wp_ajax_upload_image_from_url', 'pt_upload_image_from_url');

function pt_manage_posts_columns_scripts() {
	wp_enqueue_script( 'admin-pages-table', get_template_directory_uri() . '/inc/plugins/admin-pages-table/admin-pages-table.js');
}
function pt_manage_posts_columns_styles() {
	wp_enqueue_style( 'admin-pages-table', get_template_directory_uri() . '/inc/plugins/admin-pages-table/admin-pages-table.css');
	wp_enqueue_media();
}
if(is_admin() && strpos($_SERVER['REQUEST_URI'],'/wp-admin/edit.php') !== false) {
	add_action( 'admin_enqueue_scripts', 'pt_manage_posts_columns_scripts', 99 );
	add_action( 'admin_enqueue_scripts', 'pt_manage_posts_columns_styles', 99 );
}

function add_image_from_media()
{
	if(isset($_POST['media_upload_id']) || isset($_POST['page_for_upload_id'])) {
		$media_id = $_POST['media_upload_id'];
		$page_id = $_POST['page_for_upload_id'];
		$media = set_post_thumbnail( $page_id, $media_id );
		if($media) {
			echo '<div class="admin_thumb" data-id="'.$page_id.'">';
			echo get_the_post_thumbnail($page_id,'180x80');
			echo '<span class="delete_thumb dashicons dashicons-no-alt"></span>';
			echo '</div>';
		}
	}
	die();
}
add_action('wp_ajax_add_image_from_media', 'add_image_from_media');

function delete_image_from_page()
{
	if(isset($_POST['page_id'])) {
		delete_post_thumbnail($_POST['page_id']);
		echo '<button data-id="'. $_POST['page_id'] .'" class="add_img_from_url dashicons dashicons-admin-links"></button>
              <button data-id="'. $_POST['page_id'] .'" class="dashicons dashicons-admin-media aw_upload_image_button"></button>';
	} else return false;
	die();
}
add_action('wp_ajax_delete_image_from_post', 'delete_image_from_page');


function hide_casino_in_table() {
	$id = isset($_POST['casino-id']) ? $_POST['casino-id'] : null;
	$state = isset($_POST['checkbox-state']) ? $_POST['checkbox-state'] : null;
	if ($id && $state) {
		$state = $state === 'true' ? 1 : 0;
		update_field('hide_review_in_table', $state, $id);
	}
	echo $_POST['checkbox-state'];
	die();
}
add_action('wp_ajax_hide_casino_in_table', 'hide_casino_in_table');