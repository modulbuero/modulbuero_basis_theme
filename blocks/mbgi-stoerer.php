<?php
	add_action('init', function() {
		wp_register_script(
	        'mbgi-stoerer', //name
	        get_template_directory_uri() . '/blocks/mbgi-stoerer.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-stoerer.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/stoerer', [
			'editor_script' => 'mbgi-stoerer',
			'render_callback' => 'mb_get_stoerer_block',
			'attributes' => [
				'title' => [
					'type' => 'string',
					'default' => 'Störer',
				],
				'description' => [
					'type' => 'string',
					'default' => 'Klick mich!',
				],
				'buttonLink' => [
					'type' => 'string',
	                'default' => 'https://de.wikipedia.org',
				],
			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_stoerer_block($attr, $content) {
		$output = 	"<div class='mbgi-block mbgi-block-stoerer'>";
		$output .= 		"<div class='stoerer-close'></div>";
		$output .= 		"<a href='".$attr['buttonLink']."' class='stoerer-link'>";
		$output .= 			"<div class='stoerer-text'>";
		$output .= 				"<h2 class='title'>".$attr['title']."</h2>";
		$output .= 				"<p class='text'>". mb_cut_excerpt(nl2br($attr['description']), 280)."</p>";
		$output .= 			"</div>";
		$output .= 		"</a>";
		$output .= 	"</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_stoerer_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('stoerer-block-css', get_template_directory_uri() . '/blocks/mbgi-stoerer.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mb_enqueue_block_stoerer_style');