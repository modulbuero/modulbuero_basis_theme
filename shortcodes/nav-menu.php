<?php
/**
 * Deprecated Since WP 5.9
 * Creates a Navmenu by Attribute
 */
add_action("init", function(){
    add_shortcode('mb_nav_menu', function($atts){
        ob_start();
            $atts = shortcode_atts( array(
                'menu_name' => ''
            ), $atts, 'portable_menu' );
            wp_nav_menu(
            array(
                'menu' => $atts['menu_name'],
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                )
            );
        return ob_get_clean();
    });
});