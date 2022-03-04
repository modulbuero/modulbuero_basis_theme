/**
 * 	Wir definieren BlockEditStoerer als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */

const BlockEditStoerer = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-stoerer-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-stoerer-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement(TextControl, {
	                key: "mbgi-stoerer-inspectorcontrols-panelbody-title",
					label: "Titel",
					type: "string",
					value: attributes.title,
					onChange: (newval) => setAttributes({ title: newval })
				}),
				createElement(TextareaControl, {
	                key: "mbgi-stoerer-inspectorcontrols-panelbody-description",
					label: "Beschreibung",
					type: "string",
					value: attributes.description,
					onChange: (newval) => setAttributes({ description: newval }),
				  }),
				  createElement(TextControl, {
					  key: "mbgi-stoerer-inspectorcontrols-panelbody-panelbody-buttonlink",
					  label: "Link",
					  type: "string",
					  value: attributes.buttonLink,
					  onChange: (newval) => setAttributes({ buttonLink: newval })
				  }),
            ]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-stoerer-serversiderender",
				block: 'modulbuero/stoerer',
				attributes: {
					title: attributes.title, 
					description: attributes.description, 
					buttonLink: attributes.buttonLink, 
				},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/stoerer', {
    title: 'Störer',
    description: 'Füge eine Störer ein. Eine verlinkte Box mit Titel und Beschreibung. Taucht fixiert auf der Seite auf.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    atrributes: { // custom attibutes
	    title: {type: 'string'},
	    description: {type: 'string'},
	    buttonLink: {type: 'string'},
    },
	
	example: {}, // Für preview bild

    edit: BlockEditStoerer,
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });



  $ = jQuery;
  // Config
  let timeout = 5000;
  let className = "active";
  
  $(document).ready(() => {
	if($("body.wp-admin").length > 0) return;
	var stoerer = $(".mbgi-block-stoerer");
	if(stoerer.length < 1) return;
	stoerer.find(".stoerer-close").click(() => stoerer.removeClass(className));
	setTimeout(()=> stoerer.addClass(className), timeout);
  });