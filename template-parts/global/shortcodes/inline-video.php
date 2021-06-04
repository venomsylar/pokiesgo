<?php
$args = isset($args) ? $args : null;
$link_id = get_data_from_template('id', $args);
$float = get_data_from_template('float', $args);
?>
<a class="fancyBoxVideo <?php echo $float ?>" href="<?php echo 'https://www.youtube.com/watch?v=' . $link_id ?>">
	<img src="<?php echo 'https://img.youtube.com/vi/'.$link_id.'/0.jpg' ?>" alt="youtube video">
</a>