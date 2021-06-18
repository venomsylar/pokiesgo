<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php wp_title(); ?></title>
    <link rel='canonical' href='<?php echo venom_get_custom_canonical(); ?>' />
    <?php echo venom_get_meta_robots(); ?>
    <?php get_template_part('template-parts/global/header/head/favicon'); ?>
    <?php get_template_part('template-parts/global/header/head/google-site-verification'); ?>
    <?php get_template_part('template-parts/global/header/head/tag-manager/tag-manager-first-part'); ?>
    <?php get_template_part('template-parts/global/header/head/hotjar'); ?>
    <?php get_template_part('template-parts/global/header/head/google-analytics'); ?>
    <?php get_template_part('template-parts/global/header/head/hreflangs'); ?>
    <meta name="MobileOptimized" content="width"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="initial-scale=1.0, width=device-width">
    <?php wp_head(); ?>
	<?php get_template_part('template-parts/global/header/microlayouts/index'); ?>
</head>
<body <?php body_class(); ?>>
<?php get_template_part('template-parts/global/header/head/tag-manager/tag-manager-second-part'); ?>
<div id="main">
   <header>
      <div class="container flex_align_center_wrap">
         <div class="header_left">
             <?php echo venom_get_header_logo(); ?>
         </div>
         <div class="header_right">
	         <?php get_template_part('template-parts/global/header/main-menu'); ?>
	         <?php get_template_part('template-parts/global/header/languages'); ?>
         </div>
      </div>
   </header>
