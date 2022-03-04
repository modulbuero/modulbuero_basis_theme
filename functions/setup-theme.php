<?php

/* **************************************** *
	Um Beitragsbilder zu aktivieren
*/
add_theme_support( 'post-thumbnails' );

/** **************************************** *
* 	Add a sidebar.
*/
function mb_setup_sidebar() {
	register_sidebar( array(
		'name'          => 'Header',
		'id'            => 'mb-header-sidebar',
		'description'   => 'Hier können Sie ihre Headerzeile aufbauen',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	) );

	register_sidebar( array(
		'name'          => 'Footer',
		'id'            => 'mb-footer-sidebar',
		'description'   => 'Hier können Sie ihren Footer aufbauen',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	) );
}
add_action( 'widgets_init', 'mb_setup_sidebar' );

/** **************************************** *
* 	Theme Support
*/
function mb_theme_support(){
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
			'post-thumbnails',
		));

	add_action( 'after_setup_theme', 'mb_theme_support' );
}

/* Bilder Comprimieren, Vorschaubilder */
if(!function_exists('mb_image_sizes')) {
	function mb_image_sizes() {
		add_image_size( 'mbgi-thumb-1920', 1920);
		add_image_size( 'mbgi-thumb-1280', 1280);
		add_image_size( 'mbgi-thumb-1024', 967);
		add_image_size( 'mbgi-thumb-568', 568 );
		add_image_size( 'mbgi-thumb-300', 300 );
	}
}
add_action('after_setup_theme', 'mb_image_sizes');
add_filter('image_size_names_choose', 'mb_custom_sizes');

/*Zuweisen der eigenen Größen*/
function mb_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'mbgi-thumb-1280' => __( 'Desktop Größe' ),
        'mbgi-thumb-1024' => __( 'Tablet Größe' ),
        'mbgi-thumb-568' => __( 'Mobile Größe' ),
        'mbgi-thumb-1920' => __( 'HD Größe' ),
    ) );
}

/*Entfernen des Standards*/
function mb_remove_image_size($sizes) {
    unset( $sizes['small'] );
    unset( $sizes['medium'] );
    unset( $sizes['large'] );
    return $sizes;
}
add_filter('image_size_names_choose', 'mb_remove_image_size');

/*Default ändern*/
function mb_theme_default_image_size() {
    return 'mbgi-thumb-1259';
}
add_filter( 'pre_option_image_default_size', 'mb_theme_default_image_size' );

/*Comprimierung*/
add_filter('jpeg_quality', function($arg){return 90;});

/*Verstecke Theme-Editor*/
function disable_theme_editor() {
	define('DISALLOW_FILE_EDIT', TRUE);
}
add_action('init','disable_theme_editor');

/** **************************************** *
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/** **************************************** *
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/** **************************************** *
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
	
		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	
	return $urls;
}

/** **************************************** *
 *	API deaktivieren
 */
add_filter('rest_enabled', '_return_false');
add_filter('rest_jsonp_enabled', '_return_false');
add_filter('xmlrpc_enabled', '__return_false');
