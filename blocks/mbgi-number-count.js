/**
 * 	Wir definieren BlockEditTeaserbox als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 
const options=[];
options[0] = [];
options[0]['label'] = "Nichts";
options[0]['value'] = "";
options[1] = [];
options[1]['label'] = "€";
options[1]['value'] = "€";
options[2] = [];
options[2]['label'] = "%";
options[2]['value'] = "%";

 const BlockEditNumberCount = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-number-count-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-number-count-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement(TextControl, {
					key: "mbgi-number-count-inspectorcontrols-panelbody-title",
					label: "Titel",
					type: "string",
					value: attributes.title,
					onChange: (newval) => setAttributes({ title: newval })
				}),
				createElement(TextareaControl, {
					key: "mbgi-number-count-inspectorcontrols-panelbody-description",
					label: "Beschreibung",
					type: "string",
					value: attributes.description,
					onChange: (newval) => setAttributes({ description: newval }),
				  }),
				  createElement(TextControl, {
					  key: "mbgi-number-count-inspectorcontrols-panelbody-current",
					  label: "Aktueller Wert",
					  type: "number",
					  value: attributes.current,
					  onChange: (newval) => setAttributes({ current: newval }),
					}),
					createElement(TextControl, {
						key: "mbgi-number-count-inspectorcontrols-panelbody-goal",
						label: "Zielwert",
						value: attributes.goal,
						type: "number",
						onChange: (newval) => setAttributes({ goal: newval }),
					  }),
					  createElement(SelectControl, {
						  key: "mbgi-number-count-inspectorcontrols-panelbody-einheit",
						  label: "Einheit",
						  type: "string",
						  value: attributes.einheit,
						  options: options,
						  onChange: (newval) => setAttributes({ einheit: newval }),
						}),
            ]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-number-count-serversiderender",
				block: 'modulbuero/number-count',
				attributes: {
					title: attributes.title, 
					description: attributes.description,
					current: attributes.current,
					goal: attributes.goal,
					einheit: attributes.einheit,
				},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/number-count', {
    title: 'Zähler Block',
    description: 'Füge einen Zähler hinzu.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
	    title: {type: 'string'},
	    description: {type: 'string'},
	    current: {type: 'number'},
	    goal: {type: 'number'},
	    einheit: {type: 'string'},
    },
  
	example: {}, // Für preview bild

    edit: BlockEditNumberCount,
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });


  // FUNKTIONALITÄT
  $ = jQuery;
  $(document).ready(()=>{

  });