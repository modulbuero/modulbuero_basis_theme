<?php
/** **************************************** *
 * Includes all files in a folder.
 * @param $path	string(default=none)
 * the path from the theme to the folder. Example: "/blocks/"
 * @param $ending string(default="")
 * check if the folder has a $ending folder in it. Example: "post" -> loads from "/blocks/post/". If no file were loaded, it loads the standard path
 */
function get_template_parts($path, $ending = ""){
	/* typesafe machen */
	if(!endsWith($path, "/")){ 
		$path .= "/";
	}
	if(is_dir(get_stylesheet_directory() . $path)){
		$path = get_stylesheet_directory() . $path;
	}else{
		$path = get_template_directory() . $path;
	}
	$normal_path = $path;	// wir speichern uns den path für später
	$path .= $ending . (empty($ending) ? "" : "/");	// wir erweitern den path um das ending. => "path / ending /", falls $ending gesetzt ist.
	$files = file_exists($path) ? scandir($path) : array(); // scannen nach files im path
	$count = 0; // zählt wie viele dateien reingeladen werden
	foreach($files as $file){
		if(mb_strpos($file,".php") !== false){ // wenn es sich bei der file um eine php handelt
			include_once $path . $file; // reinladen
			$count++; // zähler erhöhen
		}
	}

	if($count == 0){ // falls nichts reingeladen wurde, verwenden wir den standard-pfad und laden von dort alles rein. zb wenn es den post-type ordner nicht gibt.
		$path = $normal_path;
		$files = scandir($path);
		foreach($files as $file){
			if(mb_strpos($file,".php") !== false){
				include_once $path . $file;
			}
		}
	}
}

// Für PHP Version < 8.0
function endsWith($haystack, $needle) { // Für PHP < V8.0
	$length = strlen($needle);
	return $length > 0 ? substr($haystack, -$length) === $needle : true;
}

// überprüft ob files reingeladen werden
function has_template_parts($path, $post_type = ""){
	if(!endsWith($path, "/")){
		$path .= "/";
	}
	
	if(is_dir(get_stylesheet_directory() . $path)){
		$path = get_stylesheet_directory() . $path;
	}else{
		$path = get_template_directory() . $path;
	}
	$normal_path = $path;
	$path .= $post_type . (empty($post_type) ? "" : "/");
	$files = file_exists($path) ? scandir($path) : array();
	foreach($files as $file){
		if(mb_strpos($file,".php") !== false){
			return true;
		}
	}
	$files = scandir($normal_path);
	foreach($files as $file){
		if(mb_strpos($file,".php") !== false){
			return true;
		}
	}
	
	return false;
}

/*
	inhalte von functions folder laden
*/
if(has_template_parts("/functions/")){
	get_template_parts("/functions/");
}
if( is_child_theme() === true ){
	if(has_template_parts("/functions_child/")){
		get_template_parts("/functions_child/");
	}
}

