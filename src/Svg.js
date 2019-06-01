const {ToggleControl, PanelBody} = wp.components;
const {createHigherOrderComponent} = wp.compose;
const {Fragment} = wp.element;
const {InspectorControls} = wp.editor;
const {__} = wp.i18n;

function modifyImageBlocks(settings, name) {
  if (blocksToModify.indexOf(name) === -1) {
    return settings;
  }

  settings.attributes.svgInline = {
    type: 'bool',
    default: false
  };

  settings.attributes.svg = {
    type: 'bool',
    default: false
  };

  return settings;
}

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'fh-ooe-gutenberg/modify-image-blocks',
  modifyImageBlocks
);

wp.hooks.addFilter(
  'SvgControls.core.media-text.urlAttribute',
  'fh-ooe-gutenberg/modify-media-text-url',
  () => 'mediaUrl'
);

const SvgControls = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    let urlAttribute = 'url';
    urlAttribute = wp.hooks.applyFilters(`SvgControls.${props.name.replace('/', '.')}.urlAttribute`, 'url');
    if (
      blocksToModify.indexOf(props.name) === -1 || !(props.attributes.hasOwnProperty(urlAttribute) && props.attributes[urlAttribute].match(/\.svg$/i))
    ) {
      if (props.attributes.svg) {
        props.setAttributes({svg: false});
      }
      return (<BlockEdit {...props} />);
    }
    if (!props.attributes.svg) {
      props.setAttributes({svg: true});
    }
    return (
      <Fragment>
        <BlockEdit {...props} />
        <InspectorControls>
          <PanelBody title={__('✨ SVG', 'fh-ooe-gutenberg')}>
            <ToggleControl instanceId="svg_inline" label={__('Display inline', 'fh-ooe-gutenberg')}
                           checked={props.attributes.svgInline}
                           onChange={() => props.setAttributes({svgInline: !props.attributes.svgInline})}/>
          </PanelBody>
        </InspectorControls>
      </Fragment>
    );
  };
}, "SvgControls");

wp.hooks.addFilter('editor.BlockEdit', 'fh-ooe-gutenberg/controls', SvgControls);