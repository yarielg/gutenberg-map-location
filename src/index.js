const  { registerBlockType } = wp.blocks;
const  { RichText, InspectorControls, ColorPalette,  } = wp.editor;
const  { PanelBody  } = wp.components;

registerBlockType('tbg/map-location', {

    //built-in attributes
    title: 'Map Location',
    description: 'Render a map with some location logic',
    icon: 'admin-site-alt',
    category: 'layout',

    // custom attributes
    attributes: {
        title:{
            type: 'string',
            source: 'html',
            selector: 'h2'
        },
        body: {
            type: 'string',
            source: 'html',
            selector: 'p'
        },
        titleColor:{
            type: 'string',
            default: '#000000'
        }
    },

    //built-in functions
    edit({ attributes, setAttributes }){

        const { title, body, titleColor } = attributes;

        //custom functions
        function onChangeTitle(newTitle){
            setAttributes( { title: newTitle } );
        }

        function onChangeBody(newBody){
            setAttributes( { body: newBody } );
        }

        function onTitleColorChange(newColor){
            setAttributes( { titleColor : newColor } );
        }

        return ([
            <InspectorControls style={ {marginBottom: '40px'} }>
                <PanelBody title={ 'Font Color Settings' }>
                    <p><strong>Select a Title Color:</strong> </p>
                    <ColorPalette value={ titleColor } onChange={ onTitleColorChange }></ColorPalette>
                </PanelBody>
            </InspectorControls>,
            <div class="cta-container">
                <RichText key="editable"
                          tagName="h2"
                          placeholder="Your CTA title"
                          value={title}
                          onChange={onChangeTitle}
                          style={ { color: titleColor } }  />
                <RichText key="editable"
                          tagName="p"
                          placeholder="Your CTA Description"
                          value={body}
                          onChange={onChangeBody}/>
            </div>
        ]);
    },

    save({ attributes }){

        const { title, body, titleColor } = attributes;

        return (
            <div class="cta-container">
                <h2 style={ { color: titleColor } }>{ title }</h2>
                <RichText.Content tag="p" value={body} />
            </div>
        );
    }
})