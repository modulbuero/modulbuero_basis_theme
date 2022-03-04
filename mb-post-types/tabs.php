<?php 
add_action( 'init', function(){
    $typName    = 'Tab';
    $typNames   = 'Tabs';
    $typSlug    = 'tabs';
    $typMenuName= 'Tabs';
    $optionName = 'mbgi_enable_post_types_activate_'.$typSlug;

    if(get_option($optionName) == "on"){
        register_post_type( $typSlug , array(
            'public' 					=> true,
            'query_var' 				=> true,
            'show_in_rest'              => true,
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
            'supports'                  => array( 'title','thumbnail', 'editor', 'revisions', 'excerpt',),//Titel, Beitragsbild, Beschreibung
            'menu_position' 			=> 32,
            'menu_icon' 				=> 'dashicons-media-document',
        ),);

        //Kategorie "Gruppe"
        $taxName    = 'Gruppe';
        $taxNames   = 'Gruppen';
        $taxSlug    = 'gruppe';
        register_taxonomy($taxSlug, $typSlug,array(
            'labels' => [
                'name'          => $taxNames,
                'singular_name' => $taxName,
                'search_items'  => 'Suche ' .$taxName,
                'all_items'     => 'Alle ' .$taxNames,
                'edit_item'     => 'Bearbeite '.$taxName, 
                'update_item'   => 'Update '.$taxName,
                'add_new_item'  => 'Neue '.$taxName,
                'new_item_name' => 'Neue '.$taxName,
                'menu_name'     => $taxNames,
            ],
            'hierarchical'          => true,
            'show_in_rest'          => true,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'rewrite'               => array( 'slug' => $taxSlug ),
        ));
    }
});