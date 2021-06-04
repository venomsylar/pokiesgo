<?php
$args = isset($args) ? $args : null;
$news = get_data_from_template('news', $args);

if($news && count($news)) { ?>
	<div class="news_list">
		<div class="container">
			<div class="news_list_wrap">
				<?php foreach($news as $news_item):
					$news_image = $news_item['news_image'];
					$news_info = $news_item['news_info']; ?>
					<div class="news_item">
						<figure><img src="<?php echo $news_image['url'] ?>" alt="<?php echo $news_image['title'] ?>"></figure>
						<p><?php echo $news_info ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php } ?>