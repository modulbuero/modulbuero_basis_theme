<?php
/*
	Init Styles
*/
function mb_enqueue_style(){
	$theme = wp_get_theme();
	if($parent = $theme->get('Template')) {
		$child = $theme;
		$theme = wp_get_theme($parent);
	}
	
	/*Styles*/
    wp_enqueue_style( 'mb-root-style', get_template_directory_uri() . '/style/root.css', array(), $theme->get( 'Version' ));
    wp_enqueue_style( 'mb-default-style', get_template_directory_uri() . '/style/default.css', array('mb-root-style'), $theme->get( 'Version' ));
	wp_enqueue_style( 'mb-fonts-style', get_template_directory_uri() . '/style/fonts.css', array('mb-root-style'), $theme->get( 'Version' ));
	wp_enqueue_style( 'mb-header-style', get_template_directory_uri() . '/style/header.css', array('mb-default-style'), $theme->get( 'Version' ));
	wp_enqueue_style( 'mb-main-style', get_template_directory_uri() . '/style/main.css', array('mb-header-style'), $theme->get( 'Version' ));
	wp_enqueue_style( 'mb-loop-style', get_template_directory_uri() . '/style/loop.css', array('mb-header-style'), $theme->get( 'Version' ));
	wp_enqueue_style( 'mb-mobile-style', get_template_directory_uri() . '/style/mobile.css', array('mb-default-style'), $theme->get( 'Version' ));
}
add_action('wp_enqueue_scripts', 'mb_enqueue_style');

/*
	Scripts/Style to Footer
*/
function mb_enqueue_footer(){
	$theme = wp_get_theme();
	if($parent = $theme->get('Template')) {
		$child = $theme;
		$theme = wp_get_theme($parent);
	}
	/*Styles*/
	wp_enqueue_style( 'mb-footer-style', get_template_directory_uri() . '/style/footer.css', array('mb-default-style'), $theme->get( 'Version' ));
	wp_enqueue_style( 'mb-fawesome-style', get_template_directory_uri() . '/fonts/fontawesome-free-5.15.3-web/css/all.min.css', array('mb-root-style'));
	
	//Scripts
    wp_enqueue_script('mb-main-scripts', get_template_directory_uri().'/scripts/scripts.js',array('jquery'), $theme->get( 'Version' ));
}
add_action('wp_footer', 'mb_enqueue_footer');

/* 
 *	Admin Scripts
*/
function mb_enqueue_admin(){
	$theme = wp_get_theme();
	if($parent = $theme->get('Template')) {
		$child = $theme;
		$theme = wp_get_theme($parent);
	}

	wp_enqueue_style( 'mb-admin-style', get_template_directory_uri() . '/style/admin.css', array(), $theme->get( 'Version' ));
	wp_enqueue_script( 'mb-upload-script', get_template_directory_uri() . '/scripts/file-upload.js', array('jquery'), $theme->get( 'Version' ));
	wp_enqueue_media(); //Braucht man für MediaUpload (z.B. bei Abgeordnete oder Anträge)
}
add_action('admin_enqueue_scripts', 'mb_enqueue_admin');

