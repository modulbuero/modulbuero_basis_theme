<?php
/* meta box registrieren */
add_action('admin_init', 'mb_add_meta_box_mb_verlinkung', 1);
function mb_add_meta_box_mb_verlinkung() {
	$inhaltstypen = ['medien', 'slider', 'kunden'];
	add_meta_box( 'mb_verlinkung', 'Verlinkung', 'mb_add_meta_box_mb_verlinkung_html', $inhaltstypen, 'normal','high' );
}


/* Metabox HTML gerüst*/
function mb_add_meta_box_mb_verlinkung_html() {
	global $post; // um einfacher auf die ID zuzugreifen
	$mb_verlinkung = get_post_meta($post->ID, 'mb_verlinkung', true); //alle gespeicherten presselinks für den post holen
	wp_nonce_field( 'mb_meta_fields_mb_verlinkung_nonce', 'mb_meta_fields_mb_verlinkung_nonce' ); // nonce stuff
	?>

	<script type="text/javascript">
		/*
        jQuery(document).ready(function( $ ){
            $( '#add-row' ).on('click', function() {
                var row = $( '.empty-row.screen-reader-text' ).clone(true); // das hier ist eine versteckte row die wir dann klonen
                row.removeClass( 'empty-row screen-reader-text' ); // die geklonte klasse soll angezeigt werden, also nicht mehr klasse entfernen
                row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' ); // vor der letzten (unsichtbaren) row einfügen
            });
        
            $( '.remove-row' ).on('click', function() {
                $(this).parents('tr').remove(); // row einfach entfernen
            });
        });
		*/
	</script>
  
	<table id="repeatable-fieldset-one" width="100%">
	<thead>
		<tr>
			<th width="40%">Beschreibung</th>
			<th width="40%">Link-Adresse</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if ( $mb_verlinkung ){ // falls schon links gespeichert wurden 
        foreach ( $mb_verlinkung as $field ) { // dementsprechend rows erzeugen mit dem inhalt
        ?>
        <tr>
            <td><input type="text" class="widefat" name="title[]" value="<?php if($field['title'] != '') echo esc_attr( $field['title'] ); ?>" /></td>
            <td><input type="text" class="widefat" name="url[]" value="<?php if ($field['url'] != '') echo esc_attr( $field['url'] ); else echo 'https://'; ?>" /></td>
            <!--<td><a class="button remove-row" href="#">Löschen</a></td>-->
        </tr>
        <?php
        }
    }else{
        // ansonsten eine leere row anzeigen
        ?>
        <tr>
            <td><input type="text" class="widefat" name="title[]" /></td>
            <td><input type="text" class="widefat" name="url[]" value="http://" /></td>
            <!--<td><a class="button remove-row" href="#">Löschen</a></td>-->
        </tr>
	<?php
    }
    ?>
	
	<!-- das hier ist die versteckte row die immer geklont wird und ganz am ende der tabelle steht -->
	<tr class="empty-row screen-reader-text">
		<td><input type="text" class="widefat" name="title[]" /></td>
		<td><input type="text" class="widefat" name="url[]" value="http://" /></td>
		<td><a class="button remove-row" href="#">Löschen</a></td>
	</tr>
	</tbody>
	</table>
	
	<!--<p><a id="add-row" class="button" href="#">Link hinzufügen</a></p>-->
<?php
}


function mb_save_meta_fields_mb_verlinkung($post_id) {
	if (!isset( $_POST['mb_meta_fields_mb_verlinkung_nonce'] ) ||! wp_verify_nonce( $_POST['mb_meta_fields_mb_verlinkung_nonce'], 'mb_meta_fields_mb_verlinkung_nonce' ))
		return; // wenn im $_POST nichts über die metafields steht, nichts machen
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
	
	if (!current_user_can('edit_post', $post_id))
		return;
	
	$old = get_post_meta($post_id, 'mb_verlinkung', true); // alte werte holen für die überprüfung nachher
	$new = array(); // neue felder, die nachher hinzugefügt werden
	
	$titles = $_POST['title']; // hier sind alle titles drin
	$urls = $_POST['url']; // hier sind alle links drin
	
	$count = count( $titles ); // anzahl titles ist gleich anzahl links, für die for wichtig
	
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $titles[$i] != '' ) : // wenn titles an der bestimmten position gesetzt ist
			$new[$i]['title'] = stripslashes( strip_tags( $titles[$i] ) ); // zu dem new array hinzufügen
			if ( $urls[$i] == 'http://' )
				$new[$i]['url'] = ''; // falls url nur der standardwert ist, empty string eintragen
			else
				$new[$i]['url'] = stripslashes( $urls[$i] ); // sonst den wert eintragen
		endif;
	}
    /* wenn der new array nicht leer ist und nicht unverändert ist */
	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'mb_verlinkung', $new ); // array abspeichern
	elseif ( empty($new) && $old ) // falls der neue leer ist, im alten aber was drinstand
		delete_post_meta( $post_id, 'mb_verlinkung', $old ); // alte sachen rauslöschen
}
add_action('save_post', 'mb_save_meta_fields_mb_verlinkung');