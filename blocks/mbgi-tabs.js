/**
 * 	Wir definieren $BlockEdittabs als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 
const $BlockEdittabs = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-tabs-inspectorcontrols"}, // Inspector-Settings Container
			[
			createElement(PanelBody, { // Rubrik
			key: "mbgi-tabs-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement(SelectControl, {
					key: "mbgi-post-loop-inspectorcontrols-panelbody-categories",
					label: "Auswahl der Gruppe",
					value: attributes.category,
					options: mbgiTabs_posts, //kommt von mbgi-post-loop.php (wp_localize_script)
					onChange: (newval) => setAttributes({ category: newval }),
					multiple: true,
					id: "select-category-tabblock"
				}),
            ]
			),
		]),

			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-tabs-serversiderender",
				block: 'modulbuero/tabs',
				attributes: {category: attributes.category, style: attributes.style,},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/tabs', {
    title: 'Tabs-Block',
    description: 'Strukturiere Inhalt innerhalb von Tabs.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
		style: {type: 'string'},
		category: {type: 'array'},
    },
  
	example: {},
	
    edit: $BlockEdittabs,
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });