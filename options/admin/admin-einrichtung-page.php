<?php
/** **************************************** *
 *	Neuer Menüpunkt "Einrichtung"
 */
function mb_register_admin_menu() {
	add_menu_page( __('Admin-Einrichtung','modulbuero'),
	__('Admin-Einrichtung','modulbuero'), 
	'manage_options', 
	'admin-einrichtung', 
	'callback_admin_einrichtung_html', 
	'dashicons-heart', 
	'62' 
	);
	
	function callback_admin_einrichtung_html(){
	?>
		<h1>Stellen Sie hier noch einige Optionen für das Theme ein.</h1>
		<ul>
			<li>
				<a href="?page=mb_libraries_options">Bibliotheken</a>
			</li>
			<li>
				<a href="?page=mb_posttypesrename_options">Umbenennen der Inhaltstypen</a>
			</li>
			<li>
				<a href="?page=mb_posttypes_options">Aktivieren der Inhaltstypen</a>
			</li>
		</ul>
	<?php
	}
}
add_action( 'admin_menu', 'mb_register_admin_menu' );