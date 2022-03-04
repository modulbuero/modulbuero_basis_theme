var warn = console.warn;
console.warn = () => {};

// Hier wird der Block registriert
registerBlockType('modulbuero/termine', {
    title: 'Termine',
    description: 'Füge die neusten 3 Termine ein. Inkl. verlinkung zu allen Terminen.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
  
	  example: {},
    
    edit: function(props) { //wie der block beim bearbeiten des posts angezeigt werden soll
    	return createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
			block: 'modulbuero/termine',
		});
    },
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }

});

console.warn = warn;