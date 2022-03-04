<!doctype html>
<html lang="de">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php 
	wp_head(); 
	$GLOBALS['mb_posttype'] = get_post_type();
	?>
</head>

<body <?php body_class("typ-".$GLOBALS['mb_posttype']); ?>>
	
	<?php wp_body_open(); ?>
	
	<div id="mb-container">

		<header>
			<div class="satzspiegel">
	            <?php if(has_template_parts( '/template-parts/header/before/', get_post_type())): ?>
		            <div class="header-before">
						<?php get_template_parts( '/template-parts/header/before/', get_post_type()); ?>
		            </div>
	            <?php endif; ?>
	
	            <?php get_template_part('/template-parts/header/content', get_post_type()); ?>
	
	            <?php if(has_template_parts( '/template-parts/header/after/', get_post_type())): ?>
		            <div class="header-after">
		                <?php get_template_parts( '/template-parts/header/after/', get_post_type()); ?>
		            </div>
	            <?php endif; ?>
			</div>
        </header>

        <main>
	        <?php
	        if(get_option('mb_fullwidh_thumb_post') == 'on' && get_post_type(get_the_ID()) == 'post'){
		        echo thumbnail_fullwidth_or_not(get_the_ID(), "post");
	        }elseif(get_option('mb_fullwidh_thumb_page') == 'on' && get_post_type(get_the_ID()) != 'post'){
				echo thumbnail_fullwidth_or_not(get_the_ID()); 		        
	        }

	         
	        ?>
	        <div class="satzspiegel">