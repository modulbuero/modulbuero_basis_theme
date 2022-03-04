<?php
/**
 * Spezielle Struktur von einem Post für Loops / Kachelansicht.
 * 
 * Wird zum Beispiel von post-loop-verwante.php aufgerufen.
 */
//setlocale (LC_TIME, "de_DE");
?>

<article <?php post_class(); ?> xy>
	<?php $link = get_post_meta(get_the_ID(), 'mbgi-medien-link', true) ?: "#"; ?>
    <a class="link" href="<?php echo $link;?>" target='_blank'></a>
    <div class="date-wrap-container">
		<div class="date-wrap">
			<span class="more">weiterlesen</span>
			<span class="publish-date"><?php echo strftime('%d. %B %Y',get_post_timestamp()); ?></span>
		</div>
    </div>
	<div class="post-content">
		<?php 
	    if(has_post_thumbnail()):	?>
			<div class="thumbnail" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>);"></div>
		<?php endif; ?>
		
		<div class="post-content-wrapper">
			<h6 class="post-loop-title"><?php the_title(); ?></h6>
			<?php
			if(!has_post_thumbnail()){
		       add_filter('excerpt_length','mb_excerpt_length_verwante');
        	}
			?>
			<p class="excerpt"><?php echo mb_cut_excerpt(get_the_excerpt()); ?></p>
			<?php
			remove_filter('excerpt_length','mb_excerpt_length_verwante');	
			?>
			<div class='post-loop-bottom'>
				<span class="post-type"><?php 
					if(get_post_type() == 'post'){
						$postType = 'Beitrag';
					}elseif(get_post_type() == 'presse'){
						$postType = 'Pressemitteilung';
					}else{
						$postType = ucfirst(get_post_type());
					}
					echo $postType; 
					?>
				</span>
			</div>
		</div>
	</div>
</article>
