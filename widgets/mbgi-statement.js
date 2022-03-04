/**
 * 	Wir definieren BlockEdit als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 

 const BlockEditStatement = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	const onSelectMedia = (media) => {
		setAttributes({	bildId: media.id, bildUrl: media.url});
	};
	const removeMedia = () => {
		setAttributes({	bildId: 0, bildUrl: '' });
	};

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-statement-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-statement-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement("div", {key: "mbgi-statement-inspectorcontrols-panelbody-div", className: "editor-post-featured-image"}, // Für Media upload
					createElement(MediaUploadCheck, {key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheck"}, 
						createElement(MediaUpload, {
							key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload",
							onSelect: onSelectMedia,
							value: attributes.bildId,
							allowedTypes: ['image'],
							render: ({open}) => 
								createElement(Button, {
									key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button",
									className: attributes.bildId == 0 ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview',
									onClick: open
									}, 
									attributes.bildId == 0 && 'Choose an image', props.media != undefined && createElement(ResponsiveWrapper, {
										key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper",
										naturalWidth: props.media.media_details.width,
										naturalHeight: props.media.media_details.height
										}, createElement("img", {key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper-img",src: props.media.source_url})
									)
								)
							}
						)
					), attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheckreplace"}, 
							createElement(MediaUpload, {
								key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload",
								title: 'Replace image',
								value: attributes.bildId,
								onSelect: onSelectMedia,
								allowedTypes: ['image'],
								render: ({open}) => 
									createElement(Button, {
										key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload-button",
										onClick: open,
										isSecondary: true
										}, 
										'Replace image'
									)
							})
						), 
						attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheckremove"}, 
							createElement(Button, {
								key: "mbgi-statement-inspectorcontrols-panelbody-div-mediauploadcheckremove-button",
								onClick: removeMedia,
								isLink: true,
								isDestructive: true
							}, 'Remove image')
						)
				), // Media Upload ende

				createElement(TextControl, {
					key: "mbgi-statement-inspectorcontrols-panelbody-div-titel",
					label: "Titel",
					type: "string",
					value: attributes.titel,
					onChange: (newval) => setAttributes({ titel: newval })
				}),
				createElement(TextControl, {
					key: "mbgi-statement-inspectorcontrols-panelbody-div-beschreibung",
					label: "Beschreibung",
					type: "string",
					value: attributes.beschreibung,
					onChange: (newval) => setAttributes({ beschreibung: newval })
				})]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-statement-serversiderender",
				block: 'modulbuero/statement',
				attributes: {titel: attributes.titel, beschreibung: attributes.beschreibung, bildId: attributes.bildId, bildUrl: attributes.bildUrl},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/statement', {
    title: 'Statement',
    description: 'Zeigt ein rundes Bild mit einem Statement darunter.',
    icon: modulbuero_logo,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
	    titel: {type: 'string'},
	    beschreibung: {type: 'string'},
		bildId: {type: 'number'},
		bildUrl: {type: 'string'},
    },
  
    edit: withSelect((select, props) => {
			return { media: props.attributes.bildId ? select('core').getMedia(props.attributes.bildId) : undefined }; // Macht das Media-Objekt in unserer Block-Struktur (BlockEdit) verfügbar
		})(BlockEditStatement),
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });