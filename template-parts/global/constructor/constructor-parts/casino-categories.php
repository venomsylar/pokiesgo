<?php
$args = isset($args) ? $args : null;
$categories = get_data_from_template('list', $args);
$id = get_data_from_template('id', $args);
if(is_array($categories)) { ?>
    <div class="casino_categories_links">
        <div class="container">
            <ul>
                <?php foreach($categories as $category):
                    $name_title = $category['title'];
                    $term = $category['category'];
                    if ($term) {
                        $term_id = $term->term_id;
                        $term_name = $term->name;
                        $link = get_term_link($term_id, 'casino-category');
                        $result = '';
                        if ($term_id !== $id) {
                            if ($name_title) {
                                $result = '<li><a href="'.$link.'">'.$name_title.'</a></li>';
                            } else {
                                $result = '<li><a href="'.$link.'">'.$term_name.'</a></li>';
                            }
                            echo $result;
                        }
                    } ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php } ?>