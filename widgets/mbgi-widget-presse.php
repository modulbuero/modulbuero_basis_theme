<?php
	add_action('init', function() {
		wp_register_script(
	        'mbgi-widget-presse', //name
	        get_template_directory_uri() . '/widgets/mbgi-widget-presse.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/widgets/mbgi-widget-presse.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/widget-presse', [
			'editor_script' => 'mbgi-widget-presse',
			'render_callback' => 'mb_get_presse_widget',
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_presse_widget($attr, $content) {
        $output = "";

		$presse = get_posts(array(
            'post_type' => 'termin',
            'post_status' => 'publish',
            'numberposts' => '-1',
        ));
        
        
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
/*
	function mb_enqueue_widget_presse_style() {
		wp_enqueue_style('presse-widget-css', get_template_directory_uri() . '/blocks/mbgi-presse.css');
	}
	add_action('init', 'mb_enqueue_widget_presse_style');
*/