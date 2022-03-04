<?php
		
add_action( 'admin_menu', function(){
	add_submenu_page( 
		"admin-einrichtung",			// ParentMenuPage
		"Libraries", 				    // Titel auf der Seite selbst
		"Libraries", 				    // Menü Titel
		"manage_options", 				// ist optionkey
		"mb_libraries_options", 	    // url slug
		'mb_libraries_optionpage', 		// callback für den inhalt
		2 );							// position / prio
});

// Seiten Content
function mb_libraries_optionpage(){ ?>
	<h1>Libraries ein-/ausschalten</h1>
	<form method="post" action="options.php">
	<?php
		settings_fields('mb_libraries_settings_field'); 	// settings group name
		do_settings_sections('mb_libraries_options'); 	// just a page slug
		submit_button();
	?>
	</form>
	<?php
}


// Optionsfelder definieren
add_action('admin_init', function(){
	// Variable
	$settingName= 'mb_libraries_'; 		// Eintrag der OptionsID
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

	//Slickslider
	register_setting(
		$fieldName,
		$settingName.'slick',     	// option name
		$sanitize
	);
	add_settings_field(
		$settingName.'slick',  	  	//option name
		'Slick einbinden',						
		$settingName.'html', 		// callback für den inhalt des feldes
		$slug, 		
		$sectionID,
		array(
			'label_for' => $settingName.'slick',
			'class' 	=> $settingName
		)
	);

	//Leafleat/OpenstreetMap
	register_setting(
		$fieldName,
		$settingName.'leaflet',
		$sanitize
	);
	add_settings_field(
		$settingName.'leaflet',
		'Leaflet einbinden',						
		$settingName.'html',
		$slug, 		
		$sectionID,
		array(
			'label_for' => $settingName.'leaflet',
			'class' 	=> $settingName
		)
	);
});

function mb_libraries_html($args){
	$option = $args["label_for"];
	$inhalt = get_option($option);
	$checked = (!empty($inhalt))?"checked":"";
	printf("<input type='checkbox' id='$option' name='$option' $checked/>", esc_attr($inhalt));
}


// Funktionalität der Options
/**
 * Fires after WordPress has finished loading but before any headers are sent.
 *
 */
add_action("init", function(){
	if(!empty(get_option("mb_libraries_leaflet"))){
		wp_enqueue_script( "mb_leaflet_lib", get_template_directory_uri()."/lib/leaflet/leaflet.js", array("jquery"), false );
		wp_enqueue_style( "mb_leaflet_lib_style", get_template_directory_uri()."/lib/leaflet/leaflet.css", array());
	}
	if(!empty(get_option("mb_libraries_slick"))){
		wp_enqueue_script( "mb_slick_lib_js", get_template_directory_uri()."/lib/slick/slick.min.js", array("jquery"), false );
		wp_enqueue_style( "mb_slick_lib_style", get_template_directory_uri()."/lib/slick/slick.css", array());
	}
});