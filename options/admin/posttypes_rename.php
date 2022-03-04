<?php
/*
 *  Umbenennen der Inhaltstypen
 */
add_action( 'admin_menu', function(){
	add_submenu_page( 
		"admin-einrichtung",		// ParentMenuPage
		"Inhaltstypen umbennenen", 	// Titel auf der Seite selbst
		"Rename Type", 		    	// Menü Titel
		"manage_options", 			// ist optionkey
		"mb_posttypesrename_options",     // url slug
		'mb_posttypesrename_optionpage',  // callback für den inhalt
		2 );						// position / prio
});


// Seiten Content
function mb_posttypesrename_optionpage(){ 
	?>
	<h1>Inhaltstyp umbennenen</h1>
	<p><i>die Typen werden gefiltert und können in der backend.php (global) angepasst werden</i></p>
	<form method="post" action="options.php">
	<?php
		settings_fields('mbgi_rename_post_types_settings_field'); 	// settings group name
		do_settings_sections('mbgi_rename_post_types_options'); 	// just a page slug
		submit_button();
	?>
	</form>
	<?php
}

// Optionsfelder definieren
add_action('admin_init', function(){
	// Variable
	$settingName= 'mbgi_rename_post_types_'; 		// Eintrag der OptionsID
	$sectionID 	= $settingName.'section_id';
	$fieldName 	= $settingName.'settings_field';
	$sanitize 	= 'sanitize_text_field';
	$slug		= $settingName.'options';
	
	// Regestrierung der MainSection
	add_settings_section(
		$sectionID, 	// section ID
		'', 			// Titel (optional)
		'', 			// callback function (optional)
		$slug			// page-slug
	);

	$posttypesrename = getCustomeMBPosttypesFileName(true, true);
    foreach($posttypesrename as $postType){    
        register_setting(
            $fieldName,
            $settingName.$postType,      // option name
            $sanitize
        );
        add_settings_field(
            $settingName.'rename_post'.$postType,  
            ucfirst($postType),
            $settingName.'html',                    // callback für den inhalt des feldes
            $slug,
            $sectionID,
            array(
                'post_type' => $postType
            )
        );
    }    
});

function mbgi_rename_post_types_html($args){
    $postType   = $args['post_type'];
    $optionName = 'mbgi_rename_post_types_'.$postType;
    $inhalt     = get_option($optionName);
	$optionActive = 'mbgi_enable_post_types_activate_'.$postType;
    $active     = get_option($optionActive);
	$isActive	= ($active == "on")?true:false;
	$readonly	= (!$isActive)?"readonly":"";
	printf('<input type="text" id="'.$optionName.'" name="'.$optionName.'" value="%s" '.$readonly.'/>', esc_attr($inhalt));
	
	if($isActive){
		printf('<span> <i>aktiv</i><span/>');
	}
}