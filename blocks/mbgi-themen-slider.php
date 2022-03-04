<?php
	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function(){
	    wp_enqueue_script(
	        'mbgi-themen-slider',
	        get_template_directory_uri() . '/blocks/mbgi-themen-slider.js',
	        array('mbgi-block-lib','jquery'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-themen-slider.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
	    
	    register_block_type('modulbuero/themen-slider', [
			'editor_script'	  => 'mbgi-themen-slider',
			'render_callback' => 'mb_get_themen_slider_block',
			'attributes' 	  => []
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_themen_slider_block($attr, $content) {
		$result="";
		$posts = get_posts(array(
			'post_type' => 'themen',
			'number_posts' => -1,
		));
		if(!isset($attr['interval'])){
			$attr['interval'] = 5000;
		}
		if(!empty($posts)){
			$result = "<div class='mbgi-block mbgi-block-themen-slider'>";
			$result .= "<h2 class='block-title'>Unsere Themen</h2>";
		    $result .= "<div class='block-themen-slider-wrap'>";
			$result .= "<div class='slideshow'>";
			foreach ($posts as $post) {
				if(!empty(get_the_post_thumbnail_url($post->ID))){
	                add_filter('excerpt_length','mb_excerpt_length_themen');
	            }
				$url 		= esc_url(get_the_post_thumbnail_url($post->ID, 'full'));
				$bfImgClass = '';
				if (empty($url)) {
					$url = get_bloginfo('template_url') . '/images/sonnenblume-anschnitt.svg';
					$bfImgClass = 'platzhalterSonnenblume';
				}
				$title 		= get_the_title( $post->ID );
				$excerpt 	= mb_cut_excerpt(get_the_excerpt( $post->ID ));
				$excerpt 	= mb_cut_excerpt($excerpt, 250);
				$link 		= get_permalink($post);
				$result .= "<a href='$link'>";
				$result .=  "<div class='thema-post-wrap'>";
				$result .= 	 "<div class='post-thumbnail-wrap'><div class='post-thumbnail ".$bfImgClass."' style='background-image: url($url);'></div></div>";
				$result .= 	 	"<h3 class='post-title'>$title</h3>";
				$result .= 		"<p class='post-excerpt'>$excerpt</p>";	
				$result .=   	"<span class='mbgi-themen-button'>weiterlesen</span>";
				$result .=  "</div>";
				$result .= "</a>";
				remove_filter('excerpt_length','mb_excerpt_length_themen');
			}
			$result .= "</div>";
			$result .= "</div>";
			$result .= "</div>";
		}
		return $result;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_themen_slider_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('themen-slider-block-css', get_template_directory_uri() . '/blocks/mbgi-themen-slider.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mb_enqueue_block_themen_slider_style');

	add_action('wp_enqueue_scripts', function(){
		wp_enqueue_script('mbgi-themen-slider-block-scripts', get_template_directory_uri() . '/blocks/mbgi-themen-slider-scripts.js', array('jquery','mbgi-themen-slider'));
	});