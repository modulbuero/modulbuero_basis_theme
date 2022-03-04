<?php
	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function(){
/*
		$current_screen = get_current_screen();
		if (!$current_screen->is_block_editor()) return;
*/
	    wp_enqueue_script(
	        'mbgi-termine', //name
	        get_template_directory_uri() . '/blocks/mbgi-termine.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-termine.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
	    
	    register_block_type('modulbuero/termine', [
			'editor_script' => 'mbgi-termine',
			'render_callback' => 'mb_get_termine_block',
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_termine_block($attr, $content) {
		/**
		 * 	Die Querry wollte einfach nicht das compare unterstützen
		 */
		
		$today = date( 'Y-m-d' );
		$posts = get_posts(array(
			'numberposts'	=> 3,
			'post_type' 	=> 'termin',
			'orderby'   	=> 'meta_value', 
			'order' 		=> 'ASC', 
			'meta_query' => array(
				array(
					'meta_key' 	=> 'mbgi-meta-termin-startdatum',				
					'value'		=> $today,
					'compare'	=> '>=',
					'type'		=> 'DATE',
				)
			),
		));
		
		if(!empty($posts)){
			date_default_timezone_set('UTC');
			
			$output = "<div class='mbgi-block mbgi-block-termine'>";
				$output .= "<h2>Termine</h2>";
		    		$output .= "<div class='mbgi-block-termine-wrap'>";
		    	
					foreach ($posts as $post) {
						$id 		= $post->ID;
						$title 		= $post->post_title;
						$startdatum	= strtotime(get_post_meta($id, 'mbgi-meta-termin-startdatum', true));
						$startdatumtext	= (!empty($startdatum)) ? date_i18n("j. M. Y", $startdatum) : "";
						$startzeit 	= strtotime(get_post_meta($id, 'mbgi-meta-termin-startzeit', true));
						$startzeittext	= (!empty($startzeit))?date_i18n(get_option('time_format'), $startzeit):"";
						$enddatum 	= strtotime(get_post_meta($id, 'mbgi-meta-termin-enddatum', true));
						$enddatumtext 	= (!empty($enddatum))?" - " .date_i18n("j. M. Y", $enddatum):"";
						$endzeit 	= strtotime(get_post_meta($id, 'mbgi-meta-termin-endzeit', true));
						$endzeittext	= (!empty($endzeit))?" - " . date_i18n(get_option('time_format'), $endzeit):"";
						$ganztags 	= get_post_meta($id, 'mbgi-meta-termin-ganztags-checkbox', true) === "on";
						$online 	= get_post_meta($id, 'mbgi-meta-termin-online-checkbox', true) === "on";
						$ort 		= "";

						if($online){
							$ort = ", Online";
						}else{
							$ort = get_post_meta($id, 'mbgi-meta-termin-stadt', true);
							$ort = (isset($ort) && !empty($ort) ) ? ", $ort" : "";
						}
						
						$output .= "<a href=' ". get_permalink($post->ID). "'>";
						
							$output .= "<div class='mbgi-termin mbgi-termin-$id'>";
							$output .= "<div class='mbgi-termin-top'>";
								$output .= "<div class='mbgi-termin-top-wrap'>";
									$output .= "<span class='more'>Zum Termin</span>";
									$output .= "<i class='fas fa-map-marker'></i>";
								$output .= "</div>";
							$output .= "</div>";
							$output .= "<div class='mbgi-termin-content'>";
							
							
								$output .= "<p class='mbgi-termin-titel'>$title</p>";
								$output .= "<div>";
								if ($ganztags && ($startdatum && !$enddatum || $startdatum === $enddatum)) { //ganztags && eintägiger Termin
									$output .= "<p class='mbgi-termin-datum'>" . $startdatumtext . "</p>";
									$output .= "<p class='mbgi-termin-dauer'>ganztags$ort</p>";
								} elseif ($ganztags && ($startdatum && $enddatum && $startdatum !== $enddatum)) { //ganztags && mehrtägiger Termin
									$output .= "<p class='mbgi-termin-datum'>" . $startdatumtext . $enddatumtext . "</p>";
									$output .= "<p class='mbgi-termin-dauer'>ganztags$ort</p>";
								} elseif (!$ganztags && ($startdatum && !$enddatum || $startdatum === $enddatum) && (!$startzeit && !$endzeit)) {//nicht ganztags && eintägiger Termin && ohne Zeitangabe
									$output .= "<p class='mbgi-termin-datum'>" . $startdatumtext . "</p>";
								} elseif (!$ganztags && ($startdatum && $enddatum && $startdatum !== $enddatum) && (!$startzeit && !$endzeit)) { //nicht ganztags && mehrtägiger Termin && ohne Zeitangabe
									$output .= "<p class='mbgi-termin-datum'>" . $startdatumtext . $enddatumtext . "</p>";
								} elseif (!$ganztags && ($startdatum && !$enddatum || $startdatum === $enddatum) && ($startzeit || $endzeit)) { //nicht ganztags && eintägiger Termin && mit Zeitangabe
									$output .= "<p class='mbgi-termin-datum'>" . $startdatumtext . "</p>";
									if (($startzeit === $endzeit) || ($startzeit && !$endzeit)) {
										$output .= "<p class='mbgi-termin-dauer'>" . $startzeittext . " Uhr$ort</p>";
									} elseif ($startzeit && $endzeit) {
										$output .= "<p class='mbgi-termin-dauer'>" . $startzeittext . $endzeittext . " Uhr$ort</p>";
									}
								} elseif (!$ganztags && ($startdatum && $enddatum && $startdatum !== $enddatum) && ($startzeit || $endzeit)) { //nicht ganztags && mehrtägiger Termin && mit Zeitangabe
									$output .= "<p class='mbgi-termin-datum'>" . $startdatumtext . $enddatumtext . "</p>";
									if (($startzeit === $endzeit) || ($startzeit && !$endzeit)) {
										$output .= "<p class='mbgi-termin-dauer'>" . $startzeittext . " Uhr$ort</p>";
									} elseif ($startzeit && $endzeit) {
										$output .= "<p class='mbgi-termin-dauer'>" . $startzeittext . $endzeittext . " Uhr$ort</p>";
									}
								}
								$output .= "</div>";
							$output .= "</div>";
							$output .= "</div>";
						$output .= "</a>";
					}
			
					$output .= "</div>";
				$output .= "<a class='mbgi-button' href='". get_post_type_archive_link($post->post_type)."'>Alle Termine</a>";
			$output .= "</div>";
		
			return $output;
		}else{
			return "";
		}
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_termine_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('termine-block-css', get_template_directory_uri() . '/blocks/mbgi-termine.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mb_enqueue_block_termine_style');