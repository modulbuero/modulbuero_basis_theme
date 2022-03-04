const BlockEditSocialmedia = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	return createElement("div", null, // Container-Element
		[
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-socialmedia-serversiderender",
				block: 'modulbuero/socialmedia',
				attributes: {title: attributes.title, description: attributes.description},
				}
			)]
		);	    
}


// Hier wird der Block dann registriert
registerBlockType('modulbuero/socialmedia', {
    title: 'Socialmedia',
    description: 'Füge deine Verlinkungen der Socialmedia Portale ein.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    atrributes: { // custom attibutes
	    title: {type: 'string'},
	    description: {type: 'string'},
    },
  
    example: {},
    
    edit: BlockEditSocialmedia,
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });
