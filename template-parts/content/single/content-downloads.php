<?php
	
	$link = esc_attr( get_post_meta( get_the_ID(), 'mbgi-youtube-link-meta-box', true ) );
	preg_match('/watch\?v=(.)+/', $link, $match);
	$videoid = str_replace("watch?v=", "", $match[0]);

?>
<article <?php post_class();?> >
	<div class="post-content">
		
		<h1 class="main-title"><?php the_title(); ?></h1>
		
		<div class="publish-date"><?php echo get_the_date() ?></div>

		<div class='youtube-iframe-wrap'>
			<iframe width="840" height="472" src="https://www.youtube-nocookie.com/embed/<?php echo $videoid; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>

		<div class="post-info">
			<?php echo get_the_term_list( get_the_ID(), 'category', '<ul class="categories"><li>', '</li><li>', '</li></ul>'); ?>
			<?php echo get_the_term_list( get_the_ID(), 'post_tag', '<ul class="tags"><li>', '</li><li>', '</li></ul>'); ?>
		</div>
	</div>
</article>