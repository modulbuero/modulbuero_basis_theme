<?php
	add_action('init', function() {
		wp_register_script(
	        'mbgi-widget-termine', //name
	        get_template_directory_uri() . '/widgets/mbgi-widget-termine.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/widgets/mbgi-widget-termine.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/widget-termine', [
			'editor_script' => 'mbgi-widget-termine',
			'render_callback' => 'mb_get_termine_widget',
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_termine_widget($attr, $content) {
		$termine = get_posts(array(
            'post_type' => 'termin',
            'post_status' => 'publish',
            'numberposts' => '-1',
        ));
        $heute = time();
        foreach($termine as $key => $termin){ // Ältere termine rausfiltern
            $startdatum = strtotime(get_post_meta($termin->ID, 'mbgi-meta-termin-startdatum', true));
            if($startdatum < $heute){
                unset($termine[$key]);
            }
        }
        usort($termine, "mb_sort_by_startdatum"); // termine nach startdatum sortieren
    
        $termine = array_slice($termine, 0, 5, true); // nur die 5 nächsten ausgeben

        $output = "<div class='mbgi-widget-termine-wrap'><h2>Termine</h2>";
    
        foreach($termine as $key => $termin){ //Struktur eines Termins in der sidebar
            $id = $termin->ID;
            $title = $termin->post_title;
            $startdatum = strtotime(get_post_meta($id, 'mbgi-meta-termin-startdatum', true));
            $enddatum = strtotime(get_post_meta($id, 'mbgi-meta-termin-enddatum', true));
            $ort = "";
            if(get_post_meta($id, 'mbgi-meta-termin-online-checkbox', true) == 'on'){
                $ort = ", Online";
            }else{
	            $ort = get_post_meta($id, 'mbgi-meta-termin-stadt', true);
                $ort = (isset($ort) && !empty($ort) ) ? ", $ort" : "";                
            }
            
            $output .= "<div class='mbgi-widget-termin-container'>";
                $output .= "<a href='" . get_permalink($id) . "'>";
                $output .= "<div class='mbgi-widget-termin mbgi-widget-termin-$id'>";
                    $output .= "<span class='mbgi-widget-termin-titel'>$title</span>";
                    if ($startdatum === $enddatum) { //ganztägige Termine
                        $output .= "<p class='mbgi-widget-termin-datum'>" . date_i18n(get_option('date_format'), $startdatum) . "</p>"; 
                        $output .= "<p class='mbgi-widget-termin-ort'>ganztags$ort</p>";
                    } elseif ($startdatum + 86400 > $enddatum) { //eintägige Termine bis zu 24h
                        $output .= "<p class='mbgi-widget-termin-datum'>" . date_i18n(get_option('date_format'), $startdatum) . "</p>";
                        $output .= "<p class='mbgi-widget-termin-ort'>" . date_i18n(get_option('time_format'), $startdatum) . " - " . date_i18n(get_option('time_format'), $enddatum) . " Uhr$ort</p>";
                    } else { //mehrtägige Termine
                        $output .= "<p class='mbgi-widget-termin-datum'>" . date_i18n(get_option('date_format'), $startdatum) . " - " . date_i18n(get_option('date_format'), $enddatum) . "</p>"; 
                        $output .= "<p class='mbgi-widget-termin-ort'>ganztags$ort</p>";
                    }
                $output .= "</div>";
                $output .= "</a>";
            $output .= "</div>";
        }
			
        $output .= "</div>";
		$output .= "<a class='mbgi-widget-termin-alle-termine' href='" . get_post_type_archive_link("termin") . "'>Alle Termine anzeigen</a>";
        
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
/*
	function mb_enqueue_widget_termine_style() {
		wp_enqueue_style('termine-widget-css', get_template_directory_uri() . '/blocks/mbgi-termine.css');
	}
	add_action('init', 'mb_enqueue_widget_termine_style');
*/