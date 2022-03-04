 const BlockEditSlider = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-slider-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-slider-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement(SelectControl, {
					key: "mbgi-slider-inspectorcontrols-panelbody-interval",
					label: "Slideinterval",
					type: "string",
					value: attributes.interval,
					options: [
					    {
					      label: "5s",
					      value: "5000"
					    },
					    {
					      label: "6s",
					      value: "6000"
					    },
					    {
					      label: "7s",
					      value: "7000"
					    },
					    {
					      label: "8s",
					      value: "8000"
					    },
					    {
					      label: "9s",
					      value: "9000"
					    },
					    {
					      label: "10s",
					      value: "10000"
					    },
					    {
					      label: "11s",
					      value: "11000"
					    },
					    {
					      label: "12s",
					      value: "12000"
					    },
					    {
					      label: "13s",
					      value: "13000"
					    },
					    {
					      label: "14s",
					      value: "14000"
					    },
					    {
					      label: "15s",
					      value: "15000"
					    }
					  ],
					onChange: (newval) => setAttributes({ interval: newval })
				}),
/*
				createElement(CheckboxControl, {
					label: "Titel anzeigen",
					help: "Titel im Slider anzeigen oder nicht",
					checked: attributes.title,
					onChange: (newval) => setAttributes({title: newval})
				  }),
*/
            ]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-slider-serversiderender",
				block: 'modulbuero/slider',
				attributes: {interval: attributes.interval/* , title: attributes.title */},
				}
			)]
		);	    
}


var warn = console.warn;
console.warn = () => {};

// Hier wird der Block registriert
registerBlockType('modulbuero/slider', {
    title: 'Slider',
    description: 'Füge einen Slider ein. Grundlage sind die Einträge aus dem Inhaltstyp Slider Elements.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    atrributes: { // custom attibutes
	    interval: {type: 'string'},
// 		title: {type: 'boolean'},
    },
	example: {},
	
    edit: BlockEditSlider,    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });
  
console.warn = warn;