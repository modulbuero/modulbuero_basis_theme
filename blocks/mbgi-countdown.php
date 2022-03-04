<?php
	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function(){

	    wp_enqueue_script(
	        'mbgi-countdown', //name
	        get_template_directory_uri() . '/blocks/mbgi-countdown.js',
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-countdown.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
	    
	    register_block_type('modulbuero/countdown', [
			'editor_script' => 'mbgi-countdown',
			'render_callback' => 'mb_get_countdown_block',
			'attributes' => [
				'date' => ['type' => 'string',],
				'link' => ['type' => 'string',"default" => ""],
				'linktext' => ['type' => 'string', "default" => "Hier geht's zum Link"],
				'title' => ['type' => 'string',"default" => ""],
				'design' => ['type' => 'string',"default" => "typ-standard"],
				'endmsg' => ['type' => 'string', "default" => "Es ist soweit!"],
			],
		]);
		
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_countdown_block($attr, $content) {
		$design = $attr["design"];
		$date 	= $attr["date"];
		$date 	= strtotime($date);
		$link 	= $attr["link"];
		$linktext 	= $attr["linktext"];
		$title 	= $attr["title"];
		$endmsg = $attr['endmsg'];
		$output = "<div class='mbgi-block mbgi-block-countdown centered $design' data-end-msg='$endmsg'>";
			if($design == "typ-event"){
				$output .= "<div class='green-bar'><a href='$link'><i class='far fa-clock'></i><p>Zum Event</p></a></div>";
			}
			$output .= "<div class='mbgi-block-countdown-content'>";
				$output .= "<div class='mbgi-countdown-title'>$title</div>";
				$output .= "<div class='mbgi-countdown-date centered' data-timestamp='$date'>
							<div class='mbgi-countdown-date-content'>
								<p class='days centered'>0</p>
								<p>Tage</p>
							</div>
							<div class='mbgi-countdown-date-content'>
								<p class='hours centered'>0</p>
								<p>Std.</p>
							</div>
							<div class='mbgi-countdown-date-content'>
								<p class='minutes centered'>0</p>
								<p>Min.</p>
							</div>
							<div class='mbgi-countdown-date-content'>
								<p class='seconds centered'>0</p>
								<p>Sek.</p>
							</div>
							</div>";
				$output .= "<div class='mbgi-countdown-link centered'><a href='$link'>$linktext</a></div>";
			$output .= "</div>";
		$output .= "</div>";
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_countdown_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('countdown-block-css', get_template_directory_uri() . '/blocks/mbgi-countdown.css', array('mbgi-main-style'), $version);
	
	    wp_enqueue_script(
	        'mbgi-countdown-script', //name
	        get_template_directory_uri() . '/blocks/mbgi-countdown-script.js',
	        array('jquery'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-countdown-script.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
	}
	add_action('init', 'mb_enqueue_block_countdown_style');