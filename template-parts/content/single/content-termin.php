<article <?php post_class(); ?>>

	<?php if(has_post_thumbnail()):	?>
		<div class="thumb-wrap">
			<div class="thumbnail" style='background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>);'></div>
			<span class="copyright"></span>
		</div> <!-- thumb-wrap -->
	<?php endif ?>
	<div class="post-content">
		<h2 class="post-title"><?php the_title(); ?></h2>
		<?php
			
			$startdatum = strtotime(get_post_meta($id, 'mbgi-meta-termin-startdatum', true));
			$enddatum = strtotime(get_post_meta($id, 'mbgi-meta-termin-enddatum', true));
			$strasse = get_post_meta($id, 'mbgi-meta-termin-strasse', true);
			$plz = get_post_meta($id, 'mbgi-meta-termin-plz', true);
			$stadt = get_post_meta($id, 'mbgi-meta-termin-stadt', true);
			
			if ($startdatum === $enddatum) { //ganztägige Termine
				echo "<p class='mbgi-termin-datum'>" . date_i18n(get_option('date_format'), $startdatum) . "</p>"; 
				echo "<p class='mbgi-termin-dauer'>ganztags</p>";
			} elseif ($startdatum + 86400 > $enddatum) { //eintägige Termine bis zu 24h
				echo "<p class='mbgi-termin-datum'>" . date_i18n(get_option('date_format'), $startdatum) . "</p>";
				echo "<p class='mbgi-termin-dauer'>" . date_i18n(get_option('time_format'), $startdatum) . " - " . date_i18n(get_option('time_format'), $enddatum) . " Uhr</p>";
			} else { //mehrtägige Termine
				echo "<p class='mbgi-termin-datum'>" . date_i18n(get_option('date_format'), $startdatum) . " - " . date_i18n(get_option('date_format'), $enddatum) . "</p>"; 
				echo "<p class='mbgi-termin-dauer'>ganztags</p>";
				}
			
			if (get_post_meta($id, 'mbgi-meta-termin-online-checkbox', true) === "on") {
				echo "<p class='mbgi-termin-online-link'><a href='" . get_post_meta($id, 'mbgi-meta-termin-link', true) . "'>Link zum Online-Meeting</a></p>";
			} else {
				echo "<p class='mbgi-termin-ort'>$strasse, $plz $stadt</p>";
			}
			
			if (get_post_meta($id, 'mbgi-meta-termin-ical', true) == 'on') {
				echo "<p class='mbgi-termin-ical'><a href='".content_url()."/ical/termin-" . get_the_ID() . ".ical' download>Diesen Termin als iCal-Datei herunterladen</a></p>";
				echo "<p class='mbgi-termin-ical'><a href='".content_url()."/ical/termin-" . get_the_ID() . ".ics' download>Diesen Termin als ics-Datei herunterladen</a></p>";
			}
			
			?>
			
			
	    <div class="mbgi-termin-content"><?php the_content(); ?></div>
	    
	    <?php echo mb_get_openstreetmap_block(array(
		    'street' => $strasse,
		    'postalcode' => $plz,
		    'city' => $stadt,
		    'country' => 'de'
		    ), null); ?>
		
	</div> <!-- post-content -->

</article>