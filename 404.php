<?php get_header(); ?>
<div class="content">
   <div class="container">
      <h1>Sorry, we couldn`t find that page</h1>
      <p>You can check our most popular articles instead:</p>
	   <?php
	   get_template_part('/template-parts/global/constructor/constructor-parts/casino-categories', null, [
			   'list' => get_field('categories_list', 'option'),
			   'id' => 0
	   ]);
	   get_template_part('/template-parts/global/constructor/constructor-parts/table/table', null, [
			   'top-3' => false,
			   'custom' => false,
			   'title' => 'Or start playing your favourite games in these safe and secure online casinos:',
			   'index' => 1
	   ]);
	   ?>
   </div>
</div>
<?php get_footer(); ?>