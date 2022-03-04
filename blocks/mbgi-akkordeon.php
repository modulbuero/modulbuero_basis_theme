<?php
	add_action('init', function() {
		wp_register_script(
	        'mbgi-akkordeon', //name
	        get_template_directory_uri() . '/blocks/mbgi-akkordeon.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-akkordeon.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/akkordeon', [
			'editor_script' => 'mbgi-akkordeon',
			'render_callback' => 'mb_get_akkordeon_block',
			'attributes' => [
				'title' => [
					'type' => 'string',
					'default' => 'Akkordeon-Titel.',
				],
				'description' => [
					'type' => 'string',
					'default' => 'Akkordeon-Text. <br> Titel und Text können in der rechten Leiste unter Block -> Einstellungen geändert werden.',
				],
			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_akkordeon_block($attr, $content) {
		$output = 	"<div class='mbgi-block mbgi-block-akkordeon'>";
		$output .= 		"<div class='akkordeon-wrap'>";
		$output .= 			"<h2 class='title'>".$attr['title']."</h2>";
		$output .= 			"<p class='text'>". nl2br($attr['description'])."</p>";
		$output .= 		"</div>";
		$output .= 	"</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_akkordeon_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('akkordeon-block-css', get_template_directory_uri() . '/blocks/mbgi-akkordeon.css', array('mbgi-main-style'), $version);
        wp_enqueue_script('akkordeon-block-scripts', get_template_directory_uri() . '/blocks/mbgi-akkordeon-scripts.js', array("jquery"),$version);
	}
	add_action('init', 'mb_enqueue_block_akkordeon_style');