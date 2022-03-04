/**
 * 	Wir definieren BlockEdit als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 

 const BlockEditBildLink = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	const onSelectMedia = (media) => {
		setAttributes({	bildId: media.id, bildUrl: media.url});
	};
	const removeMedia = () => {
		setAttributes({	bildId: 0, bildUrl: '' });
	};

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-bildlink-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-bildlink-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement("div", {key: "mbgi-bildlink-inspectorcontrols-panelbody-div", className: "editor-post-featured-image"}, // Für Media upload
					createElement(MediaUploadCheck, {key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheck"}, 
						createElement(MediaUpload, {
							key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload",
							onSelect: onSelectMedia,
							value: attributes.bildId,
							allowedTypes: ['image'],
							render: ({open}) => 
								createElement(Button, {
									key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button",
									className: attributes.bildId == 0 ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview',
									onClick: open
									}, 
									attributes.bildId == 0 && 'Choose an image', props.media != undefined && createElement(ResponsiveWrapper, {
										key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper",
										naturalWidth: props.media.media_details.width,
										naturalHeight: props.media.media_details.height
										}, createElement("img", {key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper-img",src: props.media.source_url})
									)
								)
							}
						)
					), attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheckreplace"}, 
							createElement(MediaUpload, {
								key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload",
								title: 'Replace image',
								value: attributes.bildId,
								onSelect: onSelectMedia,
								allowedTypes: ['image'],
								render: ({open}) => 
									createElement(Button, {
										key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload-button",
										onClick: open,
										isSecondary: true
										}, 
										'Replace image'
									)
							})
						), 
						attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheckremove"}, 
							createElement(Button, {
								key: "mbgi-bildlink-inspectorcontrols-panelbody-div-mediauploadcheckremove-button",
								onClick: removeMedia,
								isLink: true,
								isDestructive: true
							}, 'Remove image')
						)
				), // Media Upload ende

				createElement(TextControl, {
					key: "mbgi-bildlink-inspectorcontrols-panelbody-div-link",
					label: "Link",
					type: "string",
					value: attributes.link,
					onChange: (newval) => setAttributes({ link: newval })
				})]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-bildlink-serversiderender",
				block: 'modulbuero/bildlink',
				attributes: {link: attributes.link, bildId: attributes.bildId, bildUrl: attributes.bildUrl},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/bildlink', {
    title: 'Bild mit Link',
    description: 'Zeigt ein Bild an, worauf ein Link hinterlegt ist.',
    icon: modulbuero_logo,
    category: 'modulbuero',
    supports: {align: true},
    attributes: { // custom attibutes
	    link: {type: 'string'},
		bildId: {type: 'number'},
		bildUrl: {type: 'string'},
    },
  
    edit: withSelect((select, props) => {
			return { media: props.attributes.bildId ? select('core').getMedia(props.attributes.bildId) : undefined }; // Macht das Media-Objekt in unserer Block-Struktur (BlockEdit) verfügbar
		})(BlockEditBildLink),
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });