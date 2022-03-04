<article <?php post_class(); ?> xy>
    <a class="link" href="<?php echo get_the_permalink();?>"></a>
    <div class="date-wrap-container">
		<div class="date-wrap">
			<span class="more">mehr Erfahren</span>
			<span class="publish-date"></span>
		</div>
    </div>
	<div class="post-content">
		<?php 
		$beschreibung = esc_attr( get_post_meta( get_the_ID(), 'mbgi-person-beschreibung', true ) );
		$foto 		  = get_post_meta(get_the_ID(), 'mbgi-person-foto', true );

	    if(!empty($foto)) : ?>
		<div class="thumbnail" style="background-image: url(<?php echo $foto; ?>);"></div>
		<?php endif; ?>
		
		<div class="post-content-wrapper">
			<h3><?php echo get_the_title();?></h3>
			<p class="post-loop-description"><?php echo mb_cut_excerpt($beschreibung, 300); ?></p>
		</div>
	</div>
</article>