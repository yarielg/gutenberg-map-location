/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const {
  registerBlockType
} = wp.blocks;
const {
  RichText,
  InspectorControls
} = wp.editor;
const {
  PanelBody,
  Button,
  CheckboxControl
} = wp.components;
const {
  serverSideRender
} = wp;
const {
  useState
} = wp.element;
registerBlockType('tbg/map-location', {
  //built-in attributes
  title: 'Map Location',
  description: 'Render a map with some location logic',
  icon: 'admin-site-alt',
  category: 'layout',
  // custom attributes
  attributes: {
    areas_selected: {
      type: 'array',
      default: []
    },
    shortcode: {
      type: 'string',
      default: "[mlp_map areas='']"
    }
  },
  //built-in functions
  edit(_ref) {
    let {
      attributes,
      setAttributes
    } = _ref;
    const {
      areas_selected,
      shortcode
    } = attributes;
    const areas = parameters.areas;

    //custom functions
    function onChangeAreas(x, s) {
      console.log(x);
      console.log(s);
      let new_selection = areas_selected;
      if (x && !new_selection.includes(s)) {
        new_selection.push(s);
      }
      if (!x) {
        const index = new_selection.indexOf(s);
        if (index > -1) {
          // only splice array when item is found
          new_selection.splice(index, 1); // 2nd parameter means remove one item only
        }
      }

      setAttributes({
        areas_selected: new_selection
      });
      const shortcode_output = "[mlp_map areas='" + areas_selected.join() + "']";
      setAttributes({
        shortcode: shortcode_output
      });
    }
    const split_strings = shortcode.split("'");
    const ids = split_strings[1].split(',');
    return [(0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, {
      style: {
        marginBottom: '40px'
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
      title: 'Map Selection Settings'
    }, areas.map(function (area, i) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(CheckboxControl, {
        key: area.term_id,
        label: area.name,
        onChange: e => onChangeAreas(e, area.term_id),
        checked: ids.includes(area.term_id + "")
      });
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, shortcode)];
  },
  save(_ref2) {
    let {
      attributes
    } = _ref2;
    const {
      shortcode
    } = attributes;
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "cta-container"
    }, shortcode);
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
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map