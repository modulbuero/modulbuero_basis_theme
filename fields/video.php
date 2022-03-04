<?php
	// Metafeld für Youtube / Video CPT
	function mb_register_video_meta() {
		add_meta_box('video', 'Youtube-Link', 'mb_video_callback', 'video', 'normal','high' );
	}
	add_action('add_meta_boxes', 'mb_register_video_meta');
	
	function mb_video_callback($post) {
		?>
		
		<div class='mbgi-youtube-meta-box'>
			<p>
				<input
					id='mbgi-youtube-link-meta-box'
					class='mbgi-input'
					type='text'
					name='mbgi-youtube-link-meta-box'
					size='50'
					placeholder="https://www.youtube-nocookie.com/embed/"
					value='<?php echo esc_attr(get_post_meta(get_the_ID(), 'mbgi-youtube-link-meta-box', true)); ?>'
				>
			</p>
		</div>
		
		<?php
	}
	
	function mb_save_youtube_meta_box( $post_id ) {
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	    	if ( $parent_id = wp_is_post_revision( $post_id ) ) {
				$post_id = $parent_id;
		    }
		    $fields = [
		        'mbgi-youtube-link-meta-box',
		    ];
		    foreach ( $fields as $field ) {
		        if ( array_key_exists( $field, $_POST ) ) {
		            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
		        }
		    }
	}
	add_action( 'save_post', 'mb_save_youtube_meta_box' );