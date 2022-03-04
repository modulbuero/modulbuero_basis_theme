<article <?php post_class(); ?>>
    <a class="link" href="<?php echo get_the_permalink();?>"></a>
    <div class="date-wrap-container">
		<div class="date-wrap">
			<span class="more">weiterlesen</span>
			<span class="publish-date"><i class="fas fa-map-marker"></i></span>
		</div>
    </div>
	<div class="post-content">
		
		<?php if(has_post_thumbnail()):	?>
			<div class="thumbnail" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>);"></div>
		<?php endif ?>
		<div class="post-content-wrapper">
			<h6 class="post-loop-title"><?php the_title(); ?></h6>
			<div class='post-loop-bottom'>
			<?php
				$startdatum = strtotime(get_post_meta($id, 'mbgi-meta-termin-startdatum', true));
				$enddatum = strtotime(get_post_meta($id, 'mbgi-meta-termin-enddatum', true));
	            $ort = get_post_meta($id, 'mbgi-meta-termin-stadt', true);
                $ort = (isset($ort) && !empty($ort) ) ? ", $ort" : "";                
				
				if ($startdatum === $enddatum) { //ganztägige Termine
					echo "<p class='mbgi-termin-datum'>" . date_i18n(get_option('date_format'), $startdatum) . "</p>";  
					echo "<p class='mbgi-termin-dauer'>ganztags$ort</p>";
				} elseif ($startdatum + 86400 > $enddatum) { //eintägige Termine bis zu 24h
					echo "<p class='mbgi-termin-datum'>" . date_i18n(get_option('date_format'), $startdatum) . "</p>";
					echo "<p class='mbgi-termin-ort'>" . date_i18n(get_option('time_format'), $startdatum) . " - " . date_i18n(get_option('time_format'), $enddatum) . " Uhr$ort</p>";
				} else { //mehrtägige Termine
					echo "<p class='mbgi-termin-datum'>" . date_i18n(get_option('date_format'), $startdatum) . " - " . date_i18n(get_option('date_format'), $enddatum) . "</p>"; 
					echo "<p class='mbgi-termin-dauer'>ganztags$ort</p>";
				}
			?>
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
	</div> <!-- post-content -->
</article><!-- post-article -->