/**
 * 	Wir definieren BlockEditEinleitung als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 

 const BlockEditWidgetPresse = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-widget-presse-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
				key: "mbgi-widget-presse-inspectorcontrols-panelbody",
				title: "Einstellungen",
				initialOpen: true
			})
		),
		createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
			key: "mbgi-widget-presse-serversiderender",
			block: 'modulbuero/widget-presse',
		})]
	);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/widget-presse', {
    title: 'Presse Widget',
    description: 'Zeigt die neuesten Pressemitteilungen an.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
  
    edit: BlockEditWidgetPresse,
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  });