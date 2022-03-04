<?php
	
	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function() {
		wp_register_script(
	        'mbgi-ansprechpartner', //name
	        get_template_directory_uri() . '/blocks/mbgi-ansprechpartner.js', //pfad zur js
	        array('mbgi-block-lib'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-ansprechpartner.js'), // Version aktualisiert sich mit dem Änderungsdatum
	        );
	        
		register_block_type('modulbuero/ansprechpartner', [
			'editor_script' => 'mbgi-ansprechpartner',
			'render_callback' => 'mb_get_ansprechpartner_block',
			'attributes' => [
				'name' => [
					'type' => 'string',
					'default' => 'Max Mustermann'
				],
				'position' => [
					'type' => 'string',
					'default' => 'Mustermacher'
				],
				'email' => [
					'type' => 'string',
					'default' => 'max@mustermann.de'
				],
				'tel' => [
					'type' => 'string',
					'default' => '01234/56798'
				],
				'fax' => [
					'type' => 'string',
					'default' => '9876/54321'
				],
				'bildId' => [
					'type' => 'number',
					'default' => 0
				],
				'bildUrl' => [
					'type' => 'string',
					'default' => get_template_directory_uri() . '/blocks/mbgi-teaserbox-bild.png'
				],
				'sonst' => [
					'type' => 'string',
					'default' => ''
				],

			]
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_ansprechpartner_block($attr, $content) {

		$name = $attr['name'];
		$position = $attr['position'];
		$email = $attr['email'];
		$tel = $attr['tel'];
		$fax = $attr['fax'];
		$tel = $attr['tel'];
		$bildUrl = $attr['bildUrl'];
		$sonst = $attr['sonst'];
		
		$output = "<div class='mbgi-block mbgi-block-ansprechpartner'>";
			
			$output .= "<div class='mbgi-ansprechpartner-bild' style='background-image: url($bildUrl);'></div>";
			$output .= "<div class='mbgi-ansprechpartner-info'>";
				$output .= "<p class='mbgi-ansprechpartner-name'>$name</p>";
				if (!empty($position)) {
					$output .= "<p class='mbgi-ansprechpartner-position'>$position</p>";
				}
				if (!empty($email)) {
					$output .= "<p class='mbgi-ansprechpartner-email'><a href='mailto:$email'>$email</a></p>";
				}
				if (!empty($tel)) {
					$output .= "<p class='mbgi-ansprechpartner-tel'><a href='tel:". convertPhone($tel) ."'>Tel.: $tel</a></p>";
				}
				if (!empty($fax)) {
					$output .= "<p class='mbgi-ansprechpartner-fax'>Fax: $fax</p>";
				}
				if (!empty($sonst)) {
					$output .= "<p class='mbgi-ansprechpartner-sonst'>$sonst</p>";
				}
			$output .= "</div>";
		$output .= "</div>";
		
		return $output;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_ansprechpartner_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('ansprechpartner-block-css', get_template_directory_uri() . '/blocks/mbgi-ansprechpartner.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mb_enqueue_block_ansprechpartner_style');