<?php get_header(); 

	/*wird genutzt als beitragsseite für aktuelles*/
    if ( have_posts() && is_home()) { 

		if(has_template_parts('/template-parts/content/index/before/')): ?>
	        <div class="index-before">
	            <?php get_template_parts('/template-parts/content/index/before/'); ?>
	        </div>
        <?php endif; ?>

        <div class="index-content">
            <?php
            get_template_part("/template-parts/content/sidebar/left/"); 
            
            get_template_part("/template-parts/content/index/content", $GLOBALS['mb_posttype']); 
            
            get_template_part("/template-parts/content/sidebar/right/"); 
            ?>
        </div>

        <?php if(has_template_parts('/template-parts/content/index/after/')): ?>
        <div class="index-after">
            <?php get_template_parts('/template-parts/content/index/after/'); ?>
        </div>
        <?php endif;

    } else {
	    echo "<main id='no-index-content-found'>";
	        get_template_part( 'template-parts/content/none');
        echo "</main>";
    }
    
get_footer();