 const BlockEditThemenSlider = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	return createElement("div", null, // Container-Element
		[
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-themen-slider-serversiderender",
				block: 'modulbuero/themen-slider',
				attributes: {},
				}
			)]
		);	    
}

var warn = console.warn;
console.warn = () => {};

// Hier wird der Block registriert
registerBlockType('modulbuero/themen-slider', {
    title: 'Themen-Slider',
    description: 'Füge deine Themen als Slider ein.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
    },
    example: {},
    edit: BlockEditThemenSlider,    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
});

console.warn = warn;