const  { registerBlockType } = wp.blocks;
const  { RichText } = wp.editor;

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
        }
    },

    //built-in functions
    edit({ attributes, setAttributes }){

        const { title, body } = attributes;

        //custom functions
        function onChangeTitle(newTitle){
            setAttributes( { title: newTitle } );
        }

        function onChangeBody(NewBody){
            setAttributes( { body: NewBody } );
        }

        return ([
            <div class="cta-container">
                <RichText key="editable"
                          tagName="h2"
                          placeholder="Your CTA title"
                          value={title}
                          onChange={onChangeTitle}/>
                <RichText key="editable"
                          tagName="p"
                          placeholder="Your CTA Description"
                          value={body}
                          onChange={onChangeBody}/>
            </div>
        ]);
    },

    save({ attributes }){

        const { title, body } = attributes;

        return (
            <div class="cta-container">
                <h2>{ title }</h2>
                <RichText.Content tag="p" value={body} />
            </div>
        );
    }
})