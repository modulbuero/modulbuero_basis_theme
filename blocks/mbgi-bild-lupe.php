<?php
	add_action('init', function() {
		wp_register_script(
	        'mbgi-bild-lupe', //name
	        get_template_directory_uri() . '/blocks/mbgi-bild-lupe.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-bild-lupe.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/bild-lupe', [
			'editor_script' => 'mbgi-bild-lupe',
			'render_callback' => 'mb_get_bild_lupe_block',
			'attributes' => [
				'bildId' => [
					'type' => 'number',
					'default' => 0,
				],
				'size' => [
					'type' => 'string',
					'default' => "mbgi-thumb-568",
				],
			]
		]);
		global $_wp_additional_image_sizes;
		$json = array();
		array_push($json, array('label' => 150, 'value' => "thumbnail"));
		foreach( $_wp_additional_image_sizes as $key => $size){
			array_push($json, array('label' => $size["width"], 'value' => $key));
		}
		sort($json);
		array_push($json, array('label' => "Full", 'value' => "full"));

		wp_localize_script("mbgi-bild-lupe", "mbgiThumbnailSizes", $json );

		
		wp_enqueue_script('mbgi-bild-lupe');
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_bild_lupe_block($attr, $content) {
		$small = wp_get_attachment_image_src($attr["bildId"], $attr["size"]);
		$full = wp_get_attachment_image_src($attr["bildId"], "full");
		$output = 	"<div class='mbgi-block mbgi-block-bild-lupe centered'>";
		$output .= 		"<div class='wrap'>";
		$output .= 			"<img loading='lazy' src='".$small[0]."' width='".$small[1]."' height='".$small[2]."' alt='thumbnail' title='Klick auf die Lupe zum vergrößern' style='max-width:100%;' />";
		$output .= 			"<div class='lupe centered'><i class='fas fa-search'></i></div>";	
		$output .= 		"</div>";
		$output .= 		"<div class='lupe-lightbox centered'>";
		$output .= 			"<img loading='lazy' src='".$full[0]."' width='".$full[1]."' height='".$full[2]."' alt='Volle Groeße' title='Klick um zu schließen' style='max-width:100%;' />";
		$output .= 		"</div>";
		$output .= 	"</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_bild_lupe_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('bild-lupe-block-css', get_template_directory_uri() . '/blocks/mbgi-bild-lupe.css',array(), $version);
		wp_enqueue_script(
	        'mbgi-bild-lupe-script',
			get_template_directory_uri() . '/blocks/mbgi-bild-lupe-script.js', 
			array('jquery'), 
			$version
		);
	
	}
	add_action('init', 'mb_enqueue_block_bild_lupe_style');
	add_action('admin_enqueue_scripts', 'mb_enqueue_block_bild_lupe_style');