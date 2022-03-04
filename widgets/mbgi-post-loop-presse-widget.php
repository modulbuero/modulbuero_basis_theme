<?php

	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function(){
		/* Vorbereiten der Posttypes für die Auswahl in den Blockeinstellungen */
		//$custom_post_types 	= get_post_types(array('_builtin' => false, 'show_ui' => true));
		$taxonomies 		= get_categories();
		//$tagsObj 			= get_tags();
		$categories = array();
		//$tags = array();
		$post_types = array(
			array( //posts sind immer dabei
				'label' => 'Aktuelles',
				'value' => 'post'),
		);

		// Array aufbauen für JS
		/*
		foreach($custom_post_types as $key => $value) { // für die post types
			array_push($post_types, array('label' => ucfirst($value), 'value' => $value));
		}
		*/
		foreach($taxonomies as $key => $value) { // für die kategorien
			array_push($categories, array('label' => ucfirst($value->name), 'value' => $value->slug));
		}
		/*
		foreach($tagsObj as $key => $value) { // für die schlagwörter
			array_push($tags, array('label' => ucfirst($value->name), 'value' => $value->slug));
		}
		*/

		$json = array(  // die zu übergebene json
			$post_types,
			$categories,
			//$tags,
		);
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
	    wp_register_script(
	        'mbgi-post-loop-presse', //name
	        get_template_directory_uri() . '/widgets/mbgi-post-loop-presse-widget.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/widgets/mbgi-post-loop-presse-widget.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
		wp_localize_script(
			'mbgi-post-loop', //name
			'mbgi_post_loop_vars', //object_name
			$json //übergebene daten
		);
		wp_enqueue_script('mbgi-post-loop-presse');
	    
	    register_block_type('modulbuero/presse-widget', [
			'editor_script' => 'mbgi-presse-widget',
			'render_callback' => 'mbgi_get_post_loop_presse_block',
			'attributes' => [
				'post_type' => [
					'type' => 'array',
					"default" => array("post"),
				],
				'category' => [
					'type' => 'array',
				],
				'tags' => [
					'type' => 'array',
				],
				'numberposts' => [
					'type' => 'integer',
					'default' => 3,
				],
			]
		]);
	}, 100); //muss NACH mbgi_unregister_posttypes passieren
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mbgi_get_post_loop_presse_block($attr, $content) {
		//$post_type 	= (isset($attr['post_type']))?$attr['post_type']:"";
		$categories = (isset($attr["category"]))?$attr['category']:null;
		$tags 		= (isset($attr["tags"]))?$attr["tags"]:null;
		$taxArray 	= mbgi_build_presse_tax_array($categories, $tags); // erstellt die taxquery
		$result 	= "";
		$args = array(
			'post_type'	=> 'presse',
			"posts_per_page" => $attr["numberposts"],
			'tax_query' => $taxArray,
			'post_status' => 'publish', 
			'orderby' => 'publish_date', 
			'order' => 'DESC',
		);
		$loop = new WP_Query($args);
		$result .= "<h2>Pressemitteilungen</h2>";
		$result .= "<div class='mbgi-block mbgi-widget-post'>";
		if ( $loop->have_posts() ):
            while( $loop->have_posts() ) : $loop->the_post();
				ob_start();
				get_template_part('templates/content-single-looped', get_post_type());
				$result .= ob_get_clean();
			
			endwhile;
			wp_reset_postdata();
		else :
			ob_start();
			get_template_part( 'templates/content-none');
			$result .= ob_get_clean();
		endif;
		$result .= "</div>";
		return $result;
	}
	
	function mbgi_build_presse_tax_array($categories, $tags){ // zur erstellung der taxquery
		// erstellen einen state um zu checken ob categories und/oder schlagwörter ausgewählt sind
		$state = empty($categories) ? "no-category" : "category";
		$state .= empty($tags) ? " no-tags" : " tags";
		switch($state){
			// weder categories noch schlagwörter ausgewählt
			case "no-category no-tags": return array();
			// nur schlagwörter
			case "no-category tags": return array(array('taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => $tags,));
			// nur kategorien
			case "category no-tags": return array(array('taxonomy' => 'category', 'field' => 'slug', 'terms' => $categories,));
			// sowohl schlagwörter als auch kategorien => diese sind OR verknüpft
			case "category tags": return array("relation" => "OR",
												array( 
													'taxonomy' => 'category', 
													'field' => 'slug', 
													'terms' => $categories,
												),
												array(
													'taxonomy' => 'post_tag', 
													'field' => 'slug', 
													'terms' => $tags,
												));
		}

		return array();
	}

	/* Enqueue Style für den Block-Editor */
	function mbgi_enqueue_block_post_loop_presse_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('post-loop-block-css', get_template_directory_uri() . '/blocks/mbgi-post-loop-widget.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mbgi_enqueue_block_post_loop_presse_style');