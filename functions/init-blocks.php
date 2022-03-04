<?php
	/* erstellt eine neue block kategorie namens modulbuero */
	add_filter( 'block_categories_all', function($categories){
	    $modulbuero_category = array (
			'slug' => 'modulbuero',
			'title' => 'modulbuero',
		);
		array_unshift($categories, $modulbuero_category); //fuege neue kategorie als erstes ein, damit sie oben angezeigt wird
		return $categories;
	}, 10, 2 );
	
	/* enqueuet die mbgi-block-lib.js, von der alle blocks abhängen */
	add_action('init', function() {
		wp_enqueue_script(
			'mbgi-block-lib',
			get_template_directory_uri() . '/blocks/mbgi-block-lib.js',
			array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element', 'wp-block-editor', 'wp-data')
		);
	});
	
	/* styles und scripts enqueues für den block editor */
	add_action('enqueue_block_editor_assets', function() {
		wp_enqueue_style( 'fontawesome-gutenberg', get_template_directory_uri() .'/fonts/fontawesome-free-5.15.3-web/css/all.css');
	});
	
	/**
	 *  $theme_directory kommt aus der functions.php
	 *  alle blöcke laden
	 */
	global $pagenow;
	if ($pagenow !== "widgets.php") {
		if(has_template_parts("/blocks/")){
			get_template_parts("/blocks/");
		}
	}