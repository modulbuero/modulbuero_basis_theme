var warn = console.warn;
console.warn = () => {};

// Hier wird der Block registriert
registerBlockType('modulbuero/aktuelles', {
    title: 'Aktuelles',
    description: 'Einen Block, der die aktuellen Beiträge und Pressemitteilungen zeigt.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},

    example: {}, // Für preview bild
    
    edit: function(props) { //wie der block beim bearbeiten des posts angezeigt werden soll
    	return createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
			block: 'modulbuero/aktuelles',
		});
    },
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
});

console.warn = warn;