/**
 *
 *  "Einleitung" wurde umbenannt in "Grüner Absatz"
 *  Dir Klassen und Variablen heißen hier noch ..einleitung Im Editor ist der Block aber under "Grüner Absatz" zu finden
 *  20210920@bvd
 *
 */

/**
 * 	Wir definieren BlockEditEinleitung als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 

 const BlockEditEinleitung = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-einleitung-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-einleitung-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement(TextareaControl, {
					key: "mbgi-einleitung-inspectorcontrols-panelbody-text",
					label: "Text",
					type: "string",
					value: attributes.text,
					onChange: (newval) => setAttributes({ text: newval }),
				  }),
            ]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-einleitung-serversiderender",
				block: 'modulbuero/einleitung',
				attributes: {text: attributes.text},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/einleitung', {
    title: 'Grüner Absatz',
    description: 'Füge einen forformatierten Text ein, der sich optisch hervorhebt.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
	    text: {type: 'string'},
    },
  
	example: {},

    edit: BlockEditEinleitung,
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  });