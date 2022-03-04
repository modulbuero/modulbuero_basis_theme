<?php

function get_locked_blocks(){
    $blocks = array();
    $blocks["Bild mit Lupe"] = "modulbuero/bild-lupe"; 		// ID des Blocks
    $blocks["Countdown"] = "modulbuero/countdown";
    $blocks["Reden-Loop"] = "modulbuero/reden-widget";
    $blocks["Presse-Loop"] = "modulbuero/presse-widget";
    $blocks["Medien-Loop"] = "modulbuero/medien-widget";
    $blocks["Tabs-Block"] = "modulbuero/tabs";
    $blocks["Akkordeon"] = "modulbuero/akkordeon";
    $blocks["Aktuelles"] = "modulbuero/aktuelles";
    $blocks["Ansprechpartner"] = "modulbuero/ansprechpartner";
    $blocks["Bild mit Button"] = "modulbuero/bild-button";
    $blocks["Einleitung"] = "modulbuero/einleitung";
    $blocks["Zähler-Block (requires GSAP)"] = "modulbuero/number-count";
    $blocks["OpenStreetMap"] = "modulbuero/openstreetmap";
    $blocks["Post Loop"] = "modulbuero/post-loop";
    $blocks["Slider"] = "modulbuero/slider";
    $blocks["Social Media"] = "modulbuero/socialmedia";
    $blocks["Störer"] = "modulbuero/stoerer";
    $blocks["Teaserbox"] = "modulbuero/teaserbox";
    $blocks["Termine"] = "modulbuero/termine";
    $blocks["Bild mit Link"] = "modulbuero/bildlink";
    $blocks["Statement"] = "modulbuero/statement";
    $blocks["Themen-Slider"] = "modulbuero/themen-slider";
    $blocks["Termine Widget"] = "modulbuero/widget-termine";
    $blocks["Presse Widget"] = "modulbuero/widget-presse";
    $blocks["Kontaktformular"] = "modulbuero/kontaktformular";
    $blocks["Abgeordnete"] = "modulbuero/abgeordnete";

    return $blocks;
}


function mb_filter_blocks(){
	global $pagenow;
	global $post;
    $blocks = array();
    $block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
    
    foreach($block_types as $key => $block){
        $blocks[] = $key;
    }

	foreach(get_locked_blocks() as $block){
		if($pagenow == "widgets.php"){
			$option = get_option('mbgi_unlock_blocks_option_'.$block."_widgets");
			if($option != "on"){
				unset($blocks[array_search($block, $blocks)]);
			}
		}
		else if($post->post_type == "page"){
			$option = get_option('mbgi_unlock_blocks_option_'.$block."_page");
			if($option != "on"){
				unset($blocks[array_search($block, $blocks)]);
			}
		}else{
			$option = get_option('mbgi_unlock_blocks_option_'.$block."_post");
			if($option != "on"){
				unset($blocks[array_search($block, $blocks)]);
			}
		}
        
	}

    sort($blocks);
	return $blocks;
}
add_filter( 'allowed_block_types_all', 'mb_filter_blocks', 1 );
