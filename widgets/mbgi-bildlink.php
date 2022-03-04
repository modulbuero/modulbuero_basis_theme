<?php
	
	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function() {
		wp_register_script(
	        'mbgi-bildlink', //name
	        get_template_directory_uri() . '/widgets/mbgi-bildlink.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/widgets/mbgi-bildlink.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/bildlink', [
			'editor_script' => 'mbgi-bildlink',
			'render_callback' => 'mb_get_bildlink_widget',
			'attributes' => [
				'link' => [
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
	function mb_get_bildlink_widget($attr, $content) {
		
		$output = "<div class='mbgi-bild-link-widget'>";
            $output .= "<a href='" . $attr['link'] . "' target='_blank' style='background-image: url(" . $attr['bildUrl'] . ");'></a>";
		$output .= "</div>";
		
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	// function mb_enqueue_widget_statement_style() {
	// 	wp_enqueue_style('statement-widget-css', get_template_directory_uri() . '/widgets/mbgi-statement.css');
	// }
	// add_action('init', 'mb_enqueue_widget_statement_style');