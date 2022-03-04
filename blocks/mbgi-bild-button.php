<?php
	add_action('init', function() {
		wp_register_script(
	        'mbgi-bild-button', //name
	        get_template_directory_uri() . '/blocks/mbgi-bild-button.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-bild-button.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/bild-button', [
			'editor_script' => 'mbgi-bild-button',
			'render_callback' => 'mb_get_bild_button_block',
			'attributes' => [
				'buttonLabel' => [
					'type' => 'string',
					'default' => 'Klick mich',
				],
				'buttonLink' => [
					'type' => 'string',
	                'default' => '#',
				],
				'bildId' => [
					'type' => 'number',
					'default' => 0,
				],
				'bildUrl' => [
					'type' => 'string',
					'default' => '/blocks/mbgi-teaserbox-bild.png',
				],
			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_bild_button_block($attr, $content) {
		$path = get_template_directory_uri();
		$output = 	"<div class='mbgi-block mbgi-block-bild-button'>";
		$output .= 		"<div class='mbgi-block-bild-button-wrap'>";
		$output .= 			"<div class='mbgi-block-bild-button-bild' style='background-image: url(".$attr['bildUrl'].")'></div>";
		$output .= 			"<a href='" . $attr['buttonLink'] . "' class='mbgi-block-bild-button-button mbgi-button'>" . $attr['buttonLabel'] . "</a>";
		$output .= 		"</div>";
		$output .= 	"</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_bild_button_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('bild-button-block-css', get_template_directory_uri() . '/blocks/mbgi-bild-button.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mb_enqueue_block_bild_button_style');