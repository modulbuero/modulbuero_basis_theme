<?php

	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function(){
		/* Vorbereiten der Posttypes für die Auswahl in den Blockeinstellungen */
		$custom_post_types = get_post_types(array('_builtin' => false, 'show_ui' => true));
		$taxonomies = get_categories();
		$tagsObj = get_tags();
		$categories = array();
		$tags = array();
		$post_types = array(
			array( //posts sind immer dabei
				'label' => 'Beiträge',
				'value' => 'post',),
		);

		// Array aufbauen für JS
		foreach($custom_post_types as $key => $value) { // für die post types
			if($value == "slider" || $value == "themen" || $value == "termin" || $value == "mbgi-tabs") continue;

			$post_types[] = array('label' => ucfirst($value), 'value' => $value, 'disabled' => false);
		}
		foreach($taxonomies as $key => $value) { // für die kategorien
			array_push($categories, array('label' => ucfirst($value->name), 'value' => $value->slug));
		}
		foreach($tagsObj as $key => $value) { // für die schlagwörter
			array_push($tags, array('label' => ucfirst($value->name), 'value' => $value->slug));
		}

		$json = array(  // die zu übergebene json
			$post_types,
			$categories,
			$tags,
		);

	    wp_register_script(
	        'mbgi-post-loop', //name
	        get_template_directory_uri() . '/blocks/mbgi-post-loop.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-post-loop.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
		wp_localize_script(
			'mbgi-post-loop', 		//name
			'mbgi_post_loop_vars', 	//object_name
			$json //übergebene daten
		);
		wp_localize_script('mbgi-post-loop', 'postTypes', $post_types);
		wp_enqueue_script('mbgi-post-loop');
	    
	    register_block_type('modulbuero/post-loop', [
			'editor_script' => 'mbgi-post-loop',
			'render_callback' => 'mbgi_get_post_loop_block',
			'attributes' => [
				'post_type' => [
					'type' => 'string',
					"default" => "post",
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
	function mbgi_get_post_loop_block($attr, $content) {
		$post_type 	= (isset($attr['post_type']))?$attr['post_type']:"";
		$categories = (isset($attr["category"]))?$attr['category']:"";
		$tags 		= (isset($attr["tags"]))?$attr["tags"]:"";
		$taxArray 	= mbgi_build_tax_array($categories, $tags); // erstellt die taxquery
		$result 	= "";

		$page 	= !empty( $_GET["mbgi-kachel-page"]) ? (int) $_GET["mbgi-kachel-page"] : 1; // aktuelle seite
		$args = array(
			'post_type'	=> $post_type,
			"posts_per_page" => $attr["numberposts"],
			'tax_query' => $taxArray,
			'post_status' => 'publish',
			'orderby' => 'publish_date', 
			'order' => 'DESC',
			'paged' => $page,
		);
		$posts = new WP_Query($args);
		$result .= "<div class='mbgi-block mbgi-block-post-loop'>";
		$result .= "<div class='post-loop-single-wrap'>";
		if (isset($posts)):
            while( $posts->have_posts()): $posts->the_post();
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
		$result .= 	"<div class='pagination-wrap'>";
		$result .= 		"<div class='pagination'>";
		$result .=			mb_kachel_paginierung($posts, $args);
		$result .= 		"</div>";
		$result .= 		"<div class='more'>";
							$moreLink = get_post_type_archive_link($attr["post_type"]);
		$result .= 			"<a class='more-link' href='$moreLink'>Alle ".mbgi_kachel_posttype2string($attr["post_type"])." anzeigen</a>";
		$result .= 		"</div>";
		$result .= 	"</div>";
		$result .= "</div>";
		return $result;
	}
	
	function mbgi_build_tax_array($categories, $tags){ // zur erstellung der taxquery
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
	function mbgi_enqueue_block_post_loop_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('post-loop-block-css', get_template_directory_uri() . '/blocks/mbgi-post-loop.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mbgi_enqueue_block_post_loop_style');


	function mb_kachel_paginierung($posts){
		$totalPages = $posts->max_num_pages; // anzahl seiten
		$page 	= !empty( $_GET["mbgi-kachel-page"]) ? (int) $_GET["mbgi-kachel-page"] : 1; // aktuelle seite
		$page 	= max($page,1); // erste seite wenn page <= 0
		$page 	= min($page, $totalPages); // letzte seite wenn seitenzahl > gesamtseitenanzahl
		$link 	= get_the_permalink();
		if(!is_admin()) $link .= "?mbgi-kachel-page=%d";
		
		$result = "";
		if($totalPages > 1):
			$result .= "<nav class='block-aktuelles-nav'>"; // Navigationsleiste wo die seitenzahlen stehen mit entsprechenden links
				$result .= "<div class='nav-links'>"; //seiten links wrap
					if($page > 1){  // zeige den pfeil nach links und letzte seite ab seite 2
						$result .= sprintf("<a class='page-numbers page-first arrow' href='$link'><i class='fas fa-chevron-left'></i></a>", 1); // verlinkt auf die erste seite
						$result .= sprintf("<a class='page-numbers page-before' href='$link'>".($page-1)."</a>", $page-1); // verlinkt auf die vorige seite
					}

					$result .= "<span class='page-numbers current-page'>$page</span>"; // aktuelle seite nicht als link

					if($page < $totalPages){ // zeigt den pfeil nach rechts und nächste seite wenn nicht letzte seite angezeigt wird 
						$result .= sprintf("<a class='page-numbers page-after' href='$link'>".($page+1)."</a>", $page+1); // verlinkt auf die nächste seite
						$result .= sprintf("<a class='page-numbers page-last arrow' href='$link'><i class='fas fa-chevron-right'></i></a>", $totalPages); // verlinkt auf die letzte seite
					}
				$result .= "</div><!-- nav-links -->";
			$result .= "</nav>";
			endif;
		return $result;
	}

	function mbgi_kachel_posttype2string($posttype){
		switch($posttype){
			case 'antraege':
				return 'Anträge';
				break;
			case 'parlament':
				return 'parlamentarische Initiativen';
				break;
			case 'presse':
				return 'Pressemitteilungen';
				break;
			case 'medien':
				return 'Medien';
				break;
			case 'video':
				return 'Videos';
				break;
			case 'reden':
				return 'Reden';
				break;
			case 'post':
				return 'Beiträge';
				break;
			default:
				return 'Beiträge';
				break;
		}
	}