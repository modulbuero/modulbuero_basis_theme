<?php
// Metafeld für Slider
function mb_register_slider_meta() {
	add_meta_box('slider-meta-box', 'Textoption', 'mb_slider_callback', 'slider', 'normal','high' );
}
add_action('add_meta_boxes', 'mb_register_slider_meta');

function mb_slider_callback($post) {
	?>
	
	<div class='mbgi-slider-meta-box'>
		<p>
			<input
				id='mbgi-slider-checkbox-meta-box'
				type='checkbox'
				name='mbgi-slider-checkbox-meta-box'
				<?php checked(esc_attr(get_post_meta(get_the_ID(), 'mbgi-slider-checkbox-meta-box', true)), 'on'); ?>
			>
			<label for="mbgi-slider-checkbox-meta-box">Titel im Slider anzeigen</label>
		</p>
	</div>
	
	<?php
}

function mb_save_slider_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    	if ( $parent_id = wp_is_post_revision( $post_id ) ) {
			$post_id = $parent_id;
	    }
	    $fields = [
	        'mbgi-slider-checkbox-meta-box',
	    ];
	    foreach ( $fields as $field ) {
	        if ( array_key_exists( $field, $_POST ) ) {
	            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
	        } else if ($field == 'mbgi-slider-checkbox-meta-box' AND empty($_POST[$field])) {
			        update_post_meta($post_id, $field, 'off');
			}
	    }
}
add_action( 'save_post', 'mb_save_slider_meta_box' );