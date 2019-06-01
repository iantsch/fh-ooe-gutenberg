const { registerBlockType } = wp.blocks;
const { MediaUpload } = wp.editor;
const { Button } = wp.components;
const {__} = wp.i18n;

registerBlockType( 'fh-ooe-gutenberg/svg', {
  title: __('Image or Svg', 'fh-ooe-gutenberg'),
  icon: 'carrot',
  category: 'layout',
  attributes: {
    attachmentId: {
      type: 'string',
      attribute: 'data-id',
      selector: '.svg-or-img',
    },
    attachmentUrl: {
      type: 'string',
    },
  },
  edit({attributes, className, setAttributes}) {
    const getImageButton = (openEvent) => {
      if(attributes.attachmentUrl) {
        return (
          <img
            src={ attributes.attachmentUrl }
            onClick={ openEvent }
            className="image"
          />
        );
      }
      else {
        return (
          <div className="button-container">
            <Button
              onClick={ openEvent }
              className="button button-large"
            >
              {__('Select an image','fh-ooe-gutenberg')}
            </Button>
          </div>
        );
      }
    };
    return (
      <MediaUpload
        onSelect={ media => { console.log(media); setAttributes({ attachmentUrl: media.url, attachmentId: media.id }); } }
        type="image"
        value={ attributes.attachmentId }
        render={ ({ open }) => getImageButton(open) } />
    );
  },
  save({attributes: {attachmentId, attachmentUrl}, className}) {
    return (<figure className={className}>
      <img className="svg-or-img" data-id={attachmentId} src={attachmentUrl} />
    </figure>);
  },
});