<?php
		
add_action( 'admin_menu', function(){
	add_submenu_page( 
		"einrichtung",					// ParentMenuPage
		"Social Media", 				// Titel auf der Seite selbst
		"Social Media", 				// Menü Titel
		"manage_options", 				// ist optionkey
		"mb_social_media_options", 	// url slug
		'mb_socialmedia_optionpage', 	// callback für den inhalt
		2 ); 							// position / prio
});

// Seiten Content
function mb_socialmedia_optionpage(){ 
	?>
	<h1>Social Media Links</h1>
	<p>gebt hier die Links zu euren Social-Media-Kanäle an</p>
	<form method="post" action="options.php">
	<?php
		settings_fields('mb_sozial_media_settings_field'); 	// settings group name
		do_settings_sections('mb_sozial_media_options'); 	// just a page slug
		submit_button();
	?>
	</form>
	<?php
}


// Optionsfelder definieren
add_action('admin_init', function(){
	// Variable
	$settingName= 'mb_sozial_media_'; 		// Eintrag der OptionsID
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
		$settingName.'facebook',   	  // option name
		$sanitize
	);
	add_settings_field(
		$settingName.'facebook',  	  //option name
		'Facebook',						
		$settingName.'facebook_html', // callback für den inhalt des feldes
		$slug, 		
		$sectionID,
		array(
			'label_for' => $settingName.'facebook',
			'class' 	=> $settingName
		)
	);
	
	
	//Twitter
	register_setting(
		$fieldName,
		$settingName.'twitter', 	// option name
		$sanitize
	);
	add_settings_field(
		$settingName.'twitter',  		//option name
		'Twitter',
		$settingName.'twitter_html', 	// callback für den inhalt des feldes
		$slug, 		//page slug
		$sectionID, 			// Section ID
		array(
			'label_for' => $settingName.'twitter',
			'class' 	=> $settingName
		)
	);
	
	//Instagram
	register_setting(
		$fieldName,
		$settingName.'instagram', 	// option name
		$sanitize
	);
	add_settings_field(
		$settingName.'instagram',  		//option name
		'Instagram',
		$settingName.'instagram_html', 	// callback für den inhalt des feldes
		$slug, 		//page slug
		$sectionID, 			// Section ID
		array(
			'label_for' => $settingName.'instagram',
			'class' 	=> $settingName
		)
	);

	//YouTube
	register_setting(
		$fieldName,
		$settingName.'youtube', 	// option name
		$sanitize
	);
	add_settings_field(
		$settingName.'youtube',  		//option name
		'YouTube',
		$settingName.'youtube_html', 	// callback für den inhalt des feldes
		$slug, 		//page slug
		$sectionID, 			// Section ID
		array(
			'label_for' => $settingName.'youtube',
			'class' 	=> $settingName
		)
	);
	
	//RSS-Feed
	register_setting(
		$fieldName,
		$settingName.'feed', 	// option name
		$sanitize
	);
	add_settings_field(
		$settingName.'feed',  		//option name
		'Feed',
		$settingName.'feed_html', 	// callback für den inhalt des feldes
		$slug, 		//page slug
		$sectionID, 			// Section ID
		array(
			'label_for' => $settingName.'feed',
			'class' 	=> $settingName
		)
	);
});

 // Callback für den Inhalt der Felder
function mb_sozial_media_facebook_html(){
	$optionName = 'mb_sozial_media_facebook';
	$inhalt = get_option($optionName);
	printf('<input type="text" id="'.$optionName.'" class="mbgi-input" name="'.$optionName.'" value="%s" />', esc_attr($inhalt));
}
function mb_sozial_media_twitter_html(){ 
	$optionName = 'mb_sozial_media_twitter';
	$inhalt = get_option($optionName);
	printf('<input type="text" id="'.$optionName.'" class="mbgi-input" name="'.$optionName.'" value="%s" />', esc_attr($inhalt));
}
function mb_sozial_media_instagram_html(){ 
	$optionName = 'mb_sozial_media_instagram';
	$inhalt = get_option($optionName);
	printf('<input type="text" id="'.$optionName.'" class="mbgi-input" name="'.$optionName.'" value="%s" />', esc_attr($inhalt));
}
function mb_sozial_media_youtube_html(){ 
	$optionName = 'mb_sozial_media_youtube';
	$inhalt = get_option($optionName);
	printf('<input type="text" id="'.$optionName.'" class="mbgi-input" name="'.$optionName.'" value="%s" />', esc_attr($inhalt));
}
function mb_sozial_media_feed_html(){ 
	$optionName = 'mb_sozial_media_feed';
	$inhalt = get_option($optionName);
	printf('<input type="text" id="'.$optionName.'" class="mbgi-input" name="'.$optionName.'" value="%s" />', esc_attr($inhalt));
}
