const { registerBlockType } = wp.blocks;
const {__} = wp.i18n;

registerBlockType( 'fh-ooe-gutenberg/svg', {
  title: __('Inline SVG', 'fh-ooe-gutenberg'),
  icon: 'carrot',
  category: 'layout',
  attributes: {
    svg: {
      type: 'string',
      source: 'html',
      selector: '.svg-wrapper',
    },
  },
  edit(props) {
    const svg = props.attributes.svg;
    const onSvgChange = (e) => props.setAttributes({svg: e.target.value});
    return (<div className="svg-text">
      <div className="svg-wrapper" dangerouslySetInnerHTML={{__html: svg}} />
      <textarea style={{width: '100%'}} rows="5" onChange={onSvgChange}>{svg}</textarea>
    </div>);
  },
  save(props) {
    const svg = props.attributes.svg;
    return (<div className="svg-wrapper" dangerouslySetInnerHTML={{__html: svg}} />);
  },
});