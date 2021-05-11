!function(e){function t(n){if(l[n])return l[n].exports;var a=l[n]={i:n,l:!1,exports:{}};return e[n].call(a.exports,a,a.exports,t),a.l=!0,a.exports}var l={};t.m=e,t.c=l,t.d=function(e,l,n){t.o(e,l)||Object.defineProperty(e,l,{configurable:!1,enumerable:!0,get:n})},t.n=function(e){var l=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(l,"a",l),l},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=0)}([function(e,t,l){"use strict";Object.defineProperty(t,"__esModule",{value:!0});l(1)},function(e,t,l){"use strict";var n=l(2),a=(l.n(n),l(3)),__=(l.n(a),wp.i18n.__),r=wp.blocks.registerBlockType,i=wp.components,o=i.ToggleControl,c=i.PanelBody,s=i.PanelRow,m=(i.CheckboxControl,i.SelectControl),d=i.ColorPicker,u=i.TextControl,p=i.RangeControl,g=wp.blockEditor,b=(g.RichText,g.InspectorControls);r("cgb/block-emedia-finder",{title:__("eMediaFinder"),icon:"format-gallery",category:"common",keywords:[__("emedia-finder"),__("entermedia"),__("emediafinder")],attributes:{url:{type:"string"},emInputId:{type:"string"},myRichHeading:{type:"string"},imageText:{type:"string"},imageTextSize:{type:"string",default:""},hasBackground:{type:"boolean",default:!1},favoriteColor:{type:"string",default:"#DDDDDD"},activateLasers:{type:"boolean",default:!1},galleryType:{type:"number",default:0},galleryColSize:{type:"number",default:2},showEmailMsg:{type:"boolean",default:!1}},edit:function(e){function t(t){e.setAttributes({url:t.target.value})}function l(){t&&clearInterval(t);var t=setInterval(function(){var l=document.getElementById(v);e.attributes.url!==l.value&&""!==l.value&&(g({url:l.value}),clearInterval(t))},1e3)}function n(){var e=1===i.galleryType?wp.element.createElement(c,{title:"Gallery Settings",initialOpen:!0},wp.element.createElement(s,null,wp.element.createElement(p,{label:"Columns",onChange:function(e){g({galleryColSize:e})},value:i.galleryColSize,min:1,max:8}))):null,t=0===i.galleryType?wp.element.createElement(c,{title:"Image Text",initialOpen:!0},wp.element.createElement(s,null,wp.element.createElement(u,{label:"Title",format:"string",onChange:function(e){return g({imageText:e})},value:i.imageText})),wp.element.createElement(s,null,wp.element.createElement("div",{class:"row"},wp.element.createElement("div",{class:"col-sm-8"},"Font Size"),wp.element.createElement("div",{class:"col-sm-4"},"Custom"),wp.element.createElement("div",{class:"col-sm-8"},wp.element.createElement(m,{value:i.imageTextSize,options:[{label:"Default",value:""},{label:"Small",value:"18"},{label:"Regular",value:"21"},{label:"Large",value:"26.5"},{label:"Larger",value:"32"}],onChange:function(e){g({imageTextSize:e})}})),wp.element.createElement("div",{class:"col-sm-4"},wp.element.createElement(u,{format:"number",onChange:function(e){return g({imageTextSize:e})},value:i.imageTextSize})))),wp.element.createElement(s,null)):null,l=0===i.galleryType?wp.element.createElement(c,{title:"Cover Settings",initialOpen:!0},wp.element.createElement(s,null,wp.element.createElement(o,{label:"Enable Cover Mode",checked:i.hasBackground,onChange:function(e){return g({hasBackground:e})}})),wp.element.createElement(s,null,wp.element.createElement(d,{color:i.favoriteColor,onChangeComplete:function(e){return g({favoriteColor:e.hex})},disableAlpha:!0}))):null;return wp.element.createElement(b,null,e,t,l)}function a(){var t=[],l=!1;e.attributes.url&&(t=e.attributes.url.toString().split(","),l=t[0].indexOf("videohls")>0||t[0].indexOf("previewffmpeg")>0);var n=wp.element.createElement("div",null);if(l){var a={display:"block",borderStyle:"none"};n=wp.element.createElement("div",null,wp.element.createElement("iframe",{src:t[0],allowfullscreen:"true",width:"600",height:"450",style:a}))}else if(e.attributes.hasBackground||e.attributes.url){if(1===t.length){var r=e.attributes.hasBackground?{backgroundColor:e.attributes.favoriteColor,backgroundImage:'url("'+t[0]+'")'}:{backgroundImage:'url("'+t[0]+'")'},i=e.attributes.imageText?{fontSize:e.attributes.imageTextSize+"px"}:{},o="wp-block-cover has-subtle-background-background-color"+(e.attributes.hasBackground?" has-background-dim":"");0!==e.attributes.galleryType&&g({galleryType:0}),n=wp.element.createElement("div",{class:o,style:r},wp.element.createElement("div",{class:"wp-block-cover__inner-container"},wp.element.createElement("p",{class:"has-text-align-center",style:i},e.attributes.imageText)))}if(t.length>1){1!==e.attributes.galleryType&&e.setAttributes({galleryType:1});var c="wp-block-gallery columns-"+e.attributes.galleryColSize+" is-cropped";n=wp.element.createElement("div",{class:"wp-block-group__inner-container"},wp.element.createElement("figure",{class:c},wp.element.createElement("ul",{class:"blocks-gallery-grid"},t.map(function(e){return wp.element.createElement("li",{class:"blocks-gallery-item"},wp.element.createElement("figure",{class:"is-selected"},wp.element.createElement("img",{loading:"lazy",src:e,alt:"","data-id":"246",class:"wp-image-246",sizes:"(max-width: 1024px) 100vw, 1024px",width:"1024",height:"576"})))}))))}}return n}function r(e){var t=location.protocol+"//"+location.hostname+(location.port?":"+location.port:"")+"/wp-admin/options-general.php?page=emdb-publish";return wp.element.createElement("body",null,wp.element.createElement("div",{class:"components-placeholder block-editor-media-placeholder is-large"},w,wp.element.createElement("div",{class:"components-placeholder__instructions"},"An error was detected:"),wp.element.createElement("div",{class:"alert alert-warning"},e),wp.element.createElement("a",{href:t},"WordPress eMedia Finder Settings")))}var i=e.attributes,g=e.setAttributes,f=credentials.emediafinderdb_current_wp_user.data.user_email,w=wp.element.createElement("div",{class:"components-placeholder__label"},wp.element.createElement("span",{class:"block-editor-block-icon"},wp.element.createElement("svg",{width:"24",height:"24",viewBox:"0 0 24 24",role:"img","aria-hidden":"true",focusable:"false"},wp.element.createElement("path",{d:"M18.7 3H5.3C4 3 3 4 3 5.3v13.4C3 20 4 21 5.3 21h13.4c1.3 0 2.3-1 2.3-2.3V5.3C21 4 20 3 18.7 3zm.8 15.7c0 .4-.4.8-.8.8H5.3c-.4 0-.8-.4-.8-.8V5.3c0-.4.4-.8.8-.8h6.2v8.9l2.5-3.1 2.5 3.1V4.5h2.2c.4 0 .8.4.8.8v13.4z"}))),"eMedia Finder"),v=e.attributes.emInputId;return $=jQuery,e.attributes.emInputId||e.setAttributes({emInputId:"em"+function(){var e=function(){return(65536*(1+Math.random())|0).toString(16).substring(1)};return e()+e()+e()+e()+e()+e()+e()+e()}()}),credentials.emediafinderdb_adminkey?credentials.emediafinderdb_current_wp_user?credentials.emediafinderdb_cdn_prefix&&credentials.emediafinderdb_entermediakey&&credentials.emediafinderdb_collectionid?function(){var r=credentials.emediafinderdb_cdn_prefix+"/finder/blockfind/index.html",o=credentials.emediafinderdb_cdn_prefix+"/finder/blockfind/views/modules/asset/add/start.html",c="gallery"+i.emInputId,s="upload"+i.emInputId;return wp.element.createElement("body",null,n(),a(),wp.element.createElement("div",{class:"components-placeholder block-editor-media-placeholder is-large"},w,wp.element.createElement("input",{id:v,type:"text",class:"form-control",value:e.attributes.url,onChange:t,hidden:!0}),wp.element.createElement("div",{class:"components-placeholder__instructions"},"Search an image or video file, or pick one from your media library."),wp.element.createElement("div",{class:"components-placeholder__fieldset"},wp.element.createElement("div",{class:"components-drop-zone"}),wp.element.createElement("div",{class:"components-form-file-upload"},wp.element.createElement("a",{href:"",class:"emediafinder components-button is-primary",onClick:l,id:s,"data-emhref":o,"data-email":f,"data-emkey":credentials.emediafinderdb_adminkey,"data-inputidupload":i.emInputId,"data-collectionid":credentials.emediafinderdb_collectionid},"Uploader"),wp.element.createElement("a",{href:"",class:"emediafinder components-button is-tertiary",onClick:l,id:c,"data-emhref":r,"data-email":f,"data-emkey":credentials.emediafinderdb_adminkey,"data-inputidupload":i.emInputId,"data-collectionid":credentials.emediafinderdb_collectionid},"View Finder")))))}():r("You must configure all required settings for eMediaFinder in Wordpress settings"):r("Email is not present on wordpress configuration"):r("Missing access key, please click below for configuring access key in wordpress configuration, or ask wordpress administrator")},save:function(e){return wp.element.createElement("body",null,function(){var t=[],l=!1;e.attributes.url&&(t=e.attributes.url.toString().split(","),l=t[0].indexOf("videohls")>0);var n=wp.element.createElement("div",null);if(l){var a={display:"block",borderStyle:"none"};n=wp.element.createElement("div",null,wp.element.createElement("iframe",{src:t[0],allowfullscreen:"true",width:"600",height:"450",style:a}))}else if(e.attributes.hasBackground||e.attributes.url){if(1===t.length){var r=e.attributes.hasBackground?{backgroundColor:e.attributes.favoriteColor,backgroundImage:'url("'+t[0]+'")'}:{backgroundImage:'url("'+t[0]+'")'},i=e.attributes.imageText?{fontSize:e.attributes.imageTextSize+"px"}:{},o="wp-block-cover has-subtle-background-background-color"+(e.attributes.hasBackground?" has-background-dim":"");0!==e.attributes.galleryType&&setAttributes({galleryType:0}),n=wp.element.createElement("div",{class:o,style:r},wp.element.createElement("div",{class:"wp-block-cover__inner-container"},wp.element.createElement("p",{class:"has-text-align-center",style:i},e.attributes.imageText)))}if(t.length>1){1!==e.attributes.galleryType&&e.setAttributes({galleryType:1});var c="wp - block - gallery columns - "+e.attributes.galleryColSize+" is - cropped";n=wp.element.createElement("div",{class:"wp-block-group__inner-container"},wp.element.createElement("figure",{class:c},wp.element.createElement("ul",{class:"blocks-gallery-grid"},t.map(function(e){return wp.element.createElement("li",{class:"blocks-gallery-item"},wp.element.createElement("figure",null,wp.element.createElement("img",{loading:"lazy",src:e,alt:"","data-id":"246",class:"wp-image-246",sizes:"(max-width: 1024px) 100vw, 1024px",width:"1024",height:"576"})))}))))}}return n}())}})},function(e,t){},function(e,t){}]);