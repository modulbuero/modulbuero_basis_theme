<?php setlocale (LC_TIME, "de_DE"); // für richtige Dateausgabe ?>

<article <?php post_class(); ?>>
    <a class="loop-main-link" href="<?php echo get_the_permalink();?>"></a>

	<div class="loop-wrapper">
		<?php 
	    if(has_post_thumbnail()):	?>
			<div class="loop-thumbnail" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>);"></div>
		<?php endif; ?>
		
		<p class="loop-date">
			<?php echo strftime('%d. %B %Y',get_post_timestamp()); ?>
	    </p>

		<p class="loop-title"><?php the_title(); ?></p>	    
		
		<?php
		if(!has_post_thumbnail()){
	       add_filter('excerpt_length','mb_excerpt_length_verwante');
    	}
		?>
		<p class="loop-excerpt"><?php echo mb_cut_excerpt(get_the_excerpt()); ?></p>
		<?php remove_filter('excerpt_length','mb_excerpt_length_verwante'); ?>
		
		<p class="loop-type"><?php 
			if(get_post_type() == 'post'){
				$postType = 'Beitrag';
			}elseif(get_post_type() == 'presse'){
				$postType = 'Pressemitteilung';
			}else{
				$postType = ucfirst(get_post_type());
			}
			echo $postType; 
			?>
		</p>
		
		<span class="loop-more">weiterlesen</span>
	</div>	
</article>