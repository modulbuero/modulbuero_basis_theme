<?php
	
	/**
	*	Metafelde Uploads
	*/
	function mbgi_register_datei_meta_box() {
		add_meta_box( 'mbgi_antrag', 'Datei', 'mbgi_datei_callback', array('antraege','parlament') , 'normal','high' );
	}
	add_action( 'add_meta_boxes', 'mbgi_register_datei_meta_box' );
	
	/* Ausgabe der Metabox im Post Type Anträge */
	function mbgi_datei_callback( $post ) {
		wp_nonce_field($post->ID, 'mbgi_nonce_antraege_antrag');
		?>
		<div class="mgbi-meta-box-wrapper">
		    <p class="termine-meta-options mbgi-antraege-antrag">
		        <label for="mbgi-antraege-antrag-file">Antrag</label>
		        <input id="mbgi-antraege-antrag-file"
					class="mbgi-input"
					type="text"
					name="mbgi-antraege-antrag-file"
					value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'mbgi-antraege-antrag-file', true ) ); ?>">
		        <button class="upload_bild_button button button-primary">Datei hochladen</button>
		        
				<?php if(!empty(get_post_meta( get_the_ID(), 'mbgi-antraege-antrag-file', true ) )):?>	
					<span><?php echo get_post_meta( get_the_ID(), 'mbgi-antraege-antrag-file', true );?></span>
				<?php endif;?>
		    </p>
		    <p class="termine-meta-options mbgi-antraege-antrag-bezeichnung">
		        <label for="mbgi-antraege-antrag-bezeichnung">Bezeichnung</label>
		        <input id="mbgi-antraege-antrag-bezeichnung"
					class="mbgi-input"
					type="text"
					name="mbgi-antraege-antrag-bezeichnung"
					value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'mbgi-antraege-antrag-bezeichnung', true ) ); ?>">
		    </p>
	
		</div>
	<?php } 
	
	/* Metabox-Fields als Meta-Felder abspeichern wenn man den Post sichert */
	function mbgi_save_antraege_meta_box( $post_id ) {
		$post_type = get_post($post_id)->post_type;
		if($post_type != "antraege" && $post_type != "parlament") return $post_id;
		/* --- security verification --- */
		if (isset($_POST['mbgi_nonce_antraege_antrag'])) {
		    if(!wp_verify_nonce($_POST['mbgi_nonce_antraege_antrag'], $post_id)) {
		      return $post_id;
		    }
		}
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
	        $post_id = $parent_id;
	    }
	    $fields = [
	        'mbgi-antraege-antrag-file',
	        'mbgi-antraege-antrag-bezeichnung',
	    ];
	    foreach ( $fields as $field ) {
	        if ( array_key_exists( $field, $_POST ) ) {
	            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
	        }
	    }
	     
	    // Make sure the file array isn't empty
	    if(!empty($_FILES['mbgi-antraege-antrag-file']['name'])) {
		    $supported_types = array('application/pdf');
		    // Get the file type of the upload
	        $arr_file_type = wp_check_filetype(basename($_FILES['mbgi-antraege-antrag-file']['name']));
	        $uploaded_type = $arr_file_type['type'];
	        // Check if the type is supported. If not, throw an error.
	        if(in_array($uploaded_type, $supported_types)) {
	 
	            // Use the WordPress API to upload the file
	            $upload = wp_upload_bits($_FILES['mbgi-antraege-antrag-file']['name'], null, file_get_contents($_FILES['mbgi-antraege-antrag-file']['tmp_name']));
	     
	            if(isset($upload['error']) && $upload['error'] != 0) {
	                wp_die('Es gab ein Problem bei Upload. Der Fehler lautet: ' . $upload['error']);
	            } else {
	                add_post_meta($id, 'mbgi-antraege-antrag-file', $upload);
	                update_post_meta($id, 'mbgi-antraege-antrag-file', $upload);     
	            }
	 
	        } else {
	            wp_die("Das Dateiformat ist nicht zulässig.");
	        }
	    }
	}
	add_action( 'save_post', 'mbgi_save_antraege_meta_box' );