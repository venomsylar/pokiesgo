<?php
/**
 * @return string
 */
function table_filter_create_temp_table() {
	return "CREATE TEMPORARY TABLE table_filter (ID int(15))";
}

function table_filter_fill_temp_table($count) {
	return "
        INSERT INTO table_filter (ID)
        VALUES (".implode('), (', array_fill(0, $count, '%s')).")
    ";
}

/**
 * @param $count
 * @return string
 */
function table_filter_by_taxonomy($count, $prefix) {
	$wp_posts = $prefix . 'posts';
	$wp_term_relationships = $prefix . 'term_relationships';
	$wp_term_taxonomy = $prefix . 'term_taxonomy';
	return "
        DELETE FROM table_filter
            WHERE table_filter.ID NOT IN(
                SELECT DISTINCT `$wp_posts`.ID
                FROM
                    `$wp_posts`
                JOIN `$wp_term_relationships` ON `$wp_posts`.ID = `$wp_term_relationships`.object_id
                JOIN `$wp_term_taxonomy` ON `$wp_term_relationships`.term_taxonomy_id = `$wp_term_taxonomy`.term_id
                WHERE `$wp_term_taxonomy`.taxonomy = '%s' AND `$wp_term_taxonomy`.term_id IN(" .implode(', ', array_fill(0, $count, '%s')). "))
        ";
}

/**
 * @return string
 */
function table_filter_get_results($type, $prefix) {
	$wp_postmeta = $prefix . 'postmeta';
	$wp_posts = $prefix . 'posts';
	switch ($type) {
		case 'games_count' : return "
            SELECT tf.ID FROM table_filter tf
            INNER JOIN `$wp_postmeta` pm ON pm.post_id = tf.ID
            WHERE pm.meta_key = 'games_count_casino'
            ORDER BY CAST(REPLACE(pm.meta_value, '+', '') AS unsigned) DESC
        ";
		case 'name' : return "
            SELECT tf.ID FROM table_filter tf
            INNER JOIN `$wp_posts` posts ON posts.ID = tf.ID
            ORDER BY posts.post_title
        ";
		case 'newest_first' : return "
            SELECT DISTINCT tf.ID FROM table_filter tf
            INNER JOIN `$wp_posts` posts ON posts.ID = tf.ID
            ORDER BY posts.post_date DESC
        ";
		default : return "SELECT DISTINCT ID FROM table_filter";
	}
}