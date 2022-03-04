<?php get_header(); ?>

	<?php if(has_template_parts('/template-parts/content/page/before/')): ?>
	<div class="page-before">
	    <?php get_template_parts("/template-parts/content/page/before/"); ?>
	</div>
	<?php endif; ?>
	
	
	<div class="page-content">
	    <?php get_template_part("/template-parts/content/page/content"); ?>
	</div>
	
	
	<?php if(has_template_parts('/template-parts/content/page/after/')): ?>
		<div class="page-after">
		    <?php get_template_parts("/template-parts/content/page/after/"); ?>
		</div>
	<?php endif; ?>

<?php get_footer(); ?>