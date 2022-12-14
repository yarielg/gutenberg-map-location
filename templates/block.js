( function ( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'tbg-blocks/map-location', {
        edit: function (attributes, setAttributes) {
            return el( 'p', {},  'Hello');
        },
        save: function () {
            return null;
        },
    } );
} )( window.wp.blocks, window.wp.element );

/*(function ( blocks, element) {

    const blockConfig = {
        title: 'Map Location',
        icon: 'admin-site-alt',
        category: 'widgets',
        attributes: {   // The data this block will be storing
            type: { type: 'string', default: 'default' },   // Notice box type for loading the appropriate CSS class. Default class is 'default'.
            title: { type: 'string' },   // Notice box title in h4 tag
        },
        edit: function(props) {
            // How our block renders in the editor in edit mode

            function updateTitle( event ) {
                props.setAttributes( { title: event.target.value } );
            }
            /!*function updateContent( newdata ) {
                props.setAttributes( { content: newdata } );
            }*!/
            function updateType( event ) {
                props.setAttributes( { type: event.target.value } );
            }
            return wp.element.createElement( 'div',
                {
                    className: 'notice-box notice-' + props.attributes.type
                },
                wp.element.createElement(
                    'select',
                    {
                        onChange: updateType,
                        value: props.attributes.type,
                    },
                    wp.element.createElement("option", {value: "default" }, "Default"),
                    wp.element.createElement("option", {value: "success" }, "Success"),
                    wp.element.createElement("option", {value: "danger" }, "Danger")
                ),
                wp.element.createElement(
                    'input',
                    {
                        type: 'text',
                        placeholder: 'Enter title here...',
                        value: props.attributes.title,
                        onChange: updateTitle,
                        style: { width: '100%' }
                    }
                )
            ); // End return
        }, // End edit()
        save: function(props) {
            // How our block renders on the frontend

            return null; /!*wp.element.createElement( 'div',
                {
                    className: 'notice-box notice-' + props.attributes.type
                },
                wp.element.createElement(
                    'h4',
                    null,
                    props.attributes.title
                ),
                wp.element.createElement(
                    wp.editor.RichText.Content,
                    {
                        tagName: 'p',
                        value: props.attributes.content
                    }
                )

            ); *!/

        } // End save()
    };

    wp.blocks.registerBlockType('tbg-blocks/map-location', blockConfig);

})(window.wp.blocks, window.wp.element);*/

