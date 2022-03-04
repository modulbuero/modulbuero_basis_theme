/**
 * 	Wir definieren BlockEdit als unser Container-Element für alle innenliegenden Elemente.
 *  Darin enthalten sind zum einen die Elemente des Inspectors (Settings) -> InspectorControls
 * 	und ServerSideRender, der für die Aktualisierung des Previews verantwortlich ist. 
 */ 

const BlockEdit = (props) => { //wie der block beim bearbeiten des posts angezeigt werden soll
	const { attributes, setAttributes } = props; // Hiermit können wir einfacher auf die Attribute zugreifen, die nachher in die PHP übergeben werden
	const onSelectMedia = (media) => {
		setAttributes({	bildId: media.id, bildUrl: media.url});
	};
	const removeMedia = () => {
		setAttributes({	bildId: 0, bildUrl: '' });
	};

	return createElement("div", null, // Container-Element
		[createElement(InspectorControls, {key: "mbgi-ansprechpartner-inspectorcontrols"}, // Inspector-Settings Container
			createElement(PanelBody, { // Rubrik
			key: "mbgi-ansprechpartner-inspectorcontrols-panelbody",
			title: "Einstellungen",
			initialOpen: true
			},
			[
				createElement("div", {key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div", className: "editor-post-featured-image"}, // Für Media upload
					createElement(MediaUploadCheck, {key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheck"}, 
						createElement(MediaUpload, {
							key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload",
							onSelect: onSelectMedia,
							value: attributes.bildId,
							allowedTypes: ['image'],
							render: ({open}) => 
								createElement(Button, {
									key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button",
									className: attributes.bildId == 0 ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview',
									onClick: open
									}, 
									attributes.bildId == 0 && 'Choose an image', props.media != undefined && createElement(ResponsiveWrapper, {
										key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper",
										naturalWidth: props.media.media_details.width,
										naturalHeight: props.media.media_details.height
										}, createElement("img", {key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheck-mediaupload-button-responsivewrapper-img",src: props.media.source_url})
									)
								)
							}
						)
					), attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheckreplace"}, 
							createElement(MediaUpload, {
								key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload",
								title: 'Replace image',
								value: attributes.bildId,
								onSelect: onSelectMedia,
								allowedTypes: ['image'],
								render: ({open}) => 
									createElement(Button, {
										key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheckreplace-mediaupload-button",
										onClick: open,
										isDefault: true
										}, 
										'Replace image'
									)
							})
						), 
						attributes.bildId != 0 && 
						createElement(MediaUploadCheck, {key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheckremove"}, 
							createElement(Button, {
								key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-mediauploadcheckremove-button",
								onClick: removeMedia,
								isLink: true,
								isDestructive: true
							}, 'Remove image')
						)
				), // Media Upload ende

				createElement(TextControl, {
					key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-name",
					label: "Vorname Nachname",
					type: "string",
					value: attributes.name,
					onChange: (newval) => setAttributes({ name: newval })
				}),
				createElement(TextControl, {
					key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-position",
					label: "Position",
					type: "string",
					value: attributes.position,
					onChange: (newval) => setAttributes({ position: newval })
				}),
				createElement(TextControl, {
					key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-email",
					label: "E-Mail",
					type: "string",
					value: attributes.email,
					onChange: (newval) => setAttributes({ email: newval })
				}),
				createElement(TextControl, {
					key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-tel",
					label: "Telefonnummer",
					type: "string",
					value: attributes.tel,
					onChange: (newval) => setAttributes({ tel: newval })
				}),
				createElement(TextControl, {
					key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-fax",
					label: "Faxnummer",
					type: "string",
					value: attributes.fax,
					onChange: (newval) => setAttributes({ fax: newval })
				}),
				createElement(TextControl, {
					key: "mbgi-ansprechpartner-inspectorcontrols-panelbody-div-sonst",
					label: "Sonstiges",
					type: "string",
					value: attributes.sonst,
					onChange: (newval) => setAttributes({ sonst: newval })
				}),]
			)),
			createElement(ServerSideRender, { // Übergibt die Daten der PHP und rendert diese neu. ACHTUNG! Alle Attribute hier eintragen die übertragen werden sollen!
				key: "mbgi-ansprechpartner-serversiderender",
				block: 'modulbuero/ansprechpartner',
				attributes: {name: attributes.name, position: attributes.position, email: attributes.email, sonst: attributes.sonst, tel: attributes.tel, fax: attributes.fax, bildId: attributes.bildId, bildUrl: attributes.bildUrl},
				}
			)]
		);	    
}

// Hier wird der Block dann registriert
registerBlockType('modulbuero/ansprechpartner', {
    title: 'Ansprechpartner',
    description: 'Füge Ansprechpartner ein. Für das Bild nutze bitte das Bildformat 16/9 für optimale Ergebnisse.',
    icon: sonnenblume,
    category: 'modulbuero',
    supports: {align: true},
    atrributes: { // custom attibutes
	    name: {type: 'string'},
	    position: {type: 'string'},
	    email: {type: 'string'},
	    tel: {type: 'string'},
	    fax: {type: 'string'},
		bildId: {type: 'number'},
		bildUrl: {type: 'string'},
		sonst: {type: 'string'},
    },
	example: {},
	
    edit: withSelect((select, props) => {
			return { media: props.attributes.bildId ? select('core').getMedia(props.attributes.bildId) : undefined }; // Macht das Media-Objekt in unserer Block-Struktur (BlockEdit) verfügbar
		})(BlockEdit),
    
    save: function(props) { //wie der block abgespeichert werden soll --> tatsächliche anzeige später
      return null; // Wird über PHP gelöst durch 'render_callback'!
    }
  
  });