/**
 * 	Wir definieren BlockEditTeaserbox als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */

const BlockEditTeaserbox = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	const onSelectMedia = (media) => {
		setAttributes({	bildId: media.id, bildUrl: media.url});
	};
	const removeMedia = () => {
		setAttributes({	bildId: 0, bildUrl: '' });
	};

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-teaserbox-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-teaserbox-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement("div", {key: "mbgi-teaserbox-inspectorcontrols-panelbody-div", className: "editor-post-featured-image"}, // Für Media upload
					createElement(MediaUploadCheck, {key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheck"}, 
						createElement(MediaUpload, {
							key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload",
							onSelect: onSelectMedia,
							value: attributes.bildId,
							allowedTypes: ['image'],
							render: ({open}) => 
								createElement(Button, {
									key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button",
									className: attributes.bildId == 0 ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview',
									onClick: open
									}, 
									attributes.bildId == 0 && 'Choose an image', props.media != undefined && createElement(ResponsiveWrapper, {
										key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper",
										naturalWidth: props.media.media_details.width,
										naturalHeight: props.media.media_details.height
										}, createElement("img", {key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper-img",src: props.media.source_url})
									)
								)
							}
						)
					), attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheckreplace"}, 
							createElement(MediaUpload, {
								key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload",
								title: 'Replace image',
								value: attributes.bildId,
								onSelect: onSelectMedia,
								allowedTypes: ['image'],
								render: ({open}) => 
									createElement(Button, {
										key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload-button",
										onClick: open,
										isDefault: true
										}, 
										'Replace image'
									)
							})
						), 
						attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheckremove"}, 
							createElement(Button, {
								key: "mbgi-teaserbox-inspectorcontrols-panelbody-div-mediauploadcheckremove-button",
								onClick: removeMedia,
								isLink: true,
								isDestructive: true
							}, 'Remove image')
						)
				), // Media Upload ende

				createElement(TextControl, {
	                key: "mbgi-teaserbox-inspectorcontrols-panelbody-title",
					label: "Titel",
					type: "string",
					value: attributes.title,
					onChange: (newval) => setAttributes({ title: newval })
				}),
				createElement(TextareaControl, {
	                key: "mbgi-teaserbox-inspectorcontrols-panelbody-description",
					label: "Beschreibung",
					type: "string",
					value: attributes.description,
					onChange: (newval) => setAttributes({ description: newval }),
				  }),
                createElement(PanelBody, { // Rubrik
	                key: "mbgi-teaserbox-inspectorcontrols-panelbody-panelbody",
                    title: "Button",
                    initialOpen: true
                    },
                    [
                        createElement(TextControl, {
	                        key: "mbgi-teaserbox-inspectorcontrols-panelbody-panelbody-buttonlabel",
                            label: "Button-Label",
                            type: "string",
                            value: attributes.buttonLabel,
                            onChange: (newval) => setAttributes({ buttonLabel: newval })
                        }),
						createElement(TextControl, {
	                        key: "mbgi-teaserbox-inspectorcontrols-panelbody-panelbody-buttonlink",
                            label: "Button-Link",
                            type: "string",
                            value: attributes.buttonLink,
                            onChange: (newval) => setAttributes({ buttonLink: newval })
                        }),
                    ]
                    ),
            ]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-teaserbox-serversiderender",
				block: 'modulbuero/teaserbox',
				attributes: {
					title: attributes.title, 
					description: attributes.description, 
					buttonLabel: attributes.buttonLabel, 
					buttonLink: attributes.buttonLink, 
					bildId: attributes.bildId, 
					bildUrl: attributes.bildUrl},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/teaserbox', {
    title: 'Teaserbox',
    description: 'Füge eine Teaserbox ein. Eine Box mit Bild, Text und verlinktem Button.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    atrributes: { // custom attibutes
	    title: {type: 'string'},
	    description: {type: 'string'},
	    buttonLabel: {type: 'string'},
	    buttonLink: {type: 'string'},
		bildId: {type: 'number'},
		bildUrl: {type: 'string'},
    },
	
	example: {}, // Für preview bild

    edit: withSelect((select, props) => {
			return { media: props.attributes.bildId ? select('core').getMedia(props.attributes.bildId) : undefined }; // Macht das Media-Objekt in unserer Block-Struktur (BlockEditTeaserbox) verfügbar
		})(BlockEditTeaserbox),
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });