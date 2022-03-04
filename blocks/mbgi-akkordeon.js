/**
 * 	Wir definieren BlockEditTeaserbox als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 

 const BlockEditAkkordeon = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
    refreshAkkordeon();
	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-akkordeon-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-akkordeon-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement(TextControl, {
					key: "mbgi-akkordeon-inspectorcontrols-panelbody-title",
					label: "Titel",
					type: "string",
					value: attributes.title,
					onChange: (newval) => setAttributes({ title: newval })
				}),
				createElement(TextareaControl, {
					key: "mbgi-akkordeon-inspectorcontrols-panelbody-description",
					label: "Beschreibung",
					type: "string",
					value: attributes.description,
					onChange: (newval) => setAttributes({ description: newval }),
				  }),
            ]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-akkordeon-serversiderender",
				block: 'modulbuero/akkordeon',
				attributes: {
					title: attributes.title, 
					description: attributes.description
				},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/akkordeon', {
    title: 'Akkordeon',
    description: 'Füge eine Aufklapptext ein.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
	    title: {type: 'string'},
	    description: {type: 'string'},
    },
  
	example: {}, // Für preview bild

    edit: BlockEditAkkordeon,
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });


function refreshAkkordeon(){
    jQuery('.mbgi-block.mbgi-block-akkordeon .akkordeon-wrap h2').off();
    jQuery('.mbgi-block.mbgi-block-akkordeon .akkordeon-wrap h2').click(function(){
        if(jQuery(this).hasClass("active")){
            jQuery(this).removeClass("active");
        }
        else{
            jQuery(this).addClass("active");
        }
    });
};