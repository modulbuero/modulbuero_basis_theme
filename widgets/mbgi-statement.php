<?php
	
	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function() {
		wp_register_script(
	        'mbgi-statement', //name
	        get_template_directory_uri() . '/widgets/mbgi-statement.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/widgets/mbgi-statement.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/statement', [
			'editor_script' => 'mbgi-statement',
			'render_callback' => 'mb_get_statement_widget',
			'attributes' => [
				'titel' => [
					'type' => 'string',
					'default' => ''
				],
				'beschreibung' => [
					'type' => 'string',
					'default' => ''
				],
				'bildId' => [
					'type' => 'number',
					'default' => 0
				],
				'bildUrl' => [
					'type' => 'string',
				],
			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Widget */
	function mb_get_statement_widget($attr, $content) {
		$bildUrl = (isset($attr['bildUrl']))?$attr['bildUrl']:"";
		$output = "<div class='mbgi-statement-widget'>";
			$output .= "<div class='statement-image' style='background-image: url(". $bildUrl .");'></div>";
            $output .= "<h3 class='statement-title'>" . $attr['titel'] . "</h3>";
            $output .= "<p class='statement-beschreibung'>" . nl2br($attr['beschreibung']) . "</p>";
		$output .= "</div>";
		
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	// function mb_enqueue_widget_statement_style() {
	// 	wp_enqueue_style('statement-widget-css', get_template_directory_uri() . '/widgets/mbgi-statement.css');
	// }
	// add_action('init', 'mb_enqueue_widget_statement_style');