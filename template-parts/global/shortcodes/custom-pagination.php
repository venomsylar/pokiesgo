<?php
global $wp_query;
$total_pages = $wp_query->max_num_pages;
if ($total_pages > 1) {
    $current_page = max(1, get_query_var('paged')); ?>
   <div class="pagination">
	   <?php
       $url_params_regex = '/\?.*?$/';
    preg_match($url_params_regex, get_pagenum_link(), $url_params);
    $base = !empty($url_params[0]) ? preg_replace($url_params_regex, '', get_pagenum_link()).'%_%/'.$url_params[0] : get_pagenum_link().'%_%';
    $format = 'page/%#%/';
    echo paginate_links(
           array(
               'base' => $base,
               'format' => $format,
               'current' => $current_page,
               'total' => $total_pages,
               'prev_text' => __(''),
               'next_text' => __(''),
               'type' => 'list'
           )
       ); ?>
   </div>
<?php
}
