<?php


class PostUrlShortcutRewriter {

	protected static $target_post_types = [];

	protected $post_type;

	public function __construct(\WP_Post_Type $post_type)
	{
		$this->post_type = $post_type;

		self::$target_post_types[$post_type->name] = $post_type;

		add_filter('post_type_link', [$this, 'get_post_link'], 4, 10);
		add_action('template_redirect', [$this, 'hook_redirect_to_new']);

		if ( has_filter('pre_handle_404', [self::class, 'filter_handle_404']) ) {
			return;
		}

		add_filter('pre_handle_404', array(self::class, 'filter_handle_404'), 2, 10);
	}

	public static function filter_handle_404($handle_404, \WP_Query $query)
	{
		global $wp;

		if (
			!venom_is_query_404($query) ||
			!(count(self::$target_post_types) > 0) ||
			is_admin() ||
			!$query->is_main_query() ||
			$handle_404
		) {
			return $handle_404;
		}

		$request = isset($wp->request) ? $wp->request : '';

		if (!$request) {
			return $handle_404;
		}

		preg_match('/([^\/]+)(?:\/page\/([0-9]+)\/?)?$/', $request, $url_match);

		$slug = isset($url_match[1]) ? $url_match[1] : '';

		if (!$slug) {
			return $handle_404;
		}

		$paged = isset( $url_match[2] ) ? absint($url_match[2]) : 1;

		$query->query([
			'name' => $slug,
			'post_type' => array_keys(self::$target_post_types),
			'posts_per_page' => 1,
			'paged' => 1
		]);

		$query->set('paged', $paged);

		if ( !$query->have_posts() ) {
			return $handle_404;
		}

		$query->the_post();

		$query->queried_object = get_post();
		$query->queried_object_id = get_the_ID();

		$query->rewind_posts();

		return $handle_404;
	}

	public function get_post_link($post_link, $post, $leavename, $sample)
	{
		$post = get_post($post);

		if ($post->post_type !== $this->post_type->name) {
			return $post_link;
		}

		$post_link = "/%$post->post_type%";

		$slug = $post->post_name;

		$draft_or_pending = get_post_status( $post ) && in_array( get_post_status( $post ), array( 'draft', 'pending', 'auto-draft', 'future' ) );

		$post_type = get_post_type_object($post->post_type);

		if ( $post_type->hierarchical ) {
			$slug = get_page_uri( $post );
		}

		if ( !empty($post_link) && ( !$draft_or_pending || $sample ) ) {
			if ( ! $leavename ) {
				$post_link = str_replace("%$post->post_type%", $slug, $post_link);
			}
			$post_link = home_url( user_trailingslashit($post_link) );
		} else {
			if ( $post_type->query_var && ( isset($post->post_status) && !$draft_or_pending ) )
				$post_link = add_query_arg($post_type->query_var, $slug, '');
			else
				$post_link = add_query_arg(array('post_type' => $post->post_type, 'p' => $post->ID), '');
			$post_link = home_url($post_link);
		}

		return $post_link;
	}

	public function hook_redirect_to_new()
	{
		global $wp;

		$slug = $this->post_type->rewrite['slug'];

		if ( !is_singular($slug) ) {
			return;
		}

		$check_res = preg_match("/^{$slug}\//i", $wp->matched_rule);

		if ( !$check_res ) {
			return;
		}

		$link = get_the_permalink();

		wp_safe_redirect($link);

		exit;
	}

	public function __destruct()
	{
		unset(self::$target_post_types[$this->post_type->name]);
	}
}
