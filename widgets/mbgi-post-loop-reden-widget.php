<?php

	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function(){
		$taxonomies = get_categories();
		$categories = array();
		foreach($taxonomies as $key => $value) { // für die kategorien
			array_push($categories, array('label' => ucfirst($value->name), 'value' => $value->slug));
		}

	    wp_register_script(
	        'mbgi-post-loop-reden', //name
	        get_template_directory_uri() . '/widgets/mbgi-post-loop-reden-widget.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/widgets/mbgi-post-loop-reden-widget.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
		wp_localize_script(
			'mbgi-post-loop-reden', //name
			'redenCategories', //object_name
			$categories //übergebene daten
		);
		wp_enqueue_script('mbgi-post-loop-reden');
	    
	    register_block_type('modulbuero/reden-widget', [
			'editor_script' => 'mbgi-reden-widget',
			'render_callback' => 'mbgi_get_post_loop_reden_block',
			'attributes' => [
				'category' => [
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
	function mbgi_get_post_loop_reden_block($attr, $content) {
		$categories = (isset($attr["category"]))?$attr['category']:null;
		$result 	= "";
		$args = array(
			'post_type'	=> 'reden',
			"posts_per_page" => $attr["numberposts"],
			'post_status' => 'publish', 
			'orderby' => 'publish_date', 
			'order' => 'DESC',
		);
		$args['tax_query'] = $categories == null ? 
			null : array(array('taxonomy' => 'category', 'field' => 'slug', 'terms' => $categories,));

		$loop = new WP_Query($args);
		$result .= "<h2>Reden</h2>";
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