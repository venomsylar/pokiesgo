<?php

/**
 *
 */
class TaxUrlShortcutRewriter
{
	protected static $target_taxs = [];

    protected $tax = '';
	protected $slug = '';

	public function __construct(\WP_Taxonomy $taxonomy)
	{
		$this->taxonomy = $taxonomy;
		$this->tax = $this->taxonomy->name;
		$this->slug = $this->taxonomy->rewrite['slug'];

		self::$target_taxs[$taxonomy->name] = $taxonomy;

		add_filter('pre_term_link',  array($this, 'get_term_permastruct'), 2, 10 );
		add_action('template_redirect', array($this, 'hook_redirect_to_new' ));

		if ( has_filter('pre_handle_404', [self::class, 'filter_handle_404']) ) {
			return;
		}

		add_filter('pre_handle_404', array(self::class, 'filter_handle_404'), 2, 10);
	}

	public function __destruct() {
		unset(self::$target_taxs[$this->taxonomy->name]);

		if (count(self::$target_taxs) > 1) {
			return;
		}

		remove_filter('pre_handle_404', [self::class, 'filter_handle_404']);
	}

	public static function filter_handle_404($handle_404, \WP_Query $query) {
		global $wp;

		if (
			! venom_is_query_404($query) ||
			! (count(self::$target_taxs) > 0) ||
			is_admin() ||
			! $query->is_main_query() ||
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

		$terms = get_terms([
			'taxonomy' => array_keys(self::$target_taxs),
			'slug' => $slug
		]);

		if (is_wp_error($terms) || count($terms) === 0) {
			return $handle_404;
		}

		$term = array_shift($terms);
		$paged = isset( $url_match[2] ) ? absint($url_match[2]) : 1;

	    $query->query([
	    	'tax_query' => [
	    		[
	    			'taxonomy' => $term->taxonomy,
				    'field' => 'slug',
				    'terms' => $term->slug
			    ]
		    ],
		    'paged' => $paged
	    ]);

		$query->rewind_posts();

		if ( $query->have_posts() ) {
			$query->queried_object = $term;
			$query->queried_object_id = $term->term_id;
		}

		return $handle_404;
	}

    public function hook_redirect_to_new()
    {
    	global $wp;

    	if ( !(is_archive($this->tax) || is_tax($this->tax)) ) {
    		return;
	    }

    	$check_res = preg_match("/^$this->slug\//i", $wp->matched_rule);

    	if ( !$check_res ) {
			return;
	    }

	    $term = get_queried_object();
    	$link = get_term_link($term);

    	wp_safe_redirect($link);

	    exit;
    }

	/**
	 * A term's permastructure without prefix
	 *
	 * @param $termlink
	 * @param $term
	 *
	 * @return string
	 */
    public function get_term_permastruct($termlink, $term) {
    	if ($term->taxonomy === $this->tax) {
		    $termlink = preg_replace('/^\/[^\/\%]+/i', '', $termlink);
	    }

    	return $termlink;
    }

    protected function get_qv() {
    	return is_string($this->taxonomy->query_var) ? $this->taxonomy->query_var : $this->tax;
    }
}
