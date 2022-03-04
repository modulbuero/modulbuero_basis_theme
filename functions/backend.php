<?php
//is_Superadminuser
if( !function_exists('is_mb_admin_user') ){ function is_mb_admin_user() {
	if ( is_user_logged_in() ){
		global $current_user;
		wp_get_current_user();
		if( in_array( $current_user->user_email, mb_admin_emails() ) ){
			return true;
		}
	}
	return false;
} }

if( !function_exists( 'mb_if_check' ) ) {
	function mb_if_check( $variable = false ) {
		if( isset($variable) && !empty($variable) && $variable && !is_wp_error($variable) ){
			return true;
		}else{
			return false;
		}
	}
}

if( !function_exists('mb_admin_emails')) { function mb_admin_emails( $format = 'array' ) {
	$admin_emails = array(
		'webmaster@modulbuero.com',
	);
	if( $format == 'array' ){
		return $admin_emails;
	}
	return false;
} }


/** **************************************** *
 *	Neuer Menüpunkt "Einrichtung"
 */
function mb_structure_menu_register() {
	add_menu_page( __('Einrichtung','modulbuero'),
	__('Einrichtung','modulbuero'), 
	'manage_options', 
	'einrichtung', 
	'callback_einrichtung_html', 
	'dashicons-admin-generic', 
	'61' 
	);
	
	function callback_einrichtung_html(){
	?>
		<h1>Stellen Sie hier noch einige Weichen für das Design und den Inhalt ein</h1>
		<ul>
			<li>
				<a href="?page=mb_kommentare_options">Kommentare</a>
			</li>
			<li>
				<a href="?page=mb_social_media_options">Socialmedia-Links</a>
			</li>
			
		</ul>
	<?php
	}
}
add_action( 'admin_menu', 'mb_structure_menu_register' );


/** **************************************** *
 *	Backend-Login Logo
 */
function mb_login_logo() { ?>
    <style type="text/css">
	    body.login div#login{
		    width:353px;
	    } 
	    body.login div#login h1 {
		    display: inline-block;
	    }
	    
	    body.login div#login h1 a{
		    display: flex;
		    background-image: none;
		    font-family: "Arvo";
		    font-weight: 700;
		    color: #0A321E;
		    font-size: 30px;
		    overflow: visible;
		    width: fit-content;
		    height: auto;
		    white-space: nowrap;
			text-indent: 0 !important;
	    }
        body.login div#login h1 a:before {
	        content: "";
            background-image: url("<?php echo get_template_directory_uri(); ?>/images/Logo.svg");
            background-size: contain;
            background-repeat: no-repeat;
            width: 40px;
            height: auto;
            display: block;
            margin-right: 15px;
        }
        body.login.wp-core-ui .button-primary{
	        background-color: #46962B !important;
	        border-color:  #46962B !important;
        }
        body.login.wp-core-ui .button-primary:hover{
	        background-color: #68BD4B !important;
	        border-color:  #68BD4B !important;
        }
        .login #login_error, .login .message, .login .success{
	        border-left: 4px solid #46962B !important;
        }
		.login a{
			color:  #46962B;
		}
		.login a:hover{
			color:#68BD4B !important;
		}
		.login input:focus{
			border-color: #68BD4B !important;
			box-shadow: 0 0 0 1px #68BD4B !important;
		}
        
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'mb_login_logo' );

function mb_login_logo_url() {
	return "https://modulbuero.de";
}
add_filter( 'login_headerurl', 'mb_login_logo_url' );

function mb_login_logo_url_title() {
	return "Modulbüro";
}
add_filter( 'login_headertext', 'mb_login_logo_url_title' );


/** **************************************** *
 *	remove link to Design (themes.php) and Customizer (customize.php) if user is not SuperAdministrator
 */
function remove_admin_menu_links(){
    if( !is_super_admin() ) {    	
	    global $submenu;
	    if ( isset( $submenu[ 'themes.php' ] ) ) { //Unterpunkt Design
	        foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) { //jeder Menüpunkt ist ein Array (das erste Array is der Link hinter Design)
	            if ( in_array( 'Customizer', $menu_item ) || in_array( 'Themes', $menu_item ) ) { //sucht Customizer und Themes
	                unset( $submenu[ 'themes.php' ][ $index ] ); //entfernt den Customizer und die Themes
	            }
	        }
	    }
	    array_unshift($submenu[ 'themes.php' ], $submenu[ 'themes.php' ][array_key_first($submenu[ 'themes.php' ])]); //erstes Element im Array wird auch zum Link hinter dem Obermenü Design
	}
}	
add_action('admin_menu', 'remove_admin_menu_links');


/** **************************************** *
 *	Termine
 */
//Tägliche Initialisierung
register_activation_hook(__FILE__, 'mb_activation');
function mb_activation() {
    if (! wp_next_scheduled ( 'mb_daily_init' )) {
    	wp_schedule_event(time(), 'daily', 'mb_daily_init');
    }
}
//Deregistrieren falls nötig
register_deactivation_hook( __FILE__, 'mb_deactivation' ); 
function my_deactivation() {
    wp_clear_scheduled_hook( 'mb_daily_init' );
}
//Sortierung bei Startdatum
function mb_sort_by_startdatum($a,$b){
	$startdatumA = strtotime(get_post_meta($a->ID, 'mbgi-meta-termin-startdatum', true));
	$startdatumB = strtotime(get_post_meta($b->ID, 'mbgi-meta-termin-startdatum', true));
	return $startdatumA > $startdatumB;
}
/*
	Prüfen des wöchentlichen Termins und erneuern wenn nötig
*/
//add_action("init", "mb_refresh_termin");
add_action('mb_daily_init', 'mb_refresh_termin');
function mb_refresh_termin(){
	$posts = get_posts(array(
		'numberposts' => -1,
		'post_type' => "termin",
	));
	foreach($posts as $post){
		$meta = get_post_meta($post->ID);
		if(isset($meta["mbgi-meta-termin-repeat"]) && $meta["mbgi-meta-termin-repeat"][0] == "on"){ //zu wiederholender Termin
			$today = time();

			$startDatum = $meta['mbgi-meta-termin-startdatum'][0];
			$endDatum = $meta['mbgi-meta-termin-enddatum'][0];

			$startStamp = strtotime($startDatum);

			if(empty($endDatum) || $endDatum == "1970-01-01"){
				$endStamp = strtotime($startDatum);				
			}else{
				$endStamp = strtotime($endDatum);				
			}

			$diffStamp = $endStamp - $startStamp;

			$weekdayStart = date("l", $startStamp);
			
			if($today > $startStamp){
				$nextStart = date("Y-m-d", strtotime("Next $weekdayStart"));
				$nextStartStamp = strtotime($nextStart);
				$nextEndStamp = $nextStartStamp + $diffStamp;
				$nextEnd = date("Y-m-d", $nextEndStamp);

				update_post_meta( $post->ID, "mbgi-meta-termin-startdatum", $nextStart);
				update_post_meta( $post->ID, "mbgi-meta-termin-enddatum", $nextEnd);
			}

		}
	}
}


/** **************************************** *
 *	YOAST SEO Metabox nach unten packen
 */
add_filter( 'wpseo_metabox_prio', 'move_yoast_metabox_down');
function move_yoast_metabox_down( $priority ) {
    return "low";
}
add_filter( 'wpseo_metabox_prio', function() { return 'low'; } );


/** **************************************** *
 *	Get Posttypes. 
 *	Wird aus den Dateinamen gezogen, weil im Backend aktiv und nicht "unregistered" werden soll.
 */
function getCustomeMBPosttypesFileName($noExtensions=false, $filtered=false){
	$postNames 	= [];
	$rootDir    = get_template_directory();
	$directory  = $rootDir.'/mb-post-types/';
	if($filtered == true){
		$files      = array_diff(scandir($directory), array('..', '.', 
		'antraege.php',
		'download.php',
		'faq.php',
		'glossar.php',
		'medien.php',
		'parlament.php',
		'publikation.php',
		'referenz.php',
		'slider.php',
		'tabs.php',
		'termin.php',
		'themen.php',
		));
	}else{
		$files      = array_diff(scandir($directory), array('..', '.'));
	}
	if($noExtensions == true){
		foreach ($files as $file){
			$postType = strstr($file, '.', TRUE); //remove FileExtension
			array_push($postNames, $postType);
		}
		return $postNames;
	}else{
		return $files;
	}
	
	
}


/** **************************************** *
 *	Admin-Menü-Reihenfolge
 */
add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'custom_menu_order' );
 function custom_menu_order() {
    return array( 
		'index.php', 
		'upload.php', 
		'edit-comments.php', //comments
		'separator1', 
		'edit.php?post_type=page', //pages
		'edit.php', //posts
	);
}

/** **************************************** *
 *	Rename PostTypes 
 *	Not "SLUG"!
 */
function mb_posttype_menu_change_label() {
	global $wp_post_types;
	$freePostTypes = getCustomeMBPosttypesFileName(true, true);	
	
	foreach($freePostTypes as $postType){
    	$optionRename = get_option('mbgi_rename_post_types_'.$postType);
    	$optionActive = get_option('mbgi_enable_post_types_activate_'.$postType);

		if($optionActive == "on"){
			$labels = $wp_post_types[$postType]->labels;
			if($optionRename != $labels->menu_name && $optionRename != ""){
					$labels->name 			= $optionRename;
					$labels->menu_name 		= $optionRename;
			}
		}
	}
}
add_action( 'init', 'mb_posttype_menu_change_label', 99 );