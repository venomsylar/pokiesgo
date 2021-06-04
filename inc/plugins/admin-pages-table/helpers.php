<?php
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

/**
 * Cut name from src
 * @param $src
 * @return mixed
 */
function cut_img_name($src) {
	$str = substr($src, 0, strpos($src, "?"));
	$str_arr = explode('/', $str);
	return $str_arr[count($str_arr) - 1];
}

/**
 * Cut src from end
 * @param $src
 * @return string
 */
function cut_clean_img_url($src) {
	$str = substr($src, 0, strpos($src, "?"));
	return $str;
}

/**
 * Check for Existing by name
 * @param $image_url
 * @return bool
 */
function upload_image_as_attachment($image_url) {
	$filename = basename ($image_url);
	global $wpdb;
	$image_id = intval( $wpdb->get_var( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value LIKE '%/$filename'" ) );
	if($image_id) {
		return 1;
	} else {
		return false;
	}

}

/**
 * @param $url
 * @return bool
 */
function add_img_to_the_folder($url) {
	$file_array = array();
	$tmp = download_url( $url );
	preg_match('/[^?]+\.(jpg|jpe|jpeg|gif|png|svg)/i', $url, $matches);
	$file_array['name'] = basename($matches[0]);
	$file_array['tmp_name'] = $tmp;
	try {
		//Check $matches
		if(!$matches) {
			@unlink($file_array['tmp_name']);
			throw new Exception('Bad request', 400);
		}
		//If image has already exist
		else if(upload_image_as_attachment($url)) {
			@unlink($file_array['tmp_name']);
			throw new Exception('Conflict. Image has already added', 409);
		} else {
			//Return image`s id
			$id = media_handle_sideload( $file_array, 0 );
			try {
				if(is_wp_error($id)) {
					throw new Exception('Bad request', 400);
				}
			} catch (Exception $e) {
				echo json_encode(
						[
								'status' => false,
								'error' => $e -> getMessage(),
								'error_code' => $e -> getCode(),
								'error_trace' => $e -> getTrace()[0],
						]
				); die();
			}
			@unlink( $file_array['tmp_name'] );
			return $id;
		}
	} catch (Exception $e) {
		echo json_encode(
				[
						'status' => false,
						'error' => $e -> getMessage(),
						'error_code' => $e -> getCode(),
						'error_trace' => $e -> getTrace()[0],
				]
		); die();
	}
}

/**
 * Display on front
 * @param $url
 * @return string
 */
function return_my_img($url) {
	return str_replace( 'http://', 'https://', wp_get_upload_dir()['url'].'/' ). cut_img_name($url);
}