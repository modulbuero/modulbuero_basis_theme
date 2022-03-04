/**
 * 	Wir definieren $BlockEditbildlupe als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 

const $BlockEditbildlupe = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	const onSelectMedia = (media) => {
		setAttributes({	bildId: media.id});
	};
	const removeMedia = () => {
		setAttributes({	bildId: 0});
	};

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-bildlupe-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-bildlupe-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				
				createElement(SelectControl, {
					key: "mbgi-bildlupe-inspectorcontrols-sizes",
					label: "Thumbnail-Größen",
					value: attributes.size ?? "mbgi-thumb-568",
					options: mbgiThumbnailSizes, //kommt von mbgi-bild-lupe.php (wp_localize_script)
					onChange: (newval) => setAttributes({ size: newval }),
					multiple: false,
				}),
				createElement("div", {key: "mbgi-bildlupe-inspectorcontrols-panelbody-div", className: "editor-post-featured-image"}, // Für Media upload
					createElement(MediaUploadCheck, {key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheck"}, 
						createElement(MediaUpload, {
							key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload",
							onSelect: onSelectMedia,
							value: attributes.bildId,
							allowedTypes: ['image'],
							render: ({open}) => 
								createElement(Button, {
									key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button",
									className: attributes.bildId == 0 ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview',
									onClick: open
									}, 
									attributes.bildId == 0 && 'Choose an image', props.media != undefined && createElement(ResponsiveWrapper, {
										key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper",
										naturalWidth: props.media.media_details.width,
										naturalHeight: props.media.media_details.height
										}, createElement("img", {key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper-img",src: props.media.source_url})
									)
								)
							}
						)
					), attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheckreplace"}, 
							createElement(MediaUpload, {
								key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload",
								title: 'Replace image',
								value: attributes.bildId,
								onSelect: onSelectMedia,
								allowedTypes: ['image'],
								render: ({open}) => 
									createElement(Button, {
										key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload-button",
										onClick: open,
										isDefault: true
										}, 
										'Replace image'
									)
							})
						), 
						attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheckremove"}, 
							createElement(Button, {
								key: "mbgi-bildlupe-inspectorcontrols-panelbody-div-mediauploadcheckremove-button",
								onClick: removeMedia,
								isLink: true,
								isDestructive: true
							}, 'Remove image')
						)
				), // Media Upload ende
            ]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-bildlupe-serversiderender",
				block: 'modulbuero/bild-lupe',
				attributes: {bildId: attributes.bildId, size: attributes.size,},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/bild-lupe', {
    title: 'Bild mit Lupe',
    description: 'Füge eine Vorschaubild ein, das mit klick groß wird. (Lightbox)',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
		bildId: {type: 'number'},
		size: {type: 'string'},
    },
  
	example: {},
	
    edit: withSelect((select, props) => {
			return { media: props.attributes.bildId ? select('core').getMedia(props.attributes.bildId) : undefined }; // Macht das Media-Objekt in unserer Block-Struktur ($BlockEditbildlupe) verfügbar
		})($BlockEditbildlupe),
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });