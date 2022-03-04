<?php
	// Metafeld für Copyright Thumbnail
	function mb_add_thumbnail_caption() {
		add_meta_box(
			'mbgi-thumbnail-copyright', // Unique ID
			'Beitragsbild Copyright', // Box title
			'mb_thumbnail_copyright_html', // Content callback, must be of type callable
			array('post','presse','page', 'termin','reden','video','themen','antraege','abgeordnete','parlament'),
			'side');
	}
	add_action( 'add_meta_boxes', 'mb_add_thumbnail_caption' );
		
		
	
	/* Ausgabe der Metabox im Post Type Thumbnail */
	function mb_thumbnail_copyright_html( $post ) {
		?>
		
    	<div class="mbgi-thumbnail-copyright-meta-box">
	        <label for="mbgi-meta-thumbnail-copyright-startdatum">Name des Fotografs</label>
	        <input
	        	id="mbgi-thumbnail-copyright"
				class="mbgi-input"
				type="text"
				name="mbgi-thumbnail-copyright"
				value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'mbgi-thumbnail-copyright', true)); ?>">
	    </div>
	<?php
	}
	
	
	/* Metabox-Fields als Meta-Felder in copyright abspeichern wenn man den Post sichert */
	function mb_save_thumbnail_copyright( $post_id ) {
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	    	if ( $parent_id = wp_is_post_revision( $post_id ) ) {
				$post_id = $parent_id;
		    }
		    $fields = [
		        'mbgi-thumbnail-copyright',
		    ];
		    foreach ( $fields as $field ) {
		        if ( array_key_exists( $field, $_POST ) ) {
		            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
		        }
		    }
	}
	add_action( 'save_post', 'mb_save_thumbnail_copyright' );