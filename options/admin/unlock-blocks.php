<?php
add_action( 'admin_menu', function(){
    add_submenu_page( 
        "admin-einrichtung",		// ParentMenuPage
        "Blöcke", 			// Titel auf der Seite selbst
        "Blöcke", 		    // Menü Titel
        "manage_options", 			// ist optionkey
        "mb-blocks",     // url slug
        'mb_unlock_blocks_page',  // callback für den inhalt
        3 );						// position / prio
});

// Seiten Content
function mb_unlock_blocks_page(){ 
	?>
	<h1>Blöcke freischalten</h1>
	<form method="post" action="options.php">
	<?php
		settings_fields('mbgi_unlock_blocks_settings_field'); 		// settings group name
		do_settings_sections('mbgi_unlock_blocks_options'); // just a page slug
		submit_button();
	?>
	</form>
	<?php
}

// Optionsfelder definieren
add_action('admin_init', function(){
	// Variable
	$settingName= 'mbgi_unlock_blocks_'; 		// Eintrag der OptionsID
	$sectionID 	= $settingName.'section_id';
	$fieldName 	= $settingName.'settings_field';
	$sanitize 	= 'sanitize_text_field';
	$slug		= $settingName.'options';

    $all_locked_blocks = get_locked_blocks();

    foreach($all_locked_blocks as $key => $block){
	
		// Regestrierung der MainSection
		add_settings_section(
			$sectionID."_".$block, 	// section ID
			$key, 			// Titel (optional)
			'', 			// callback function (optional)
			$slug			// page-slug
		);

		// block freigeben für pages
        register_setting(
            $fieldName,
            $settingName.'option_'.$block."_page",   	  // option name
            $sanitize
        );
        add_settings_field(
            $settingName.'option_block_'.$block."_page",  	  //option name
            "Für Page freischalten",						
            $settingName.'html_page', // callback für den inhalt des feldes
            $slug, 		
            $sectionID."_".$block,
            array(
                'block' => $block,
				'class' => "no-padding"
            )
        );

		// block freigeben post
        register_setting(
            $fieldName,
            $settingName.'option_'.$block."_post",   	  // option name
            $sanitize
        );
        add_settings_field(
            $settingName.'option_block_'.$block."_post",  	  //option name
            "Für Posts freigeben",						
            $settingName.'html_post', // callback für den inhalt des feldes
            $slug, 		
            $sectionID."_".$block,
            array(
                'block' => $block,
				'class' => "no-padding"
            )
        );

		// block freigeben widgets
        register_setting(
            $fieldName,
            $settingName.'option_'.$block."_widgets",   	  // option name
            $sanitize
        );
        add_settings_field(
            $settingName.'option_block_'.$block."_widgets",  	  //option name
            "Für Widgets freigeben",						
            $settingName.'html_widgets', // callback für den inhalt des feldes
            $slug, 		
            $sectionID."_".$block,
            array(
                'block' => $block,
				'class' => "no-padding"
            )
        );
    }
});

function mbgi_unlock_blocks_html_widgets($args){
    $block = $args['block'];
    $inhalt = get_option('mbgi_unlock_blocks_option_'.$block."_widgets");
    $checked = (!empty($inhalt))?"checked":"";
    printf('<input type="checkbox" id="mbgi_unlock_blocks_option_'.$block.'_widgets" name="mbgi_unlock_blocks_option_'.$block.'_widgets" '.$checked.'/>', esc_attr($inhalt));
}

function mbgi_unlock_blocks_html_page($args){
    $block = $args['block'];
    $inhalt = get_option('mbgi_unlock_blocks_option_'.$block."_page");
    $checked = (!empty($inhalt))?"checked":"";
    printf('<input type="checkbox" id="mbgi_unlock_blocks_option_'.$block.'_page" name="mbgi_unlock_blocks_option_'.$block.'_page" '.$checked.'/>', esc_attr($inhalt));
}

function mbgi_unlock_blocks_html_post($args){
    $block = $args['block'];
    $inhalt = get_option('mbgi_unlock_blocks_option_'.$block."_post");
    $checked = (!empty($inhalt))?"checked":"";
    printf('<input type="checkbox" id="mbgi_unlock_blocks_option_'.$block.'_post" name="mbgi_unlock_blocks_option_'.$block.'_post" '.$checked.'/>', esc_attr($inhalt));
}