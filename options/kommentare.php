<?php
		
add_action( 'admin_menu', function(){
	add_submenu_page( 
		"einrichtung",					// ParentMenuPage
		"Kommentare", 				    // Titel auf der Seite selbst
		"Kommentare", 				    // Menü Titel
		"manage_options", 				// ist optionkey
		"mb_kommentare_options", 	    // url slug
		'mb_kommentare_optionpage', 	// callback für den inhalt
		2 );							// position / prio
});

// Seiten Content
function mb_kommentare_optionpage(){ ?>
	<h1>Kommentare</h1>
	<p>Einstellungen für Kommentare</p>
	<form method="post" action="options.php">
	<?php
		settings_fields('mb_kommentare_settings_field'); 	// settings group name
		do_settings_sections('mb_kommentare_options'); 	// just a page slug
		submit_button();
	?>
	</form>
	<?php
}


// Optionsfelder definieren
add_action('admin_init', function(){
	// Variable
	$settingName= 'mb_kommentare_'; 		// Eintrag der OptionsID
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

	//Facebook
	register_setting(
		$fieldName,
		$settingName.'aus',   	  // option name
		$sanitize
	);
	add_settings_field(
		$settingName.'aus',  	  //option name
		'Kommentare ausschalten',						
		$settingName.'aus_html', // callback für den inhalt des feldes
		$slug, 		
		$sectionID,
		array(
			'label_for' => $settingName.'aus',
			'class' 	=> $settingName
		)
	);
});

function mb_kommentare_aus_html(){
	$inhalt = get_option('mb_kommentare_aus');
	$checked = (!empty($inhalt))?"checked":"";
	printf('<input type="checkbox" id="mb_kommentare_aus" name="mb_kommentare_aus" '.$checked.'/>', esc_attr($inhalt));
}