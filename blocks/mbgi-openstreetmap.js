// Hier wird der Block registriert
registerBlockType('modulbuero/openstreetmap', {
    title: 'OpenStreetMap',
    description: 'Füge eine Karte ein.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
	    street: {type: 'string'},
	    postalcode: {type: 'string'},
	    city: {type: 'string'},
	    country: {type: 'string'},
    },
  
	example: {},
    edit: function(props) {
    
    	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
		
		return createElement("div", null, // Container-Element
			[createElement(InspectorControls, {key: "mbgi-openstreetmap-inspectorcontrols"}, // Inspector-Settings Container
				createElement(PanelBody, { // Rubrik
				key: "mbgi-openstreetmap-inspectorcontrols-panelbody",
				title: "Einstellungen",
				initialOpen: true
				},
				[
					createElement(TextControl, {
						key: "mbgi-openstreetmap-inspectorcontrols-panelbody-street",
						label: "Straße und Hausnummer",
						type: "string",
						value: attributes.street,
						onChange: (newval) => setAttributes({ street: newval })
					}),
					createElement(TextControl, {
						key: "mbgi-openstreetmap-inspectorcontrols-panelbody-postalcode",
						label: "PLZ",
						type: "string",
						value: attributes.postalcode,
						onChange: (newval) => setAttributes({ postalcode: newval })
					}),
					createElement(TextControl, {
						key: "mbgi-openstreetmap-inspectorcontrols-panelbody-city",
						label: "Stadt",
						type: "string",
						value: attributes.city,
						onChange: (newval) => setAttributes({ city: newval })
					}),
					createElement(TextControl, {
						key: "mbgi-openstreetmap-inspectorcontrols-panelbody-country",
						label: "Land (zweistelliges Länderkürzel, z.B. 'de' für Deutschland)",
						type: "string",
						value: attributes.country,
						onChange: (newval) => setAttributes({ country: newval })
					}),	
	            ]
				)),
				createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
					key: "mbgi-openstreetmap-serversiderender",
					block: 'modulbuero/openstreetmap',
					attributes: {street: attributes.street, postalcode: attributes.postalcode, city: attributes.city, country: attributes.country, },
				})
			]
		);
	},
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
    	return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });
