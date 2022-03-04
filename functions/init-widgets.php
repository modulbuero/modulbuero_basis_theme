<?php
/**
 *  $theme_directory kommt aus der functions.php
 *
 *  alle widgets laden
 */
global $pagenow;
if ($pagenow !== "post.php" && $pagenow !== "post-new.php") {
	if(has_template_parts("/widgets/")){
		get_template_parts("/widgets/");
	}
}

/**
 * Ausblenden von WP Blöcken
 * */
function mb_unregister_sidebarwidgets(){
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Recent_Comments');
	//unregister_widget('WP_Widget_Recent_Posts');
	//unregister_widget('WP_Widget_Tag_Cloud');
	//unregister_widget('WP_Widget_Categories');
	//unregister_widget('WP_Widget_Search');
}
add_action( 'widgets_init', 'mb_unregister_sidebarwidgets' );