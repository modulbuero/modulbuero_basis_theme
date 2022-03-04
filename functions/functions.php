<?php
/** **************************************** *
 *	Thumbnail Breite
 *	fullwidth or not fullwidth
 *	Thats the questin
 */
function thumbnail_fullwidth_or_not($postID, $type="page"){

	$id			= $postID;
	$optionType	= 'mb_fullwidh_thumb_'.$type;	
	$thumbnailwrapper = "";
	$postType	= get_post_type($postID);
	
	if($postType == $type && $postType == "post"){
		$showFullWidh = true;
	}elseif($postType != "page" && $postType != "post"){
		$showFullWidh = true;
	}else{
		$showFullWidh = false;	
	}

	if(has_post_thumbnail($id)):
		$thumbnailwrapper = "<div class='thumb-wrap'>";
			$thumbnailwrapper .= "<div class='thumbnail' style='background-image: url(". get_the_post_thumbnail_url($id,'full').");'></div>";
			$thumbnailwrapper .= "<p class='copyright'>".get_post_meta($id,'mbgi-thumbnail-copyright', true)."</p>";
		$thumbnailwrapper .= "</div>";
	endif;
	
	return $thumbnailwrapper;
}

/** **************************************** *
*	Custom Auszug
*/
function mb_excerpt_length($length){
	return $length*3;
}
function mb_excerpt_length_verwante($length){
	return $length*2;
}
function mb_excerpt_length_themen($length){
	return $length*0.7;
}
function mb_cut_excerpt($excerpt, $length = 520){
	$new_excerpt = $excerpt;
	if(strlen($excerpt)>$length){
		$new_excerpt = substr($excerpt,0,$length);
		$tmp = explode(" ",$new_excerpt);
		unset($tmp[array_key_last($tmp)]);
		$new_excerpt = implode(" ",$tmp)." [...]"; 
	}
	return $new_excerpt;
}

function wp_example_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'wp_example_excerpt_length');


/** **************************************** *
 *	Breadcrumbs
 */
function mb_get_breadcrumb() {
	if ( is_front_page() ) return;
	
	echo "<ul class='breadcrumbs'>";
		echo '<li><a href="'.get_home_url().'">Home</a></li>';
		
		if (is_archive()){
			echo "<li> > ".get_the_archive_title()."</li>";
		}
		elseif(is_single()){
			$type = get_post_type_object(get_post_type());
			echo "<li> > <a href='".get_post_type_archive_link(get_post_type())."'>$type->label</a></li>";
			echo "<li> > ".get_the_title()."</li>";
		} 
		elseif (is_page()) {
			echo "<li> > ".get_the_title()."</li>";
		} 
		elseif (is_search()) {
			echo "<li> > Suche: ";
				echo the_search_query();
			echo '</li>';
		}
		elseif (is_home()) { //aktuelles bzw. blog page
			echo "<li> > Aktuelles </li>";
		}
	echo "</ul>";
}

/** **************************************** *
 *	Entfernen des Archive Type im Titel
 */
add_filter( 'get_the_archive_title', function ($title) {    
    if ( is_category() ) {    
            $title = single_cat_title( '', false );    
        } elseif ( is_tag() ) {    
            $title = single_tag_title( '', false );    
        } elseif ( is_author() ) {    
            $title = '<span class="vcard">' . get_the_author() . '</span>' ;    
        } elseif ( is_tax() ) { //for custom post types
            $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title( '', false );
        }
    return $title;    
});

/** **************************************** *
 * 	Gibt alle Custom Post Types zurück. Auch die, die unregistered sind 
 */
function mb_get_all_custom_post_types(){
    $registered_post_types = get_post_types(array('_builtin' => false, 'show_ui' => true));
    $unregistered_post_types = $GLOBALS['unregistered_post_types'] ?? array();
    $all_post_types = $registered_post_types;
    foreach($unregistered_post_types as $post_type){
        array_push($all_post_types, $post_type);
    }
    return $all_post_types;
}

/** **************************************** *
 * 	gibt ein post_type object als array zurück 
 */
function mb_post_type_object_to_array($post_type){
    $obj = $GLOBALS['post_type_object_'.$post_type];
    $labels = array(
        'name' 					=> $obj->labels->name,
        'singular_name' 		=> $obj->labels->singular_name,
        'menu_name' 			=> $obj->labels->menu_name,
        'all_items' 			=> $obj->labels->all_items,
        'add_new' 				=> $obj->labels->add_new,
        'add_new_item' 			=> $obj->labels->add_new_item,
        'edit' 					=> $obj->labels->edit,
        'edit_item' 			=> $obj->labels->edit_item,
        'new_item' 				=> $obj->labels->new_item,
        'view_item' 			=> $obj->labels->view_item,
        'search_items' 			=> $obj->labels->search_items,
        'not_found' 			=> $obj->labels->not_found,
        'not_found_in_trash' 	=> $obj->labels->not_found_in_trash,
        'parent_item_colon' 	=> '',
    );
    $args = array(
        'label'                     => $obj->label,
        'labels'                    => $labels,
        'public'                    => $obj->public,
        'publicly_queryable' 		=> $obj->publicly_queryable,
        'exclude_from_search' 		=> $obj->exclude_from_search,
        'show_ui' 					=> $obj->show_ui,
        'query_var' 				=> $obj->query_var,
        'menu_position' 			=> $obj->menu_position,
        'menu_icon' 				=> $obj->menu_icon,
        'rewrite'					=> $obj->rewrite,
        'has_archive' 				=> $obj->has_archive,
        'taxononmies'               => $obj->taxonomies,
);
return $args;
}


/** **************************************** *
 * 	ShareButton, Teilen
 */
function mb_share_buttons() {
	global $post;
	$string="";
	$url = site_url() . $_SERVER['REQUEST_URI'];
	if($url) {
		$mobileClass = wp_is_mobile(  ) ? "mobile" : "";
		$string .= '<div class="social-media-buttons">';
			$string .= '<a href="https://www.facebook.com/share.php?u=' . urlencode($url) . '" title="Bei Facebook teilen" class="facebook"><i class="fab fa-facebook"></i></a>';
			$string .= '<a href="https://twitter.com/home?status=' . urlencode($post->post_title) . ' - ' . urlencode($url) . '" title="Bei Twitter teilen" class="twitter"><i class="fab fa-twitter-square"></i></a>';
			$string .= '<a href="#" class="twitter whatsapp-share '.$mobileClass.'" data-url="'.urlencode($url).'" title="Bei WhatsApp teilen"><i class="fab fa-whatsapp"></i></a>';
			$string .= '</div>';
	}
	
	return $string;
}

/** **************************************** *
 * ordnet die Abgeordneten nach Listenplatz in der Archiv-Ansicht
 */
function bvd_orderAbgeordneteInArchive( $query ) {
    if( is_post_type_archive('abgeordnete') ) {
        $query->set('orderby', 'meta_value_num');
        $query->set('meta_key', 'mbgi-abgeordnete-listenplatz');
        $query->set('order', 'ASC');
    }
    return $query;
}
add_action('pre_get_posts', 'bvd_orderAbgeordneteInArchive');


/** **************************************** *
 * Bei Customposttyps Archivseiten ohne Menü
 */
function mak_fix_nav_menu( $query ) {
    if ( $query->get( 'post_type' ) === 'nav_menu_item' ) {
    	$query->set( 'tax_query', '' );
	    $query->set( 'meta_key', '' );
	    $query->set( 'orderby', '' );
    }
}
add_action( 'pre_get_posts', 'mak_fix_nav_menu' );

/** **************************************** *
 * Konvertiert Freitext Telefonnummern in das E.164-Format
 */ 
function convertPhone($tel) {
	$result = preg_replace('/[^0-9+]*/', '', $tel); //alles außer zahlen und '+' entfernen
	$result = preg_replace('/\+*(0)+49(0)*/', '+49', $result); //abfangen von +049 +0049 049 0049 etc.
	if (substr($result, 0, 1) === '+') { //erstes zeichen ist ein '+'
		if (substr_count($result, '+') === 1) { //es ist das einzige '+' im string
			return $result;
		} else { //es gibt nach dem ersten '+' noch weitere '+'-zeichen im string
			return "+" . str_replace('+', '', $result); //alle '+'-zeichen nach dem ersten entfernen
		}
	} elseif (substr($result, 0, 1) === '0' && substr($result, 0, 2) !== '00') { //erstes zeichen ist eine '0' und keine Verbindung ins Ausland ('00')
		$result = str_replace('+', '', $result); //alle '+'-zeichen entfernen
		return substr_replace($result, '+49', 0, 1); //erste '0' durch '+49' ersetzen
	}
	return $result;
}

function mb_dump_file($var, $filename){
	ob_start(); 
	var_dump($var); 
	$debug_file_content = ob_get_clean(); 
	ob_end_clean(); 
	$debug_file = fopen(get_template_directory() . "/debug-logs/$filename.txt", 'w'); 
	fwrite($debug_file, $debug_file_content); 
	fclose($debug_file); 
}
