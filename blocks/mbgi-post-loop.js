const BlockEditPostLoop = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-post-loop-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-post-loop-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement(SelectControl, {
					key: "mbgi-post-loop-inspectorcontrols-panelbody-post-types",
					label: "Auswahl der Post Types",
					value: attributes.post_type,
					options: postTypes, //kommt von mbgi-post-loop.php (wp_localize_script)
					onChange: (newval) => setAttributes({ post_type: newval }),
					multiple: false,
					id: "select-post-loop",
				}),
				createElement(SelectControl, {
					key: "mbgi-post-loop-inspectorcontrols-panelbody-categories",
					label: "Auswahl der Kategorien",
					value: attributes.category,
					options: mbgi_post_loop_vars[1], //kommt von mbgi-post-loop.php (wp_localize_script)
					onChange: (newval) => setAttributes({ category: newval }),
					multiple: true,
					id: "select-category-kachelblock"
				}),
				createElement(SelectControl, {
					key: "mbgi-post-loop-inspectorcontrols-panelbody-tags",
					label: "Auswahl der Schlagwörter",
					value: attributes.tags,
					options: mbgi_post_loop_vars[2], //kommt von mbgi-post-loop.php (wp_localize_script)
					onChange: (newval) => setAttributes({ tags: newval }),
					multiple: true,
				}),
				createElement(TextControl, {
					key: "mbgi-post-loop-inspectorcontrols-panelbody-numberposts",
					label: "Anzahl der angezeigten Posts",
					type: "number",
					value: attributes.numberposts,
					onChange: (newval) => setAttributes({ numberposts: newval }),
				}),
            ]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-post-loop-serversiderender",
				block: 'modulbuero/post-loop',
				attributes: {post_type: attributes.post_type, category: attributes.category, numberposts: attributes.numberposts, tags: attributes.tags, },
				}
			)]
		);	    
}

var warn = console.warn;
console.warn = () => {};

// Hier wird der Block registriert
registerBlockType('modulbuero/post-loop', {
    title: 'Beitragskacheln',
    description: 'Ausgabe deiner Inhaltstypen in einer Kachelansicht.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    atrributes: { // custom attibutes
	    post_type: {type: 'string'},
		category: {type: 'array'},
		tags: {type: 'array'},
		numberposts: {type: 'integer'},
    },
	example: {},
    edit: BlockEditPostLoop,    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });
  
console.warn = warn;

$ = jQuery;
$(document).ready(() => {
	var kachelnBlock = 	$(".mbgi-block-post-loop");

	if($(".mbgi-block-aktuelles").length > 0){
		kachelnBlock.find(".pagination-wrap .pagination").remove();
	}else{
		kachelnBlock.find(".pagination-wrap .more").remove();
	}
	
});