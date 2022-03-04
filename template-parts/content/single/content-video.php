<?php
	
	$link = esc_attr( get_post_meta( get_the_ID(), 'mbgi-youtube-link-meta-box', true ) );
	preg_match('/watch\?v=(.)+/', $link, $match);
	$videoid = str_replace("watch?v=", "", $match[0]);
	
?>

<h1 class="post-title"><?php the_title(); ?></h1>	

<div class='youtube-iframe-wrap'>
	<iframe width="840" height="472" src="https://www.youtube-nocookie.com/embed/<?php echo $videoid; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

<p><?php the_content(); ?></p>