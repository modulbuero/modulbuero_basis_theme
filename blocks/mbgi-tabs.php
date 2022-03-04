<?php
$optionName = 'mbgi_enable_post_types_activate_tabs';

if(get_option($optionName) == "on"){
	add_action('init', function() {
		
		wp_register_script(
	        'mbgi-tabs', //name
	        get_template_directory_uri() . '/blocks/mbgi-tabs.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-tabs.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/tabs', [
			'editor_script' => 'mbgi-tabs',
			'render_callback' => 'mb_get_tabs_block',
			'attributes' => [
				'style' => [
					'type' => 'string',
					'default' => "default",
				],
				'category' => [
					'type' => 'array',
					'default' => array(),
				],
			]
		]);

		$categories = array();
		$taxonomies = get_terms( 'gruppe', array(
			'hide_empty' => true,
			'orderby' => "name",
			"order" => "DESC",
		) );

		foreach($taxonomies as $key => $value) { // für die kategorien
			array_push($categories, array('label' => ucfirst($value->name).' ('.$value->count.')', 'value' => $value->slug));
		}

		$json = $categories;
		wp_localize_script("mbgi-tabs", "mbgiTabs_posts", $json );

		wp_enqueue_script('mbgi-tabs');

	}, 100);

	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_tabs_block($attr, $content) {
		$posts = get_posts(array(
			"post_type" => "tabs",
			"numberposts" => -1,
			'tax_query' =>[
				'taxonomy' => 'gruppe',
				'field' => "slug",
				'terms' => $attr['category'],
			],
			'order' => 'ASC',
			'orderby' => 'meta_value_num',
			'meta_query' => array(
				array('key' => 'mbgi-tabs-prio'))
		));
		$first = "active";
		$output = 	$attr["category"][0]."<div class='mbgi-block mbgi-block-tabs'>";
		$output .= 		"<div class='tabs-navbar'>";
		foreach($posts as $post){
			$output .= 		"<div class='tab-header $first' data-id='$post->ID'><p>$post->post_title</p></div>";
			$first = "";
		}
		$output .= 		"</div>";
		$output .= 		"<div class='tabs-content'>";
		$first = "active";
		foreach($posts as $post){
			$output .= 		"<div class='tab $first' data-id='$post->ID'>";
			$output .= 			apply_filters( 'the_content', $post->post_content);
			$output .= 		"</div>";
			$first = "";
		}
		$output .= 		"</div>";
		$output .= 	"</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_tabs_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('tabs-block-css', get_template_directory_uri() . '/blocks/mbgi-tabs.css', array(), $version);
		wp_enqueue_script(
	        'mbgi-tabs-script',
			get_template_directory_uri() . '/blocks/mbgi-tabs-script.js', 
			array('jquery'), 
			$version
		);
	
	}
	add_action('init', 'mb_enqueue_block_tabs_style');
	add_action('admin_enqueue_scripts', 'mb_enqueue_block_tabs_style');



	// Metafeld für Tabs
	function mb_register_tabs_meta() {
		add_meta_box('mbgi-tabs-meta-box', 'Block-Reihenfolge', 'mb_tabs_callback', 'mbgi-tabs', 'side','high' );
	}
	add_action('add_meta_boxes', 'mb_register_tabs_meta');

	function mb_tabs_callback($post) {
		?>
		
		<div class='mbgi-tabs-meta-box'>
			<p>
				<input
					id='mbgi-tabs-prio'
					type='number'
					name='mbgi-tabs-prio'
					value=<?php echo esc_attr(get_post_meta(get_the_ID(), 'mbgi-tabs-prio', 50)); ?>
				>
				<label for="mbgi-tabs-prio">Niedrigere Werte werden früher angezeigt</label>
			</p>
		</div>
		
		<?php
	}

	function mb_save_tabs_meta_box( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( $parent_id = wp_is_post_revision( $post_id ) ) {
				$post_id = $parent_id;
			}
			$fields = [
				'mbgi-tabs-prio',
			];
			foreach ( $fields as $field ) {
				update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
			}
	}
	add_action( 'save_post', 'mb_save_tabs_meta_box' );

}