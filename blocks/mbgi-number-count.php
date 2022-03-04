<?php
	add_action('init', function() {
		wp_register_script(
	        'mbgi-number-count', //name
	        get_template_directory_uri() . '/blocks/mbgi-number-count.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-number-count.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/number-count', [
			'editor_script' => 'mbgi-number-count',
			'render_callback' => 'mb_get_number_count_block',
			'attributes' => [
				'title' => [
					'type' => 'string',
					'default' => 'Überschrift',
				],
				'description' => [
					'type' => 'string',
					'default' => 'Beschreibung',
				],
				'current' => [
					'type' => 'number',
					'default' => 0,
				],
				'goal' => [
					'type' => 'number',
					'default' => 100,
				],
				'einheit' => [
					'type' => 'string',
					'default' => '',
				],
			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_number_count_block($attr, $content) {
		$current = $attr["current"];
		$goal = $attr["goal"];
		$einheit = $attr["einheit"];

		$output = "";
		$output .= 	"<div class='mbgi-block mbgi-block-number-count'>";
		$output .= 		"<div class='number-count-wrap'>";
		$output .= 			"<h2 class='title'>".$attr['title']."</h2>";
		$output .= 			"<div class='counter-wrap'>";
		$output .= 				"<p class='current'>$current$einheit</p>";
		$output .= 				"<p class='goal'>$goal$einheit</p>";
		$output .= 			"</div>";
		$output .= 			"<p class='text'>". nl2br($attr['description'])."</p>";
		$output .= 		"</div>";
		$output .= 	"</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_number_count_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('number-count-block-css', get_template_directory_uri() . '/blocks/mbgi-number-count.css', array('mbgi-main-style'), $version);
    }
	add_action('init', 'mb_enqueue_block_number_count_style');