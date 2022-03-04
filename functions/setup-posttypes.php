<?php
/**
 * Get MB PostTyps vor activation
 * 
 * Logic dür Aktivierung: options/admin/posttypes
 * */
if(has_template_parts("/mb-post-types/")){
    get_template_parts("/mb-post-types/");
}

/**
 * automatisches laden der ChildTheme Posttypes
 * */
if( is_child_theme() === true ){
	if(has_template_parts("/post-types/")){
	    get_template_parts("/post-types/");
	}
}