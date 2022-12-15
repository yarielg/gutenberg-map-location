const  { registerBlockType } = wp.blocks;
const  { RichText, InspectorControls  } = wp.editor;
const  { PanelBody, Button, CheckboxControl  } = wp.components;
const { serverSideRender } = wp;
const { useState } = wp.element;

registerBlockType('tbg/map-location', {

    //built-in attributes
    title: 'Map Location',
    description: 'Render a map with some location logic',
    icon: 'admin-site-alt',
    category: 'layout',

    // custom attributes
    attributes: {
        areas_selected:{
            type: 'array',
            default: []
        },
        shortcode:{
            type: 'string',
            default: "[mlp_map areas='']"
        },
    },

    //built-in functions
    edit({ attributes, setAttributes }){


        const { areas_selected, shortcode } = attributes;

        const areas = parameters.areas;

        //custom functions
        function onChangeAreas(x,s){
            console.log(x)
            console.log(s)
            let new_selection = areas_selected;



            if(x && !new_selection.includes(s)){
                new_selection.push(s);
            }

            if(!x){
                const index = new_selection.indexOf(s);
                if (index > -1) { // only splice array when item is found
                    new_selection.splice(index, 1); // 2nd parameter means remove one item only
                }
            }

            setAttributes({ areas_selected :  new_selection})

            const shortcode_output = "[mlp_map areas='" + areas_selected.join() + "']";

            setAttributes({ shortcode: shortcode_output })

        }

        const split_strings = shortcode.split("'");

        const ids =  split_strings[1].split(',');

        return ([
            <InspectorControls style={ {marginBottom: '40px'} }>
                <PanelBody title={ 'Map Selection Settings' }>
                    {areas.map(function(area, i){
                        return <CheckboxControl key={area.term_id} label={area.name} onChange={(e) => onChangeAreas(e,area.term_id)} checked={ids.includes(area.term_id + "")}   />
                    })}
                </PanelBody>
            </InspectorControls>,
            <div>{shortcode}</div>
        ]);
    },

    save({ attributes }){

        const {shortcode } = attributes;



        return <div className="cta-container">
            {shortcode}
        </div>
       // return '[mlp_map areas="'+areas_selected.join()+'"]';
         /*
        <p><input checked={ areas_selected.includes(area.term_id)} term_id={area.term_id} onChange={onChangeAreas} id={ 'area-' + area.term_id } type="checkbox" /> <label
                            for={'area-' + area.term_id}>{area.name}</label></p>;
        (
            <div class="cta-container">
                <h2 style={ { color: titleColor } }>{ title }</h2>
                <RichText.Content tag="p" value={body} />
            </div>
        );*/
    }
})