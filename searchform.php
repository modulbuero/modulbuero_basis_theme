<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_unique_id/
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$sf_unique_id = wp_unique_id( 'search-form-' );

$mb_aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';
?>
<form role="search" <?php echo $mb_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?> method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="suchen-label" for="<?php echo esc_attr( $sf_unique_id ); ?>">
		<?php _e( 'Suche', 'modulbuero' );?>
	</label>
	<input type="search" id="<?php echo esc_attr( $sf_unique_id ); ?>" class="search-field" value="<?php echo get_search_query(); ?>" placeholder="Website durchsuchen…" name="s" />
	<input type="submit" class="search-submit fa-arrow-right" value="&#xf061" />
</form>
