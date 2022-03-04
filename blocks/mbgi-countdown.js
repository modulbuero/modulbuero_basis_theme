var warn = console.warn;
console.warn = () => {};

const BlockEditCountdown = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-countdown-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-countdown-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement(SelectControl, {
					key: "mbgi-bildlupe-inspectorcontrols-sizes",
					label: "Design Typ",
					value: attributes.design,
					options: [
						{ label: 'Standard', value: 'typ-standard' },
						{ label: 'Event', value: 'typ-event' },
						{ label: 'Grün', value: 'typ-gruen' },
					],
					onChange: (newval) => setAttributes({ design: newval }),
					multiple: false,
				}),

				createElement(DateTimePicker, {
					key: "mbgi-countdown-inspectorcontrols-panelbody-date",
					label: "Datum",
					type: "string",
					currentDate: attributes.date,
					is12Hour: false,
					onChange: (newval) => setAttributes({ date: newval }),
				}),
				createElement(TextControl, {
					key: "mbgi-countdown-inspectorcontrols-panelbody-endmsg",
					label: "Auslauf-Nachricht",
					type: "string",
					value: attributes.endmsg,
					onChange: (newval) => setAttributes({ endmsg: newval }),
				  }),

				createElement(TextControl, {
					key: "mbgi-countdown-inspectorcontrols-panelbody-title",
					label: "Titel",
					type: "string",
					value: attributes.title,
					onChange: (newval) => setAttributes({ title: newval }),
				  }),
          
				createElement(TextControl, {
					key: "mbgi-countdown-inspectorcontrols-panelbody-link",
					label: "Link",
					type: "string",
					value: attributes.link,
					onChange: (newval) => setAttributes({ link: newval }),
				  }),
          
				  createElement(TextControl, {
					  key: "mbgi-countdown-inspectorcontrols-panelbody-linktext",
					  label: "Link-Text",
					  type: "string",
					  value: attributes.linktext,
					  onChange: (newval) => setAttributes({ linktext: newval }),
					}),
            ]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-countdown-serversiderender",
				block: 'modulbuero/countdown',
				attributes: {	date: attributes.date, 	title: attributes.title, link: attributes.link, linktext: attributes.linktext, endmsg: attributes.endmsg, design: attributes.design,	},
				}
			)]
		);	    
}

// Hier wird der Block registriert
registerBlockType('modulbuero/countdown', {
    title: 'Countdown',
    description: 'Füge einen Countdown ein.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
	    date: {type: 'string'},
	    title: {type: 'string'},
	    linktext: {type: 'string'},
	    link: {type: 'string'},
	    endmsg: {type: 'string'},
	    design: {type: 'string'},
    },
  
	  example: {},
    
    edit: BlockEditCountdown,
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }

});
console.warn = warn;