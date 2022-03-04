<?php
/**
 *
 *  "Einleitung" wurde umbenannt in "Grüner Absatz"
 *  Dir Klassen und Variablen heißen hier noch ..einleitung Im Editor ist der Block aber under "Grüner Absatz" zu finden
 *  20210920@bvd
 *
 */

	add_action('init', function() {
		wp_register_script(
	        'mbgi-einleitung', //name
	        get_template_directory_uri() . '/blocks/mbgi-einleitung.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-einleitung.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/einleitung', [
			'editor_script' => 'mbgi-einleitung',
			'render_callback' => 'mb_get_einleitung_block',
			'attributes' => [
				'text' => [
					'type' => 'string',
					'default' => 'Sie können den Text in der rechten Leiste unter Block -> Einstellungen ändern.',
				],
			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_einleitung_block($attr, $content) {
		$output = 	"<div class='mbgi-block mbgi-block-einleitung'>";
		$output .= 		"<div class='einleitung-wrap'>";
		$output .= 			"<p class='einleitung'>". nl2br($attr['text'])."</p>";
		$output .= 		"</div>";
		$output .= 	"</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_einleitung_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('einleitung-block-css', get_template_directory_uri() . '/blocks/mbgi-einleitung.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mb_enqueue_block_einleitung_style');