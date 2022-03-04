<?php
/**
 * Struktur eines Posts, der einzelnd angezeigt wird.
 */
?>
<article <?php post_class();?> >

	<?php 
	//Has Thumbnai and is Fillwidth?
	if(get_option('mb_fullwidh_thumb_post') != 'on' && get_post_type(get_the_ID()) == 'post'){
		echo thumbnail_fullwidth_or_not(get_the_ID(), $GLOBALS['mb_posttype']); 
	}
	?>
	
	<div class="post-content">
		
		<h1 class="main-title"><?php the_title(); ?></h1>
		
		<div class="publish-date"><?php echo get_the_date() ?></div>
		
		<?php the_content(); ?>

		<div class="post-info">
			<?php echo get_the_term_list( get_the_ID(), 'category', '<ul class="categories"><li>', '</li><li>', '</li></ul>'); ?>
			<?php echo get_the_term_list( get_the_ID(), 'post_tag', '<ul class="tags"><li>', '</li><li>', '</li></ul>'); ?>
		</div>
	</div>

</article>