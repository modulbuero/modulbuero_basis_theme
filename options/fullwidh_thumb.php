<?php
		
add_action( 'admin_menu', function(){
	add_submenu_page( 
		"einrichtung",					// ParentMenuPage
		"Beitragsbild", 			    // Titel auf der Seite selbst
		"Beitragsbild", 				    // Menü Titel
		"manage_options", 				// ist optionkey
		"mb_fullwidh_thumb_options", 	    // url slug
		'mb_fullwidh_thumb_optionpage', 	// callback für den inhalt
		6 ); 							// position / prio
});

// Seiten Content
function mb_fullwidh_thumb_optionpage(){ 
	?>
	<h1>Beitragsbild</h1>
	<p>Hier lässt sich das Beitragsbild in voller Bereite definieren.<br>Zudem extra für Beiträge und Pages unterscheiden</p>
	<form method="post" action="options.php">
	<?php
		settings_fields('mb_fullwidh_thumb_settings_field'); 	// settings group name
		do_settings_sections('mb_fullwidh_thumb_options'); 	// just a page slug
		submit_button();
	?>
	</form>
	<?php
}


// Optionsfelder definieren
add_action('admin_init', function(){
	// Variable
	$settingName= 'mb_fullwidh_thumb_'; 		// Eintrag der OptionsID
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

	//Beiträge
	register_setting(
		$fieldName,
		$settingName.'post',   	  // option name
		$sanitize
	);
	add_settings_field(
		$settingName.'post',  	  //option name
		'Beiträge',						
		$settingName.'posts_html', // callback für den inhalt des feldes
		$slug, 		
		$sectionID,
		array(
			'label_for' => $settingName.'posts',
			'class' 	=> $settingName
		)
	);
	
	//Seiten
	register_setting(
		$fieldName,
		$settingName.'page',   	  // option name
		$sanitize
	);
	add_settings_field(
		$settingName.'page',  	  //option name
		'Seiten',						
		$settingName.'pages_html', // callback für den inhalt des feldes
		$slug, 		
		$sectionID,
		array(
			'label_for' => $settingName.'posts',
			'class' 	=> $settingName
		)
	);
});

function mb_fullwidh_thumb_posts_html(){
	$inhalt = get_option('mb_fullwidh_thumb_post');
	$checked = (!empty($inhalt))?"checked":"";
	printf('<input type="checkbox" id="mb_fullwidh_thumb_post" name="mb_fullwidh_thumb_post" '.$checked.'/>', esc_attr($inhalt));
}
function mb_fullwidh_thumb_pages_html(){
	$inhalt = get_option('mb_fullwidh_thumb_page');
	$checked = (!empty($inhalt))?"checked":"";
	printf('<input type="checkbox" id="mb_fullwidh_thumb_page" name="mb_fullwidh_thumb_page" '.$checked.'/>', esc_attr($inhalt));
}