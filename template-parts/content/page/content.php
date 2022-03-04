<article <?php post_class(); ?>>

	<?php 
	if(get_option('mb_fullwidh_thumb_page') != 'on' && get_post_type(get_the_ID()) != 'post'){
		echo thumbnail_fullwidth_or_not(get_the_ID(), "post"); 
	}
	?>

	<div class="post-content">
		<h1 class="main-title"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div> <!-- post-content -->

</article>