<?php
/*
 *  Aktiviere Inhaltstypen
 */
add_action( 'admin_menu', function(){
	add_submenu_page( 
		"admin-einrichtung",		// ParentMenuPage
		"Inhaltstypen", 			// Titel auf der Seite selbst
		"Inhaltstypen", 		    // Menü Titel
		"manage_options", 			// ist optionkey
		"mb_posttypes_options",     // url slug
		'mb_posttypes_optionpage',  // callback für den inhalt
		2 );						// position / prio
});

// Seiten Content
function mb_posttypes_optionpage(){ 
	?>
	<h1>Inhaltstyp aktivieren</h1>
	<p><i>Neue Inhaltstypen können im Child-Theme im Ordner <strong>post-types</strong> hinterlegt werden.</i></p>
	<form method="post" action="options.php">
	<?php
		settings_fields('mbgi_enable_post_types_settings_field'); 		// settings group name
		do_settings_sections('mbgi_enable_post_types_options'); // just a page slug
		submit_button();
	?>
	</form>
	<?php
}

// Optionsfelder definieren
add_action('admin_init', function(){
	// Variable
	$settingName= 'mbgi_enable_post_types_'; 		// Eintrag der OptionsID
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

	$postTypes = getCustomeMBPosttypesFileName(true);
    foreach($postTypes as $postType){    
        register_setting(
            $fieldName,
            $settingName.'activate_'.$postType,      // option name
            $sanitize
        );
        add_settings_field(
            $settingName.'activate_post'.$postType,  
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

function mbgi_enable_post_types_html($args){
	//Enable Logico
    $postType   = $args['post_type'];
    $optionName = 'mbgi_enable_post_types_activate_'.$postType;
    $inhalt     = get_option($optionName);
    $checked    = (!empty($inhalt))?"checked":"";
	printf('<input type="checkbox" id="'.$optionName.'" name="'.$optionName.'" '.$checked.' />', esc_attr($inhalt));
}