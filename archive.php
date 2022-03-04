<?php
/**
 * Für Kategorien; Schlagwörter
 */
get_header(); ?>

<main id="archive-wrapper">
	
	<?php if(has_template_parts('/template-parts/content/index/before/')): ?>
        <div class="archive-before">
            <?php get_template_parts('/template-parts/content/index/before/'); ?>
        </div>
    <?php endif; ?>


    <div class="archive-content">
        <?php
        get_template_part("/template-parts/content/sidebar/left/"); 
        
        get_template_part("/template-parts/content/index/content"); 
        
        get_template_part("/template-parts/content/sidebar/right/"); 
        ?>
    </div>


    <?php if(has_template_parts('/template-parts/content/index/after/')): ?>
        <div class="archive-after">
            <?php get_template_parts('/template-parts/content/index/after/'); ?>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>