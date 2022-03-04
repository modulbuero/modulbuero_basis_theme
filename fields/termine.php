<?php
	function mbgi_register_termine_meta_box() {
    	add_meta_box( 'termin', 'Termin', 'mbgi_termine_callback', 'termin' , 'normal','high' );
	}
	add_action( 'add_meta_boxes', 'mbgi_register_termine_meta_box' );
	
	/* Ausgabe der Metabox im Post Type Termin */
	function mbgi_termine_callback( $post ) {
		?>
		
		<script>
			jQuery(document).ready(function() {
				jQuery("#mbgi-meta-termin-online-checkbox").change(function () {
					jQuery(".mbgi-termin-adresse").toggle();
					jQuery(".mbgi-meta-termin-link").toggle();
				});
				jQuery("#mbgi-meta-termin-ganztags-checkbox").change(function () {
					jQuery("#mbgi-meta-termin-startzeit").toggle();
					jQuery("#mbgi-meta-termin-endzeit").toggle();
				});
			});
		</script>
		
    	<div class="mbgi-termine-meta-box" style="display: flex;">
	    	<div class="mbgi-datum-wrap">
			    <p class="mbgi-meta-termin-startdatum">
			        <label for="mbgi-meta-termin-startdatum">Startdatum</label>
			        <input
			        	id="mbgi-meta-termin-startdatum"
						type="date"
						name="mbgi-meta-termin-startdatum"
						value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-startdatum', true)); ?>">
					<input
			        	id="mbgi-meta-termin-startzeit"
						type="time"
						name="mbgi-meta-termin-startzeit"
						value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-startzeit', true)); ?>"
						<?php if (esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-ganztags-checkbox', true)) == 'on') echo 'style="display: none;"'; ?>>
			    </p>
			    <p class="mbgi-meta-termin-enddatum">
			        <label for="mbgi-meta-termin-enddatum">Enddatum</label>
			        <input
			        	id="mbgi-meta-termin-enddatum"
			        	type="date"
			        	name="mbgi-meta-termin-enddatum"
			        	value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-enddatum', true)); ?>">
					<input
			        	id="mbgi-meta-termin-endzeit"
			        	type="time"
			        	name="mbgi-meta-termin-endzeit"
			        	value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-endzeit', true)); ?>"
						<?php if (esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-ganztags-checkbox', true)) == 'on') echo 'style="display: none;"'; ?>>
			    </p>
	    	</div>
			<p class="mbgi-meta-termin-ganztags-checkbox">
				<label for="mbgi-meta-termin-ganztags-checkbox">Ganztags?</label>
				<input
					id="mbgi-meta-termin-ganztags-checkbox"
					type="checkbox"
					name="mbgi-meta-termin-ganztags-checkbox"
					<?php checked(esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-ganztags-checkbox', true)), 'on'); ?> >
			</p>
	    	<div class="mbgi-termin-adresse-wrap">
		    	<div class="mbgi-termin-online-wrap">
			    	<p class="mbgi-meta-termin-online-checkbox">
				    	<label for="mbgi-meta-termin-online-checkbox">Online?</label>
				    	<input
				    		id="mbgi-meta-termin-online-checkbox"
				    		type="checkbox"
				    		name="mbgi-meta-termin-online-checkbox"
				    		<?php checked(esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-online-checkbox', true)), 'on'); ?> >
			    	</p>
			    	<p class="mbgi-meta-termin-link" <?php if (esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-online-checkbox', true)) !== 'on') echo 'style="display: none;"'; ?> >
				    	<label for="mbgi-meta-termin-link" class="mbgi-termin-link">Link</label>
				    	<input
				    		id="mbgi-meta-termin-link"
				    		class="mbgi-termin-link mbgi-input"
				    		type="text"
				    		name="mbgi-meta-termin-link"
				    		value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'mbgi-meta-termin-link', true ) ); ?>">
			    	</p>
		    	</div>
		    	<div class="mbgi-termin-adresse" <?php if (esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-online-checkbox', true)) == 'on') echo 'style="display: none;"'; ?>>
				    <p class="mbgi-meta-termin-strasse">
				        <label for="mbgi-meta-termin-strasse" class="mbgi-termin-adresse">Straße</label>
				        <input
				        	id="mbgi-meta-termin-strasse"
							class="mbgi-input"
				        	type="text"
				        	name="mbgi-meta-termin-strasse"
				        	value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'mbgi-meta-termin-strasse', true ) ); ?>">
				    </p>
				    <p class="mbgi-meta-termin-plz">
				        <label for="mbgi-meta-termin-plz" class="mbgi-termin-adresse">PLZ</label>
				        <input
				        	id="mbgi-meta-termin-plz"
							class="mbgi-input"
				        	type="text"
				        	name="mbgi-meta-termin-plz"
				        	value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'mbgi-meta-termin-plz', true ) ); ?>">
				    </p>
				    <p class="mbgi-meta-termin-stadt">
				        <label for="mbgi-meta-termin-stadt" class="mbgi-termin-adresse">Stadt</label>
				        <input
				        	id="mbgi-meta-termin-stadt"
							class="mbgi-input"
				        	type="text"
				        	name="mbgi-meta-termin-stadt"
				        	value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'mbgi-meta-termin-stadt', true ) ); ?>">
				    </p>
		    	</div>
				<p class="mbgi-termin-ical-wrap">
					<label for="mbgi-meta-termin-ical">iCal-Datei erstellen und anbieten?</label>
					<input
						id="mbgi-meta-termin-ical"
						type="checkbox"
						name="mbgi-meta-termin-ical"
						<?php checked(esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-ical', true)), 'on'); ?> >
		    	
				</p>
				
				<p class="mbgi-termin-repeat-wrap">
					<label for="mbgi-meta-termin-repeat">Wöchentlich wiederholen?</label>
					<input
						id="mbgi-meta-termin-repeat"
						type="checkbox"
						name="mbgi-meta-termin-repeat"
						<?php checked(esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-repeat', true)), 'on'); ?> >
				</p>
	    	</div>
	    	
			
<!--
	    	<div class="mbgi-veranstaltung-wrap">
	    		<label for="mbgi-meta-termin-veranstaltung">Veranstaltung?</label>
	    		<input
	    			id="mbgi-meta-termin-veranstaltung"
	    			type="checkbox"
	    			name="mbgi-meta-termin-veranstaltung"
			    	<?php checked(esc_attr(get_post_meta(get_the_ID(), 'mbgi-meta-termin-veranstaltung', true)), 'on'); ?> >
	    	</div>
-->
		</div>
				
		<?php } 
	
	/* Metabox-Fields als Meta-Felder in Termine abspeichern wenn man den Post sichert */
	function mbgi_save_termine_meta_box( $post_id ) {
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	    
	    if(get_post_type($post_id) == 'termin'){
	    
	    	if ( $parent_id = wp_is_post_revision( $post_id ) ) {
				$post_id = $parent_id;
		    }
		    $fields = [
		        'mbgi-meta-termin-startdatum',
		        'mbgi-meta-termin-startzeit',
		        'mbgi-meta-termin-enddatum',
		        'mbgi-meta-termin-endzeit',
		        'mbgi-meta-termin-ganztags-checkbox',
		        'mbgi-meta-termin-online-checkbox',
		        'mbgi-meta-termin-link',
		        'mbgi-meta-termin-strasse',
		        'mbgi-meta-termin-plz',
		        'mbgi-meta-termin-stadt',
		        'mbgi-meta-termin-ical',
		        'mbgi-meta-termin-repeat',
		        //'mbgi-meta-termin-veranstaltung',
		    ];
		    foreach ( $fields as $field ) {
		        if ( array_key_exists( $field, $_POST ) ) {
		            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
		        } else if (($field == 'mbgi-meta-termin-repeat' OR 'mbgi-meta-termin-online-checkbox' OR $field == 'mbgi-meta-termin-ical' OR $field == 'mbgi-meta-termin-veranstaltung' OR $field == 'mbgi-meta-termin-ganztags-checkbox') AND empty($_POST[$field])) {
			        update_post_meta($post_id, $field, '');
		        }
		    }
		    
		    if (isset($_POST["mbgi-meta-termin-ical"]) && $_POST["mbgi-meta-termin-ical"]) { //checkbox ical checked
				function formatDateTime($date) {
					$year = date('Y', $date);
					$month = date('m', $date);
					$day = date('d', $date);
					$hour = date('H', $date);
					$minute = date('i', $date);
					$second = date('s', $date);
					return $year . $month . $day . "T" . $hour . $minute . $second;
				}
				
				$ical = fopen(WP_CONTENT_DIR . '/ical/termin-' . get_the_ID() . '.ical', 'w') or die ('Cannot open ical event file.');
				$ics = fopen(WP_CONTENT_DIR . '/ical/termin-' . get_the_ID() . '.ics', 'w') or die ('Cannot open ical event file.');
				$eol = "\r\n";
				$now = formatDateTime(strtotime(date("YmdHis")));
				$content = 
					"BEGIN:VCALENDAR".$eol.
					"VERSION:2.0".$eol.
					"PRODID:Gruene//Termin".$eol.
					"BEGIN:VEVENT".$eol.
					"UID:".$now."@".get_site_url().$eol.
					"DTSTAMP:".$now.$eol.
					"DTSTART:".formatDateTime(strtotime($_POST['mbgi-meta-termin-startdatum'])).$eol.
					"DTEND:".formatDateTime(strtotime($_POST['mbgi-meta-termin-enddatum'])).$eol.
					"SUMMARY:".get_the_title().$eol.
					"LOCATION:".$_POST['mbgi-meta-termin-strasse'].", ".$_POST['mbgi-meta-termin-plz']." ".$_POST['mbgi-meta-termin-stadt'].$eol.
					"END:VEVENT".$eol.
					"END:VCALENDAR";
				
				fwrite($ical, $content);
				fwrite($ics, $content);
				fclose($ical);
				fclose($ics);
			}
	    }
	}
	add_action( 'save_post', 'mbgi_save_termine_meta_box' );