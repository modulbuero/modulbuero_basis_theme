<?php
	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function(){
	    wp_enqueue_script(
	        'mbgi-slider', //name
	        get_template_directory_uri() . '/blocks/mbgi-slider.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-slider.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
	    
	    register_block_type('modulbuero/slider', [
			'editor_script' => 'mbgi-slider',
			'render_callback' => 'mb_get_slider_block',
			'attributes' => [
				'interval' => [
					'type' => 'string',
					'default' => '5000',
				],
/*
				'title' => [
					'type' => 'boolean',
				]
*/
			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_slider_block($attr, $content) {
		$posts = get_posts(array(
			'post_type' => 'slider',
		));
		if(!isset($attr['interval'])){
			$attr['interval'] = 5000;
		}

		$class = '';
/*	
		if(isset($attr['title']) && $attr['title']){
			$class = ' title-on';
		}
*/
	
		$result = "<div class='mbgi-block mbgi-block-slider' data-interval='".$attr['interval']."'>";
	    $result .= "<div class='block-slider-wrap'>";
		foreach ($posts as $post) {
			if (null !== get_post_meta($post->ID, 'mbgi-slider-checkbox-meta-box', true) && get_post_meta($post->ID, 'mbgi-slider-checkbox-meta-box', true) == "on") {
				$class = 'title-on';
			} else {
				$class = '';
			}
			$url = esc_url(get_the_post_thumbnail_url($post->ID, 'full'));
			$result .="<div class='$class $post->ID' style='background-image: url($url);'>";
// 			if(isset($attr['title']) && $attr['title']){
			if (null !== get_post_meta($post->ID, 'mbgi-slider-checkbox-meta-box', true) && get_post_meta($post->ID, 'mbgi-slider-checkbox-meta-box', true) == "on") {
				$link = get_post_meta($post->ID, 'mbgi-slider-link', true);
				if (isset($link) && !empty($link)){
					$https = "https://";
					if(strpos($link, $https) !== false){
						$link = $link;
					}else{
						$link = "https://".$link;
					}
					$result.= "<a href='$link' target='_blank'><h3 class='title slider-has-link'>" . get_the_title($post) . "</h3></a>";
				}else{
					$result .= "<h3 class='title'>" . get_the_title($post) . "</h3>";
				}
			}
			$result .= "</div>";
			
		}
		$result .= "</div>";
		$result .= "</div>";
	
		return $result;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_slider_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('slider-block-css', get_template_directory_uri() . '/blocks/mbgi-slider.css', array(), $version);
		wp_enqueue_script('slider-block-scripts',get_template_directory_uri() . '/blocks/mbgi-slider-scripts.js', array('jquery'));

	}
	add_action('init', 'mb_enqueue_block_slider_style');