<?php get_header(); 
$post_type = get_post_type(); ?>

	<?php if(has_template_parts("/template-parts/content/single/before/", $post_type)): ?>
		<div class="single-before">
		    <?php get_template_parts("/template-parts/content/single/before/", $post_type); ?>
		</div>
	<?php endif; ?>
	
	<div class="single-content">
	    <?php 
		get_template_part("/template-parts/content/sidebar/left/"); 

	    get_template_part("/template-parts/content/single/content", $post_type);

		get_template_part("/template-parts/content/sidebar/right/"); 
		?>
	</div>
	
	<?php if(has_template_parts('/template-parts/content/single/after/', $post_type) ): ?>
		<div class="single-after">
		    <?php get_template_parts("/template-parts/content/single/after/", $post_type); ?>
		</div>
	<?php endif;?>

<?php get_footer(); ?>