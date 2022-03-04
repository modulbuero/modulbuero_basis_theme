/**
 * 	Wir definieren BlockEditEinleitung als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 

 const BlockEditWidgetTermine = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-widget-termine-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
				key: "mbgi-widget-termine-inspectorcontrols-panelbody",
				title: "Einstellungen",
				initialOpen: true
			})
		),
		createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
			key: "mbgi-widget-termine-serversiderender",
			block: 'modulbuero/widget-termine',
		})]
	);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/widget-termine', {
    title: 'Termine Widget',
    description: 'Zeigt die aktuellen und zukünftigen Termine an.',
    icon: modulbuero_logo,
    category: 'modulbuero',
    supports: {align: true},
  
    edit: BlockEditWidgetTermine,
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  });