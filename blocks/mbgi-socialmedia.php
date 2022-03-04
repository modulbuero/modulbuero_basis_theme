<?php
	add_action('init', function() {
		wp_register_script(
	        'mbgi-socialmedia', //name
	        get_template_directory_uri() . '/blocks/mbgi-socialmedia.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-socialmedia.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/socialmedia', [
			'editor_script' => 'mbgi-socialmedia',
			'render_callback' => 'mb_get_socialmedia_block',
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_socialmedia_block($attr, $content) {
		
		$output = 	"<div class='mbgi-block mbgi-block-socialmedia'>";
		$output .= 		"<div class='socialmedia-wrap'>";
		//facebook
		if (!empty(get_option('mb_sozial_media_facebook'))){
			$output .= 			"<a class='facebook' href='" . get_option('mb_sozial_media_facebook') ."' target='_blank'><i class='fab fa-facebook-f'></i></a>";
		}
		//twitter
		if (!empty(get_option('mb_sozial_media_twitter'))){
			$output .= 			"<a class='twitter' href='" . get_option('mb_sozial_media_twitter') . "' target='_blank'><i class='fab fa-twitter'></i></a>";
		}
		//instagram
		if (!empty(get_option('mb_sozial_media_instagram'))){
			$output .= 			"<a class='instagram' href='" . get_option('mb_sozial_media_instagram') . "' target='_blank'><i class='fab fa-instagram'></i></a>";
		}
		//youtube
		if (!empty(get_option('mb_sozial_media_youtube'))){
			$output .= 			"<a class='youtube' href='" . get_option('mb_sozial_media_youtube') . "' target='_blank'><i class='fab fa-youtube'></i></a>";
		}
		$output .= 		"</div>";
		$output .= 	"</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_socialmedia_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('socialmedia-block', get_template_directory_uri() . '/blocks/mbgi-socialmedia.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mb_enqueue_block_socialmedia_style');