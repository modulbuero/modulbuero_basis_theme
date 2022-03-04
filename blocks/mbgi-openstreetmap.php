<?php
	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function(){
	    wp_register_script(
	        'mbgi-openstreetmap', //name
	        get_template_directory_uri() . '/blocks/mbgi-openstreetmap.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-openstreetmap.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
	    
	    register_block_type('modulbuero/openstreetmap', [
			'editor_script' => 'mbgi-openstreetmap',
			'render_callback' => 'mb_get_openstreetmap_block',
			'attributes' => [
				'street' => [
					'type' => 'string',
					'default' => '',
				],
				'postalcode' => [
					'type' => 'string',
					'default' => '',
				],
				'city' => [
					'type' => 'string',
					'default' => '',
				],
				'country' => [
					'type' => 'string',
					'default' => 'de',
				],
			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_openstreetmap_block($attr, $content) {
		$street = $attr['street'];
		$postalcode = $attr['postalcode'];
		$city = $attr['city'];
		$country = $attr['country'];
		
		$output = "<div id='mbgi-openstreetmap-wrap'>";
			$output .= "<div id='mbgi-openstreetmap-overlay'>";
				$output .= "<i class='fas fa-map-marker mbgi-openstreetmap-marker'></i>";
				$output .= "<p class='mbgi-openstreetmap-anzeigen'>Veranstaltungsort als Karte anzeigen?</p>";
				$output .= "<p class='mbgi-openstreetmap-datenschutz'>Mit Klick auf den Button werden Daten von openstreetmap.org geladen.<br>Es gelten deren <a href='https://wiki.openstreetmap.org/wiki/DE:Datenschutz'>Datenschutzrichtlinien</a>.</p>";
				$output .= "<button id='mbgi-openstreetmap-button' class='mbgi-button' data-street='$street' data-postalcode='$postalcode' data-city='$city' data-country='$country' type='button'>Kartendaten laden</button>";
				//Checkbox für Cookie, damit man nicht immer den Button drücken muss
/*
				$output .= "<div id='mbgi-openstreetmap-checkbox-wrap'>";
					$output .= "<input type='checkbox' id='mbgi-openstreetmap-checkbox' name='mbgi-openstreetmap-checkbox'>";
					$output .= "<label for='mbgi-openstreetmap-checkbox'>Karten immer sofort laden</label>";
				$output .= "</div>";
*/
			$output .= "</div>";
		$output .= "</div>";
		
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_openstreetmap_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('mbgi-openstreetmap', get_template_directory_uri() . '/blocks/mbgi-openstreetmap.css', array('mbgi-main-style'), $version);
		wp_enqueue_script('mbgi-openstreetmap-scripts',get_template_directory_uri() . '/blocks/mbgi-openstreetmap-scripts.js', array('jquery', 'leaflet'));
	}
	add_action('init', 'mb_enqueue_block_openstreetmap_style');