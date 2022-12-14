const  { registerBlockType } = wp.blocks;

registerBlockType('tbg/map-location', {

    //built-in attributes
    title: 'Map Location',
    description: 'Render a map with some location logic',
    icon: 'admin-site-alt',
    category: 'layout',

    // custom attributes
    attributes: {
        author:{
            type: 'string'
        }
    },
    //custom functions

    //built-in functions
    edit({ attributes, setAttributes }){

        function updateAuthor(event){
            setAttributes( { author: event.target.value } );
        }

        return <input type="text" value={attributes.author} onChange={updateAuthor}/>;
    },

    save({attributes}){
        return <span>Author: <i>{attributes.author}</i></span>
    }
})