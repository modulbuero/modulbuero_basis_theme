<?php
	add_action('init', function() {
		wp_register_script(
	        'mbgi-teaserbox', //name
	        get_template_directory_uri() . '/blocks/mbgi-teaserbox.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-teaserbox.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/teaserbox', [
			'editor_script' => 'mbgi-teaserbox',
			'render_callback' => 'mb_get_teaserbox_block',
			'attributes' => [
				'title' => [
					'type' => 'string',
					'default' => 'Teaserbox',
				],
				'description' => [
					'type' => 'string',
					'default' => 'Ein Teaser ist in Werbung und Journalismus ein kurzes Text- oder Bildelement, das zum Weiterlesen, -hören, -sehen, -klicken verleiten soll. Es steht häufig auf der Frontseite bzw. ersten Seite eines Mediums und weist dort auf den eigentlichen Beitrag hin.',
				],
				'buttonLabel' => [
					'type' => 'string',
					'default' => 'Weiterlesen',
				],
				'buttonLink' => [
					'type' => 'string',
	                'default' => 'https://de.wikipedia.org/wiki/Teaser',
				],
				'bildId' => [
					'type' => 'number',
					'default' => 0,
				],
				'bildUrl' => [
					'type' => 'string',
					'default' => 'teaser-mops.jpg',
				],
			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_teaserbox_block($attr, $content) {
		$path 	= get_template_directory_uri();
		$output = 	"<div class='mbgi-block mbgi-block-teaserbox'>";
		$output .= 		"<div class='teaserbox-wrap'>";
		$output .= 			"<a href='".$attr['buttonLink']."' class='teaserbox-bild'>";
		$output .= 				"<div class='teaserbox-bild-inner' style='background-image: url(".$attr['bildUrl'].")'></div></a>";
		$output .= 			"<div class='teaserbox-text'>";
		$output .= 				"<h2 class='title'>".$attr['title']."</h2>";
		$output .= 				"<p class='text'>". mb_cut_excerpt(nl2br($attr['description']), 280)."</p>";
		$output .= 				"<a href='".$attr['buttonLink']."'><span>".$attr['buttonLabel']."</span></a>";
		$output .= 			"</div>";
		$output .= 		"</div>";
		$output .= 	"</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_teaserbox_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('teaserbox-block-css', get_template_directory_uri() . '/blocks/mbgi-teaserbox.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mb_enqueue_block_teaserbox_style');