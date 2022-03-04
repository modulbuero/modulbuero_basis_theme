const BlockEditPostLoopPresseWidget = (props) => { 	//wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; 	// Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	var allowedCustomPostTypes;

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-post-loop-inspectorcontrols"},
			createElement(PanelBody, { // Rubrik
			key: "mbgi-presse-widget-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement(SelectControl, {
					key: "mbgi-presse-widget-inspectorcontrols-panelbody-categories",
					label: "Auswahl der Kategorien",
					value: attributes.category,
					options: mbgi_post_loop_vars[1], //kommt von mbgi-post-loop.php (wp_localize_script)
					onChange: (newval) => setAttributes({ category: newval }),
					multiple: true,
				}),
				createElement(TextControl, {
					key: "mbgi-presse-widget-inspectorcontrols-panelbody-numberposts",
					label: "Anzahl der angezeigten Posts",
					type: "number",
					value: attributes.numberposts,
					onChange: (newval) => setAttributes({ numberposts: newval }),
				}),
            ]
			)),
			createElement(ServerSideRender, { 
				// Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-presse-widget-serversiderender",
				block: 'modulbuero/presse-widget',
				attributes: {post_type: attributes.post_type, category: attributes.category, numberposts: attributes.numberposts, tags: attributes.tags, },
				}
			)]
		);	    
}

var warn = console.warn;
console.warn = () => {};

// Hier wird der Block registriert
registerBlockType('modulbuero/presse-widget', {
    title: 'Pressemitteilungen',
    description: 'gibt eine Liste der Pressemitteilungen in der Sidebar aus',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    atrributes: { // custom attibutes
		category: {type: 'array'},
		numberposts: {type: 'integer'},
    },
	example: {},
    edit: BlockEditPostLoopPresseWidget,    
    save: function(props) { 	//wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null;	 			// Wird über PHP gelöst durch 'render_callback'!
    }
  
  });
  
console.warn = warn;