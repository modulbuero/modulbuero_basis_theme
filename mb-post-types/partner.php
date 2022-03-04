<?php 
add_action( 'init', function(){
    $typName    = 'Partner';
    $typNames   = 'Partner';
    $typSlug    = 'partner';
    $typMenuName= 'Partner';
    $optionName = 'mbgi_enable_post_types_activate_'.$typSlug;

    if(get_option($optionName) == "on"){
        register_post_type( $typSlug , array(
            'public' 					=> true,
            'query_var' 				=> true,
            'show_in_rest'				=> true,
            'rewrite'					=> array( 'slug' => $typSlug, 'with_front' => false ),
            'labels' => array(
                'name' 					=> $typNames,
                'singular_name' 		=> $typName,
                'menu_name' 			=> $typMenuName,
                'all_items' 			=> 'Alle '.$typNames,
                'add_new' 				=> 'Hinzufügen',
                'add_new_item' 			=> 'Hinzufügen',
                'edit' 					=> 'Bearbeiten',
                'edit_item' 			=> 'Bearbeite '.$typName,
                'new_item' 				=> 'Neue '.$typName,
                'view_item' 			=> 'Zeige '.$typName,
                'search_items' 			=> 'Suche '.$typName,
                'not_found' 			=> 'Keine '.$typName.' gefunden.',
                'not_found_in_trash' 	=> 'Keine '.$typName.' im Papierkorb',
                'parent_item_colon' 	=> ''
            ),
            //Customize
            'taxonomies'                => array('category', 'post_tag'),
            'supports'                  => array( 'title','thumbnail', 'editor', 'revisions', 'excerpt',),//Titel, Beitragsbild, Beschreibung
            'menu_position' 			=> 32,
            'menu_icon' 				=> 'dashicons-businessperson',
        ),);
    }
});