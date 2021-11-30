/*! For license information please see files_pdfviewer-main.js.LICENSE.txt */
!function(){var t={9753:function(t,n,e){"use strict";e(2772),e(9601),e(1539),e(4916),e(9714),e(5306),Object.defineProperty(n,"__esModule",{value:!0}),n.getRootUrl=n.generateFilePath=n.imagePath=n.generateUrl=n.generateOcsUrl=n.generateRemoteUrl=n.linkTo=void 0;n.linkTo=function(t,n){return r(t,"",n)};n.generateRemoteUrl=function(t){return window.location.protocol+"//"+window.location.host+function(t){return o()+"/remote.php/"+t}(t)};n.generateOcsUrl=function(t,n){return n=2!==n?1:2,window.location.protocol+"//"+window.location.host+o()+"/ocs/v"+n+".php/"+t+"/"};n.generateUrl=function(t,n,e){var r=Object.assign({escape:!0,noRewrite:!1},e||{}),i=function(t,n){return n=n||{},t.replace(/{([^{}]*)}/g,(function(t,e){var o=n[e];return r.escape?"string"==typeof o||"number"==typeof o?encodeURIComponent(o.toString()):encodeURIComponent(t):"string"==typeof o||"number"==typeof o?o.toString():t}))};return"/"!==t.charAt(0)&&(t="/"+t),!0!==OC.config.modRewriteWorking||r.noRewrite?o()+"/index.php"+i(t,n||{}):o()+i(t,n||{})};n.imagePath=function(t,n){return-1===n.indexOf(".")?r(t,"img",n+".svg"):r(t,"img",n)};var r=function(t,n,e){var r=-1!==OC.coreApps.indexOf(t),i=o();return"php"!==e.substring(e.length-3)||r?"php"===e.substring(e.length-3)||r?(i+="settings"!==t&&"core"!==t&&"search"!==t||"ajax"!==n?"/":"/index.php/",r||(i+="apps/"),""!==t&&(i+=t+="/"),n&&(i+=n+"/"),i+=e):(i=OC.appswebroots[t],n&&(i+="/"+n+"/"),"/"!==i.substring(i.length-1)&&(i+="/"),i+=e):(i+="/index.php/apps/"+t,"index.php"!==e&&(i+="/",n&&(i+=encodeURI(n+"/")),i+=e)),i};n.generateFilePath=r;var o=function(){return OC.webroot};n.getRootUrl=o},5843:function(t,n,e){"use strict";Object.defineProperty(n,"X",{value:!0}),n.Z=void 0;var r=e(9753);function o(t,n,e,r,o,i,c){try{var a=t[i](c),u=a.value}catch(t){return void e(t)}a.done?n(u):Promise.resolve(u).then(r,o)}var i,c,a={name:"PDFView",computed:{iframeSrc:function(){return(0,r.generateUrl)("/apps/files_pdfviewer/?file={file}",{file:this.davPath})}},mounted:(i=regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.doneLoading(),this.$nextTick((function(){this.$el.focus()}));case 2:case"end":return t.stop()}}),t,this)})),c=function(){var t=this,n=arguments;return new Promise((function(e,r){var c=i.apply(t,n);function a(t){o(c,e,r,a,u,"next",t)}function u(t){o(c,e,r,a,u,"throw",t)}a(void 0)}))},function(){return c.apply(this,arguments)})};n.Z=a},1530:function(t,n,e){"use strict";var r=e(8710).charAt;t.exports=function(t,n,e){return n+(e?r(t,n).length:1)}},9670:function(t,n,e){var r=e(111);t.exports=function(t){if(!r(t))throw TypeError(String(t)+" is not an object");return t}},1318:function(t,n,e){var r=e(5656),o=e(7466),i=e(1400),c=function(t){return function(n,e,c){var a,u=r(n),f=o(u.length),s=i(c,f);if(t&&e!=e){for(;f>s;)if((a=u[s++])!=a)return!0}else for(;f>s;s++)if((t||s in u)&&u[s]===e)return t||s||0;return!t&&-1}};t.exports={includes:c(!0),indexOf:c(!1)}},9341:function(t,n,e){"use strict";var r=e(7293);t.exports=function(t,n){var e=[][t];return!!e&&r((function(){e.call(null,n||function(){throw 1},1)}))}},4326:function(t){var n={}.toString;t.exports=function(t){return n.call(t).slice(8,-1)}},648:function(t,n,e){var r=e(1694),o=e(4326),i=e(5112)("toStringTag"),c="Arguments"==o(function(){return arguments}());t.exports=r?o:function(t){var n,e,r;return void 0===t?"Undefined":null===t?"Null":"string"==typeof(e=function(t,n){try{return t[n]}catch(t){}}(n=Object(t),i))?e:c?o(n):"Object"==(r=o(n))&&"function"==typeof n.callee?"Arguments":r}},9920:function(t,n,e){var r=e(6656),o=e(3887),i=e(1236),c=e(3070);t.exports=function(t,n){for(var e=o(n),a=c.f,u=i.f,f=0;f<e.length;f++){var s=e[f];r(t,s)||a(t,s,u(n,s))}}},8880:function(t,n,e){var r=e(9781),o=e(3070),i=e(9114);t.exports=r?function(t,n,e){return o.f(t,n,i(1,e))}:function(t,n,e){return t[n]=e,t}},9114:function(t){t.exports=function(t,n){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:n}}},9781:function(t,n,e){var r=e(7293);t.exports=!r((function(){return 7!=Object.defineProperty({},1,{get:function(){return 7}})[1]}))},317:function(t,n,e){var r=e(7854),o=e(111),i=r.document,c=o(i)&&o(i.createElement);t.exports=function(t){return c?i.createElement(t):{}}},8113:function(t,n,e){var r=e(5005);t.exports=r("navigator","userAgent")||""},7392:function(t,n,e){var r,o,i=e(7854),c=e(8113),a=i.process,u=a&&a.versions,f=u&&u.v8;f?o=(r=f.split("."))[0]<4?1:r[0]+r[1]:c&&(!(r=c.match(/Edge\/(\d+)/))||r[1]>=74)&&(r=c.match(/Chrome\/(\d+)/))&&(o=r[1]),t.exports=o&&+o},748:function(t){t.exports=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString","valueOf"]},2109:function(t,n,e){var r=e(7854),o=e(1236).f,i=e(8880),c=e(1320),a=e(3505),u=e(9920),f=e(4705);t.exports=function(t,n){var e,s,l,p,v,d=t.target,g=t.global,h=t.stat;if(e=g?r:h?r[d]||a(d,{}):(r[d]||{}).prototype)for(s in n){if(p=n[s],l=t.noTargetGet?(v=o(e,s))&&v.value:e[s],!f(g?s:d+(h?".":"#")+s,t.forced)&&void 0!==l){if(typeof p==typeof l)continue;u(p,l)}(t.sham||l&&l.sham)&&i(p,"sham",!0),c(e,s,p,t)}}},7293:function(t){t.exports=function(t){try{return!!t()}catch(t){return!0}}},7007:function(t,n,e){"use strict";e(4916);var r=e(1320),o=e(2261),i=e(7293),c=e(5112),a=e(8880),u=c("species"),f=RegExp.prototype,s=!i((function(){var t=/./;return t.exec=function(){var t=[];return t.groups={a:"7"},t},"7"!=="".replace(t,"$<a>")})),l="$0"==="a".replace(/./,"$0"),p=c("replace"),v=!!/./[p]&&""===/./[p]("a","$0"),d=!i((function(){var t=/(?:)/,n=t.exec;t.exec=function(){return n.apply(this,arguments)};var e="ab".split(t);return 2!==e.length||"a"!==e[0]||"b"!==e[1]}));t.exports=function(t,n,e,p){var g=c(t),h=!i((function(){var n={};return n[g]=function(){return 7},7!=""[t](n)})),y=h&&!i((function(){var n=!1,e=/a/;return"split"===t&&((e={}).constructor={},e.constructor[u]=function(){return e},e.flags="",e[g]=/./[g]),e.exec=function(){return n=!0,null},e[g](""),!n}));if(!h||!y||"replace"===t&&(!s||!l||v)||"split"===t&&!d){var x=/./[g],b=e(g,""[t],(function(t,n,e,r,i){var c=n.exec;return c===o||c===f.exec?h&&!i?{done:!0,value:x.call(n,e,r)}:{done:!0,value:t.call(e,n,r)}:{done:!1}}),{REPLACE_KEEPS_$0:l,REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE:v}),m=b[0],S=b[1];r(String.prototype,t,m),r(f,g,2==n?function(t,n){return S.call(t,this,n)}:function(t){return S.call(t,this)})}p&&a(f[g],"sham",!0)}},5005:function(t,n,e){var r=e(857),o=e(7854),i=function(t){return"function"==typeof t?t:void 0};t.exports=function(t,n){return arguments.length<2?i(r[t])||i(o[t]):r[t]&&r[t][n]||o[t]&&o[t][n]}},647:function(t,n,e){var r=e(7908),o=Math.floor,i="".replace,c=/\$([$&'`]|\d{1,2}|<[^>]*>)/g,a=/\$([$&'`]|\d{1,2})/g;t.exports=function(t,n,e,u,f,s){var l=e+t.length,p=u.length,v=a;return void 0!==f&&(f=r(f),v=c),i.call(s,v,(function(r,i){var c;switch(i.charAt(0)){case"$":return"$";case"&":return t;case"`":return n.slice(0,e);case"'":return n.slice(l);case"<":c=f[i.slice(1,-1)];break;default:var a=+i;if(0===a)return r;if(a>p){var s=o(a/10);return 0===s?r:s<=p?void 0===u[s-1]?i.charAt(1):u[s-1]+i.charAt(1):r}c=u[a-1]}return void 0===c?"":c}))}},7854:function(t,n,e){var r=function(t){return t&&t.Math==Math&&t};t.exports=r("object"==typeof globalThis&&globalThis)||r("object"==typeof window&&window)||r("object"==typeof self&&self)||r("object"==typeof e.g&&e.g)||function(){return this}()||Function("return this")()},6656:function(t,n,e){var r=e(7908),o={}.hasOwnProperty;t.exports=Object.hasOwn||function(t,n){return o.call(r(t),n)}},3501:function(t){t.exports={}},4664:function(t,n,e){var r=e(9781),o=e(7293),i=e(317);t.exports=!r&&!o((function(){return 7!=Object.defineProperty(i("div"),"a",{get:function(){return 7}}).a}))},8361:function(t,n,e){var r=e(7293),o=e(4326),i="".split;t.exports=r((function(){return!Object("z").propertyIsEnumerable(0)}))?function(t){return"String"==o(t)?i.call(t,""):Object(t)}:Object},2788:function(t,n,e){var r=e(5465),o=Function.toString;"function"!=typeof r.inspectSource&&(r.inspectSource=function(t){return o.call(t)}),t.exports=r.inspectSource},9909:function(t,n,e){var r,o,i,c=e(8536),a=e(7854),u=e(111),f=e(8880),s=e(6656),l=e(5465),p=e(6200),v=e(3501),d="Object already initialized",g=a.WeakMap;if(c||l.state){var h=l.state||(l.state=new g),y=h.get,x=h.has,b=h.set;r=function(t,n){if(x.call(h,t))throw new TypeError(d);return n.facade=t,b.call(h,t,n),n},o=function(t){return y.call(h,t)||{}},i=function(t){return x.call(h,t)}}else{var m=p("state");v[m]=!0,r=function(t,n){if(s(t,m))throw new TypeError(d);return n.facade=t,f(t,m,n),n},o=function(t){return s(t,m)?t[m]:{}},i=function(t){return s(t,m)}}t.exports={set:r,get:o,has:i,enforce:function(t){return i(t)?o(t):r(t,{})},getterFor:function(t){return function(n){var e;if(!u(n)||(e=o(n)).type!==t)throw TypeError("Incompatible receiver, "+t+" required");return e}}}},4705:function(t,n,e){var r=e(7293),o=/#|\.prototype\./,i=function(t,n){var e=a[c(t)];return e==f||e!=u&&("function"==typeof n?r(n):!!n)},c=i.normalize=function(t){return String(t).replace(o,".").toLowerCase()},a=i.data={},u=i.NATIVE="N",f=i.POLYFILL="P";t.exports=i},111:function(t){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},1913:function(t){t.exports=!1},133:function(t,n,e){var r=e(7392),o=e(7293);t.exports=!!Object.getOwnPropertySymbols&&!o((function(){var t=Symbol();return!String(t)||!(Object(t)instanceof Symbol)||!Symbol.sham&&r&&r<41}))},8536:function(t,n,e){var r=e(7854),o=e(2788),i=r.WeakMap;t.exports="function"==typeof i&&/native code/.test(o(i))},1574:function(t,n,e){"use strict";var r=e(9781),o=e(7293),i=e(1956),c=e(5181),a=e(5296),u=e(7908),f=e(8361),s=Object.assign,l=Object.defineProperty;t.exports=!s||o((function(){if(r&&1!==s({b:1},s(l({},"a",{enumerable:!0,get:function(){l(this,"b",{value:3,enumerable:!1})}}),{b:2})).b)return!0;var t={},n={},e=Symbol(),o="abcdefghijklmnopqrst";return t[e]=7,o.split("").forEach((function(t){n[t]=t})),7!=s({},t)[e]||i(s({},n)).join("")!=o}))?function(t,n){for(var e=u(t),o=arguments.length,s=1,l=c.f,p=a.f;o>s;)for(var v,d=f(arguments[s++]),g=l?i(d).concat(l(d)):i(d),h=g.length,y=0;h>y;)v=g[y++],r&&!p.call(d,v)||(e[v]=d[v]);return e}:s},3070:function(t,n,e){var r=e(9781),o=e(4664),i=e(9670),c=e(7593),a=Object.defineProperty;n.f=r?a:function(t,n,e){if(i(t),n=c(n,!0),i(e),o)try{return a(t,n,e)}catch(t){}if("get"in e||"set"in e)throw TypeError("Accessors not supported");return"value"in e&&(t[n]=e.value),t}},1236:function(t,n,e){var r=e(9781),o=e(5296),i=e(9114),c=e(5656),a=e(7593),u=e(6656),f=e(4664),s=Object.getOwnPropertyDescriptor;n.f=r?s:function(t,n){if(t=c(t),n=a(n,!0),f)try{return s(t,n)}catch(t){}if(u(t,n))return i(!o.f.call(t,n),t[n])}},8006:function(t,n,e){var r=e(6324),o=e(748).concat("length","prototype");n.f=Object.getOwnPropertyNames||function(t){return r(t,o)}},5181:function(t,n){n.f=Object.getOwnPropertySymbols},6324:function(t,n,e){var r=e(6656),o=e(5656),i=e(1318).indexOf,c=e(3501);t.exports=function(t,n){var e,a=o(t),u=0,f=[];for(e in a)!r(c,e)&&r(a,e)&&f.push(e);for(;n.length>u;)r(a,e=n[u++])&&(~i(f,e)||f.push(e));return f}},1956:function(t,n,e){var r=e(6324),o=e(748);t.exports=Object.keys||function(t){return r(t,o)}},5296:function(t,n){"use strict";var e={}.propertyIsEnumerable,r=Object.getOwnPropertyDescriptor,o=r&&!e.call({1:2},1);n.f=o?function(t){var n=r(this,t);return!!n&&n.enumerable}:e},288:function(t,n,e){"use strict";var r=e(1694),o=e(648);t.exports=r?{}.toString:function(){return"[object "+o(this)+"]"}},3887:function(t,n,e){var r=e(5005),o=e(8006),i=e(5181),c=e(9670);t.exports=r("Reflect","ownKeys")||function(t){var n=o.f(c(t)),e=i.f;return e?n.concat(e(t)):n}},857:function(t,n,e){var r=e(7854);t.exports=r},1320:function(t,n,e){var r=e(7854),o=e(8880),i=e(6656),c=e(3505),a=e(2788),u=e(9909),f=u.get,s=u.enforce,l=String(String).split("String");(t.exports=function(t,n,e,a){var u,f=!!a&&!!a.unsafe,p=!!a&&!!a.enumerable,v=!!a&&!!a.noTargetGet;"function"==typeof e&&("string"!=typeof n||i(e,"name")||o(e,"name",n),(u=s(e)).source||(u.source=l.join("string"==typeof n?n:""))),t!==r?(f?!v&&t[n]&&(p=!0):delete t[n],p?t[n]=e:o(t,n,e)):p?t[n]=e:c(n,e)})(Function.prototype,"toString",(function(){return"function"==typeof this&&f(this).source||a(this)}))},7651:function(t,n,e){var r=e(4326),o=e(2261);t.exports=function(t,n){var e=t.exec;if("function"==typeof e){var i=e.call(t,n);if("object"!=typeof i)throw TypeError("RegExp exec method returned something other than an Object or null");return i}if("RegExp"!==r(t))throw TypeError("RegExp#exec called on incompatible receiver");return o.call(t,n)}},2261:function(t,n,e){"use strict";var r,o,i=e(7066),c=e(2999),a=e(2309),u=RegExp.prototype.exec,f=a("native-string-replace",String.prototype.replace),s=u,l=(r=/a/,o=/b*/g,u.call(r,"a"),u.call(o,"a"),0!==r.lastIndex||0!==o.lastIndex),p=c.UNSUPPORTED_Y||c.BROKEN_CARET,v=void 0!==/()??/.exec("")[1];(l||v||p)&&(s=function(t){var n,e,r,o,c=this,a=p&&c.sticky,s=i.call(c),d=c.source,g=0,h=t;return a&&(-1===(s=s.replace("y","")).indexOf("g")&&(s+="g"),h=String(t).slice(c.lastIndex),c.lastIndex>0&&(!c.multiline||c.multiline&&"\n"!==t[c.lastIndex-1])&&(d="(?: "+d+")",h=" "+h,g++),e=new RegExp("^(?:"+d+")",s)),v&&(e=new RegExp("^"+d+"$(?!\\s)",s)),l&&(n=c.lastIndex),r=u.call(a?e:c,h),a?r?(r.input=r.input.slice(g),r[0]=r[0].slice(g),r.index=c.lastIndex,c.lastIndex+=r[0].length):c.lastIndex=0:l&&r&&(c.lastIndex=c.global?r.index+r[0].length:n),v&&r&&r.length>1&&f.call(r[0],e,(function(){for(o=1;o<arguments.length-2;o++)void 0===arguments[o]&&(r[o]=void 0)})),r}),t.exports=s},7066:function(t,n,e){"use strict";var r=e(9670);t.exports=function(){var t=r(this),n="";return t.global&&(n+="g"),t.ignoreCase&&(n+="i"),t.multiline&&(n+="m"),t.dotAll&&(n+="s"),t.unicode&&(n+="u"),t.sticky&&(n+="y"),n}},2999:function(t,n,e){"use strict";var r=e(7293);function o(t,n){return RegExp(t,n)}n.UNSUPPORTED_Y=r((function(){var t=o("a","y");return t.lastIndex=2,null!=t.exec("abcd")})),n.BROKEN_CARET=r((function(){var t=o("^r","gy");return t.lastIndex=2,null!=t.exec("str")}))},4488:function(t){t.exports=function(t){if(null==t)throw TypeError("Can't call method on "+t);return t}},3505:function(t,n,e){var r=e(7854),o=e(8880);t.exports=function(t,n){try{o(r,t,n)}catch(e){r[t]=n}return n}},6200:function(t,n,e){var r=e(2309),o=e(9711),i=r("keys");t.exports=function(t){return i[t]||(i[t]=o(t))}},5465:function(t,n,e){var r=e(7854),o=e(3505),i="__core-js_shared__",c=r[i]||o(i,{});t.exports=c},2309:function(t,n,e){var r=e(1913),o=e(5465);(t.exports=function(t,n){return o[t]||(o[t]=void 0!==n?n:{})})("versions",[]).push({version:"3.14.0",mode:r?"pure":"global",copyright:"© 2021 Denis Pushkarev (zloirock.ru)"})},8710:function(t,n,e){var r=e(9958),o=e(4488),i=function(t){return function(n,e){var i,c,a=String(o(n)),u=r(e),f=a.length;return u<0||u>=f?t?"":void 0:(i=a.charCodeAt(u))<55296||i>56319||u+1===f||(c=a.charCodeAt(u+1))<56320||c>57343?t?a.charAt(u):i:t?a.slice(u,u+2):c-56320+(i-55296<<10)+65536}};t.exports={codeAt:i(!1),charAt:i(!0)}},1400:function(t,n,e){var r=e(9958),o=Math.max,i=Math.min;t.exports=function(t,n){var e=r(t);return e<0?o(e+n,0):i(e,n)}},5656:function(t,n,e){var r=e(8361),o=e(4488);t.exports=function(t){return r(o(t))}},9958:function(t){var n=Math.ceil,e=Math.floor;t.exports=function(t){return isNaN(t=+t)?0:(t>0?e:n)(t)}},7466:function(t,n,e){var r=e(9958),o=Math.min;t.exports=function(t){return t>0?o(r(t),9007199254740991):0}},7908:function(t,n,e){var r=e(4488);t.exports=function(t){return Object(r(t))}},7593:function(t,n,e){var r=e(111);t.exports=function(t,n){if(!r(t))return t;var e,o;if(n&&"function"==typeof(e=t.toString)&&!r(o=e.call(t)))return o;if("function"==typeof(e=t.valueOf)&&!r(o=e.call(t)))return o;if(!n&&"function"==typeof(e=t.toString)&&!r(o=e.call(t)))return o;throw TypeError("Can't convert object to primitive value")}},1694:function(t,n,e){var r={};r[e(5112)("toStringTag")]="z",t.exports="[object z]"===String(r)},9711:function(t){var n=0,e=Math.random();t.exports=function(t){return"Symbol("+String(void 0===t?"":t)+")_"+(++n+e).toString(36)}},3307:function(t,n,e){var r=e(133);t.exports=r&&!Symbol.sham&&"symbol"==typeof Symbol.iterator},5112:function(t,n,e){var r=e(7854),o=e(2309),i=e(6656),c=e(9711),a=e(133),u=e(3307),f=o("wks"),s=r.Symbol,l=u?s:s&&s.withoutSetter||c;t.exports=function(t){return i(f,t)&&(a||"string"==typeof f[t])||(a&&i(s,t)?f[t]=s[t]:f[t]=l("Symbol."+t)),f[t]}},2772:function(t,n,e){"use strict";var r=e(2109),o=e(1318).indexOf,i=e(9341),c=[].indexOf,a=!!c&&1/[1].indexOf(1,-0)<0,u=i("indexOf");r({target:"Array",proto:!0,forced:a||!u},{indexOf:function(t){return a?c.apply(this,arguments)||0:o(this,t,arguments.length>1?arguments[1]:void 0)}})},9601:function(t,n,e){var r=e(2109),o=e(1574);r({target:"Object",stat:!0,forced:Object.assign!==o},{assign:o})},1539:function(t,n,e){var r=e(1694),o=e(1320),i=e(288);r||o(Object.prototype,"toString",i,{unsafe:!0})},4916:function(t,n,e){"use strict";var r=e(2109),o=e(2261);r({target:"RegExp",proto:!0,forced:/./.exec!==o},{exec:o})},9714:function(t,n,e){"use strict";var r=e(1320),o=e(9670),i=e(7293),c=e(7066),a="toString",u=RegExp.prototype,f=u.toString,s=i((function(){return"/a/b"!=f.call({source:"a",flags:"b"})})),l=f.name!=a;(s||l)&&r(RegExp.prototype,a,(function(){var t=o(this),n=String(t.source),e=t.flags;return"/"+n+"/"+String(void 0===e&&t instanceof RegExp&&!("flags"in u)?c.call(t):e)}),{unsafe:!0})},5306:function(t,n,e){"use strict";var r=e(7007),o=e(9670),i=e(7466),c=e(9958),a=e(4488),u=e(1530),f=e(647),s=e(7651),l=Math.max,p=Math.min;r("replace",2,(function(t,n,e,r){var v=r.REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE,d=r.REPLACE_KEEPS_$0,g=v?"$":"$0";return[function(e,r){var o=a(this),i=null==e?void 0:e[t];return void 0!==i?i.call(e,o,r):n.call(String(o),e,r)},function(t,r){if(!v&&d||"string"==typeof r&&-1===r.indexOf(g)){var a=e(n,t,this,r);if(a.done)return a.value}var h=o(t),y=String(this),x="function"==typeof r;x||(r=String(r));var b=h.global;if(b){var m=h.unicode;h.lastIndex=0}for(var S=[];;){var w=s(h,y);if(null===w)break;if(S.push(w),!b)break;""===String(w[0])&&(h.lastIndex=u(y,i(h.lastIndex),m))}for(var O,E="",j=0,_=0;_<S.length;_++){w=S[_];for(var R=String(w[0]),C=l(p(c(w.index),y.length),0),T=[],P=1;P<w.length;P++)T.push(void 0===(O=w[P])?O:String(O));var A=w.groups;if(x){var I=[R].concat(T,C,y);void 0!==A&&I.push(A);var U=String(r.apply(void 0,I))}else U=f(R,y,C,T,A,r);C>=j&&(E+=y.slice(j,C)+U,j=C+R.length)}return E+y.slice(j)}]}))},59:function(t,n,e){"use strict";var r=e(3645),o=e.n(r)()(!0);o.push([t.id,"iframe[data-v-4d8f05ee]{width:100%;height:100%}","",{version:3,sources:["webpack://src/views/PDFView.vue"],names:[],mappings:"AAkDA,wBACC,UAAA,CACA,WAAA",sourcesContent:["\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\niframe {\n\twidth: 100%;\n\theight: 100%;\n}\n"],sourceRoot:""}]),n.Z=o},3645:function(t){"use strict";t.exports=function(t){var n=[];return n.toString=function(){return this.map((function(n){var e=function(t,n){var e=t[1]||"",r=t[3];if(!r)return e;if(n&&"function"==typeof btoa){var o=(c=r,a=btoa(unescape(encodeURIComponent(JSON.stringify(c)))),u="sourceMappingURL=data:application/json;charset=utf-8;base64,".concat(a),"/*# ".concat(u," */")),i=r.sources.map((function(t){return"/*# sourceURL=".concat(r.sourceRoot||"").concat(t," */")}));return[e].concat(i).concat([o]).join("\n")}var c,a,u;return[e].join("\n")}(n,t);return n[2]?"@media ".concat(n[2]," {").concat(e,"}"):e})).join("")},n.i=function(t,e,r){"string"==typeof t&&(t=[[null,t,""]]);var o={};if(r)for(var i=0;i<this.length;i++){var c=this[i][0];null!=c&&(o[c]=!0)}for(var a=0;a<t.length;a++){var u=[].concat(t[a]);r&&o[u[0]]||(e&&(u[2]?u[2]="".concat(e," and ").concat(u[2]):u[2]=e),n.push(u))}},n}},3379:function(t,n,e){"use strict";var r,o=function(){return void 0===r&&(r=Boolean(window&&document&&document.all&&!window.atob)),r},i=function(){var t={};return function(n){if(void 0===t[n]){var e=document.querySelector(n);if(window.HTMLIFrameElement&&e instanceof window.HTMLIFrameElement)try{e=e.contentDocument.head}catch(t){e=null}t[n]=e}return t[n]}}(),c=[];function a(t){for(var n=-1,e=0;e<c.length;e++)if(c[e].identifier===t){n=e;break}return n}function u(t,n){for(var e={},r=[],o=0;o<t.length;o++){var i=t[o],u=n.base?i[0]+n.base:i[0],f=e[u]||0,s="".concat(u," ").concat(f);e[u]=f+1;var l=a(s),p={css:i[1],media:i[2],sourceMap:i[3]};-1!==l?(c[l].references++,c[l].updater(p)):c.push({identifier:s,updater:h(p,n),references:1}),r.push(s)}return r}function f(t){var n=document.createElement("style"),r=t.attributes||{};if(void 0===r.nonce){var o=e.nc;o&&(r.nonce=o)}if(Object.keys(r).forEach((function(t){n.setAttribute(t,r[t])})),"function"==typeof t.insert)t.insert(n);else{var c=i(t.insert||"head");if(!c)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");c.appendChild(n)}return n}var s,l=(s=[],function(t,n){return s[t]=n,s.filter(Boolean).join("\n")});function p(t,n,e,r){var o=e?"":r.media?"@media ".concat(r.media," {").concat(r.css,"}"):r.css;if(t.styleSheet)t.styleSheet.cssText=l(n,o);else{var i=document.createTextNode(o),c=t.childNodes;c[n]&&t.removeChild(c[n]),c.length?t.insertBefore(i,c[n]):t.appendChild(i)}}function v(t,n,e){var r=e.css,o=e.media,i=e.sourceMap;if(o?t.setAttribute("media",o):t.removeAttribute("media"),i&&"undefined"!=typeof btoa&&(r+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(i))))," */")),t.styleSheet)t.styleSheet.cssText=r;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(r))}}var d=null,g=0;function h(t,n){var e,r,o;if(n.singleton){var i=g++;e=d||(d=f(n)),r=p.bind(null,e,i,!1),o=p.bind(null,e,i,!0)}else e=f(n),r=v.bind(null,e,n),o=function(){!function(t){if(null===t.parentNode)return!1;t.parentNode.removeChild(t)}(e)};return r(t),function(n){if(n){if(n.css===t.css&&n.media===t.media&&n.sourceMap===t.sourceMap)return;r(t=n)}else o()}}t.exports=function(t,n){(n=n||{}).singleton||"boolean"==typeof n.singleton||(n.singleton=o());var e=u(t=t||[],n);return function(t){if(t=t||[],"[object Array]"===Object.prototype.toString.call(t)){for(var r=0;r<e.length;r++){var o=a(e[r]);c[o].references--}for(var i=u(t,n),f=0;f<e.length;f++){var s=a(e[f]);0===c[s].references&&(c[s].updater(),c.splice(s,1))}e=i}}}},2144:function(t,n,e){"use strict";e.r(n),e.d(n,{__esModule:function(){return r.X},default:function(){return f}});var r=e(5843),o=r.Z,i=e(3379),c=e.n(i),a=e(59),u={insert:"head",singleton:!1};c()(a.Z,u),a.Z.locals;var f=function(t,n,e,r,o,i,c,a){var u,f="function"==typeof t?t.options:t;if(n&&(f.render=n,f.staticRenderFns=e,f._compiled=!0),r&&(f.functional=!0),i&&(f._scopeId="data-v-"+i),c?(u=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(c)},f._ssrRegister=u):o&&(u=a?function(){o.call(this,(f.functional?this.parent:this).$root.$options.shadowRoot)}:o),u)if(f.functional){f._injectStyles=u;var s=f.render;f.render=function(t,n){return u.call(n),s(t,n)}}else{var l=f.beforeCreate;f.beforeCreate=l?[].concat(l,u):[u]}return{exports:t,options:f}}(o,(function(){var t=this,n=t.$createElement;return(t._self._c||n)("iframe",{attrs:{src:t.iframeSrc}})}),[],!1,null,"4d8f05ee",null).exports}},n={};function e(r){var o=n[r];if(void 0!==o)return o.exports;var i=n[r]={id:r,exports:{}};return t[r](i,i.exports,e),i.exports}e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,{a:n}),n},e.d=function(t,n){for(var r in n)e.o(n,r)&&!e.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:n[r]})},e.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"==typeof window)return window}}(),e.o=function(t,n){return Object.prototype.hasOwnProperty.call(t,n)},e.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},function(){"use strict";var t,n=(t=e(2144))&&t.__esModule?t:{default:t};window.addEventListener("DOMContentLoaded",(function(){OCA.Viewer.registerHandler({id:"pdf",mimes:["application/pdf","application/illustrator"],component:n.default})}))}()}();
//# sourceMappingURL=files_pdfviewer-main.js.map?v=9d9bb61acb1e546d4f86