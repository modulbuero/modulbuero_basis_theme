<?php get_header(); ?>

<?php get_search_form(true); ?>

<div class="search-results post-loop-single-wrap">
    <?php if (have_posts()) : while (have_posts()): the_post(); ?>
        <?php
        $post_type = get_post_type();
        /* unterscheiden zwischen page und single wegen ordnerstruktur */
        $path = $post_type == "page" ? "page" : "single";
        get_template_part("/template-parts/content/".$path."/loop", $post_type); ?>

    <?php endwhile; endif; ?>
</div>

<?php get_footer();