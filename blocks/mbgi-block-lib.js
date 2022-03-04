const { DatePicker, NumberControl, TimePicker, DateTimePicker, TextControl, ToggleControl, SelectControl, ColorPicker, CheckboxControl, TextareaControl, PanelBody, PanelRow, Button, ResponsiveWrapper } = wp.components;
const { registerBlockType } = wp.blocks;
const { ServerSideRender } = wp.editor;
const { createElement } = wp.element;
const { InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { withSelect } = wp.data;

// Import __ from i18n internationalization library
const { __ } = wp.i18n;
// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;
const sonnenblume =  el('svg', {viewBox: "0 0 86.01 116.4"},
  el('path', {d: "M18.6,40.9c2.7,0,4.8,2.2,4.8,4.8v24.8c0,2.7-2.2,4.8-4.8,4.8H4.8c-2.7,0-4.8-2.2-4.8-4.8V45.8c0-2.7,2.2-4.8,4.8-4.8H18.6z"}),
  el('path', {d: "M50.1,0c2.7,0,4.8,2.2,4.8,4.8v24.8c0,2.7-2.2,4.8-4.8,4.8H36.3c-2.7,0-4.8-2.2-4.8-4.8V4.8c0-2.7,2.2-4.8,4.8-4.8H50.1z"}),
  el('path', {d: "M81.3,81.9c2.7,0,4.8,2.2,4.8,4.8v24.8c0,2.7-2.2,4.8-4.8,4.8H67.6c-2.7,0-4.8-2.2-4.8-4.8V86.7c0-2.7,2.2-4.8,4.8-4.8H81.3z"}),
  el('path', {d: "M81.3,40.9c2.7,0,4.8,2.2,4.8,4.8v24.8c0,2.7-2.2,4.8-4.8,4.8H67.6c-2.7,0-4.8-2.2-4.8-4.8V45.8c0-2.7,2.2-4.8,4.8-4.8H81.3z"}),
);