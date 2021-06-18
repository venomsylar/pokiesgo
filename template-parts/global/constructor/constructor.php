<?php
$id = get_queried_object_id();
$constructor = null;
$index = 0;
$toc_headings = [];
if (is_tax()) {
    $term = get_term( $id );
    $taxonomy = $term->taxonomy;
    $constructor = get_field('constructor', $taxonomy . '_' . $id);
} else {
    $constructor = get_field('constructor', $id);
}
$constructor_count = is_array($constructor) ? count($constructor) : 0;
if (is_array($constructor)) {
    foreach ($constructor as $constructor_item) {
        switch ($constructor_item['acf_fc_layout']) {
            case 'table_of_content' :
                get_template_part('/template-parts/global/constructor/constructor-parts/table-of-content', null, [
                    'toc_headings' => $toc_headings,
                    'constructor_count' => $constructor_count,
	                'left_side_text' => $constructor_item['left_side_text']
                ]);
                break;
            case 'content_block' :
                get_template_part('/template-parts/global/constructor/constructor-parts/content', null, [
                    'first_part_visible' => $constructor_item['first_part_visible'],
                    'second_part_hidden' => $constructor_item['second_part_hidden'],
                    'index' => $index
                ]);
                break;
            case 'top_3_casino' :
                get_template_part('/template-parts/global/constructor/constructor-parts/top-3-casino', null, [
                    'title' => $constructor_item['title'],
                    'index' => $index
                ]);
                break;
            case 'table_with_top_3' :
                get_template_part('/template-parts/global/constructor/constructor-parts/table/table', null,
                    [
                        'top-3' => true,
                        'custom' => false,
                        'title' => $constructor_item['title'],
                        'all-casino-link' => $constructor_item['all_casino_link'],
	                    'show-all' => $constructor_item['show_all'],
                        'index' => $index
                    ]);
                break;
            case 'table_without_top_3' :
                get_template_part('/template-parts/global/constructor/constructor-parts/table/table', null,
                    [
                        'top-3' => false,
                        'custom' => false,
                        'title' => $constructor_item['title'],
	                    'all-casino-link' => $constructor_item['all_casino_link'],
                        'show-all' => $constructor_item['show_all'],
                        'index' => $index
                    ]);
                break;
            case 'table_custom_without_top_3' :
                get_template_part('/template-parts/global/constructor/constructor-parts/table/table', null,
                    [
                        'top-3' => false,
                        'custom' => $constructor_item['custom_table'],
                        'title' => $constructor_item['title'],
	                    'all-casino-link' => $constructor_item['all_casino_link'],
	                    'show-all' => $constructor_item['show_all'],
                        'index' => $index
                    ]
                );
                break;
	        case 'table_with_filter' :
		        get_template_part('/template-parts/global/constructor/constructor-parts/table/table-filter/table-with-filter', null,
			        [
				        'title' => $constructor_item['title'],
				        'all-casino-link' => $constructor_item['all_casino_link'],
				        'index' => $index,
				        'filter' => $constructor_item['filter'],
				        'show-all' => $constructor_item['show_all'],
				        'custom' => $constructor_item['custom_table'] && $constructor_item['use_table_type'] === 'custom' ? $constructor_item['custom_table'] : null
			        ]
		        );
		        break;
            case 'providers_or_payments' :
                {
                    get_template_part('/template-parts/global/constructor/constructor-parts/accordion', null, [
                            'accordion-type' => 'taxonomy',
                            'accordion-data' => $constructor_item['accordion_category'],
                            'index' => $index
                        ]
                    );
                }
                if ($constructor_item['accordion_category'] === 'provider') {
                    $toc_headings[$index][0] = get_field('providers_accordion', 'option')['title'];
                } elseif ($constructor_item['accordion_category'] === 'payment') {
                    $toc_headings[$index][0] = get_field('payments_accordion', 'option')['title'];
                }
                break;
            case 'custom_accordion' :
                {
                    get_template_part('/template-parts/global/constructor/constructor-parts/accordion', null, [
                            'accordion-type' => 'custom',
                            'accordion-schema-type' => $constructor_item['use_faq_schema'],
                            'index' => $index,
                            'accordion-data' => [
                                'data' => $constructor_item['accordion'],
                                'title' => $constructor_item['title'],
                                'subtitle' => $constructor_item['accordion_subtitle']
                            ]
                        ]
                    );
                }
                break;
            case 'categories' :
                get_template_part('/template-parts/global/constructor/constructor-parts/casino-categories', null, [
                    'list' => $constructor_item['categories_list'],
                    'id' => $id
                ]);
                break;
	        case 'advantages' :
		        get_template_part('/template-parts/global/constructor/constructor-parts/advantages', null, [
			        'advantages' => $constructor_item['advantages']
		        ]);
		        break;
	        case 'news_block' :
		        get_template_part('/template-parts/global/constructor/constructor-parts/news-block', null, [
			        'news' => $constructor_item['news']
		        ]);
		        break;
            case 'slots' :
                get_template_part('/template-parts/global/constructor/constructor-parts/slots', null, [
                    'list' => $constructor_item['slots_list'],
                    'id' => $id
                ]);
                break;
            case 'all_bonus_list' :
                get_template_part('/template-parts/global/constructor/constructor-parts/bonus/bonus-list', null, [
                    'single' => false,
                    'bonus_type' => $constructor_item['bonus_type'],
                    'id' => $id
                ]);
                break;
            case 'single_bonus' :
                get_template_part('/template-parts/global/constructor/constructor-parts/bonus/bonus-list', null, [
                    'list' => get_field('bonuses_list', $constructor_item['casino']),
                    'casino_id' => $constructor_item['casino'],
                    'single' => true,
                    'id' => $id
                ]);
                break;
	        case 'author' :
		        get_template_part('/template-parts/global/constructor/constructor-parts/author', null);
		        break;
	        case 'call_to_action' :
		        get_template_part('/template-parts/global/constructor/constructor-parts/call-to-action', null, [
			        'button_text' => $constructor_item['button_text'],
			        'casino_id' => $constructor_item['casino']
		        ]);
		        break;
            default :
                return '';
        }
        $index++;
    }
}
