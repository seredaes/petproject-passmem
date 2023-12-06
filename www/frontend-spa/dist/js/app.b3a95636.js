(function(){"use strict";var e={6708:function(e,t,n){n(560);var r=n(9242),o=n(3396);function i(e,t,n,r,i,a){const s=(0,o.up)("HeaderComponent"),u=(0,o.up)("router-view"),l=(0,o.up)("notifications");return(0,o.wg)(),(0,o.iD)(o.HY,null,[e.getStatusAuth?((0,o.wg)(),(0,o.j4)(s,{key:0})):(0,o.kq)("",!0),(0,o.Wm)(u),(0,o.Wm)(l,{position:"top right"})],64)}const a={class:"header-block"};function s(e,t,n,i,s,u){return(0,o.wg)(),(0,o.iD)("div",a,[(0,o._)("button",{class:"btn btn-danger",onClick:t[0]||(t[0]=(0,r.iM)(((...t)=>e.exit&&e.exit(...t)),["self"]))},"Выйти")])}var u=n(65),l=(0,o.aZ)({name:"HeaderComponent",methods:{...(0,u.nv)(["setAuth"]),exit(){localStorage.clear(),this.setAuth(!1),window.location.href="/"}}}),c=n(89);const p=(0,c.Z)(l,[["render",s]]);var d=p,f=(0,o.aZ)({name:"App",components:{HeaderComponent:d},computed:{...(0,u.Se)(["getStatusAuth"])},methods:{...(0,u.nv)(["setAuth"])},created(){localStorage.getItem("access_token")?this.setAuth(!0):this.setAuth(!1)}});const m=(0,c.Z)(f,[["render",i]]);var h=m,g=n(2483);const b=[{path:"/",name:"HomeController",component:()=>n.e(954).then(n.bind(n,8863))},{path:"/about",name:"AboutController",component:()=>n.e(595).then(n.bind(n,1973))},{path:"/registration",name:"RegistrationController",component:()=>n.e(892).then(n.bind(n,1233))},{path:"/dashboard",name:"DashboardController",component:()=>n.e(361).then(n.bind(n,2704))},{path:"/404",component:()=>n.e(737).then(n.bind(n,9850))},{path:"/:pathMatch(.*)*",redirect:"/404"}],v=(0,g.p7)({history:(0,g.PO)("/"),routes:b});v.beforeEach(((e,t,n)=>{const r=e.name,o=["HomeController","RegistrationController"],i=localStorage.getItem("access_token");return o.includes(r)||null!==i?n():n("/")}));var y=v,A=n(1076),C={registration(e){return A.Z.post("http://api.passmem.local/api/registration",e)},auth(e){return A.Z.post("http://api.passmem.local/api/auth",e)},ping(){return A.Z.post("http://api.passmem.local/api/ping")},getList(){return A.Z.post("http://api.passmem.local/api/list")},appendList(e){return A.Z.post("http://api.passmem.local/api/list/create",e)},editList(e){return A.Z.post("http://api.passmem.local/api/list/update",e)},deleteList(e){return A.Z.post("http://api.passmem.local/api/list/delete",e)}},P=(0,u.MT)({state:{list:[],eventbus:{},auth:!1},getters:{resultList(e){return e.list},eventBusOn(e){return e.eventbus},getStatusAuth(e){return e.auth}},mutations:{mutateList(e,t){e.list=t},mutateEmit(e,t){e.eventbus=t},setStatusAuth(e,t){e.auth=t}},actions:{API_registration(e,t){return C.registration(t)},API_auth(e,t){return C.auth(t)},API_ping(){return C.ping()},API_get_list(){return C.getList()},API_append_list(e,t){return C.appendList(t)},API_edit_list(e,t){return C.editList(t)},API_delete_list(e,t){return C.deleteList(t)},eventBusCommit({commit:e},t={}){e("mutateEmit",t)},setAuth({commit:e},t){e("setStatusAuth",t)}},modules:{}}),_=n(6423),k=n(1037);const S={API_URL:"http://api.passmem.local/api/"};var w=S;const O=(0,r.ri)(h);O.config.globalProperties.$globalConst=w,O.use(P).use(y).use(k.ZP).use(_.Z,A.Z).mount("#app"),A.Z.interceptors.request.use((e=>(e.timeout=2e3,e.baseURL=w.API_URL,e.headers.Authorization=null===localStorage.getItem("access_token")?"":"Bearer "+localStorage.getItem("access_token"),e.headers.Accept="application/json; charset=utf-8",e))),A.Z.interceptors.response.use((function(e){return e}),(function(e){if("ERR_NETWORK"===e.code)return O.config.globalProperties.$notify({title:"Ошибка API",text:"Сервер API недоступен! Обратитесь к владельцу или проверьте свое сетевое подключение.",type:"error",duration:8e3,speed:1e3}),localStorage.clear(),y.push({name:"HomeController"}),Promise.reject(e);switch(+e.response.status){case 422:O.config.globalProperties.$notify({title:"Ошибка валидации",text:e?.response?.data?.message??"Ошибка валидации на сервере",type:"error",duration:3e3,speed:1e3});break;case 401:localStorage.clear(),"home"!==O.config.globalProperties.$route.name&&(O.config.globalProperties.$notify({title:"Ошибка авторизации",text:"Авторизируйтесь или убедитесь, что ваш аккаунт активен",type:"error",duration:3e3,speed:1e3}),O.config.globalProperties.$router.push({name:"HomeController"}));break;default:break}return Promise.reject(e)}))}},t={};function n(r){var o=t[r];if(void 0!==o)return o.exports;var i=t[r]={id:r,loaded:!1,exports:{}};return e[r].call(i.exports,i,i.exports,n),i.loaded=!0,i.exports}n.m=e,function(){n.amdO={}}(),function(){var e=[];n.O=function(t,r,o,i){if(!r){var a=1/0;for(c=0;c<e.length;c++){r=e[c][0],o=e[c][1],i=e[c][2];for(var s=!0,u=0;u<r.length;u++)(!1&i||a>=i)&&Object.keys(n.O).every((function(e){return n.O[e](r[u])}))?r.splice(u--,1):(s=!1,i<a&&(a=i));if(s){e.splice(c--,1);var l=o();void 0!==l&&(t=l)}}return t}i=i||0;for(var c=e.length;c>0&&e[c-1][2]>i;c--)e[c]=e[c-1];e[c]=[r,o,i]}}(),function(){n.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return n.d(t,{a:t}),t}}(),function(){n.d=function(e,t){for(var r in t)n.o(t,r)&&!n.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})}}(),function(){n.f={},n.e=function(e){return Promise.all(Object.keys(n.f).reduce((function(t,r){return n.f[r](e,t),t}),[]))}}(),function(){n.u=function(e){return"js/"+{361:"DashboardController",595:"AboutController",737:"NotFoundController",892:"RegistrationController",954:"HomeController"}[e]+"."+{361:"f2bc0a86",595:"8c2ece28",737:"e34944cf",892:"a9ca6b4d",954:"47acb78e"}[e]+".js"}}(),function(){n.miniCssF=function(e){return"css/NotFoundController.08e15e7e.css"}}(),function(){n.g=function(){if("object"===typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"===typeof window)return window}}()}(),function(){n.hmd=function(e){return e=Object.create(e),e.children||(e.children=[]),Object.defineProperty(e,"exports",{enumerable:!0,set:function(){throw new Error("ES Modules may not assign module.exports or exports.*, Use ESM export syntax, instead: "+e.id)}}),e}}(),function(){n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)}}(),function(){var e={},t="frontent-spa:";n.l=function(r,o,i,a){if(e[r])e[r].push(o);else{var s,u;if(void 0!==i)for(var l=document.getElementsByTagName("script"),c=0;c<l.length;c++){var p=l[c];if(p.getAttribute("src")==r||p.getAttribute("data-webpack")==t+i){s=p;break}}s||(u=!0,s=document.createElement("script"),s.charset="utf-8",s.timeout=120,n.nc&&s.setAttribute("nonce",n.nc),s.setAttribute("data-webpack",t+i),s.src=r),e[r]=[o];var d=function(t,n){s.onerror=s.onload=null,clearTimeout(f);var o=e[r];if(delete e[r],s.parentNode&&s.parentNode.removeChild(s),o&&o.forEach((function(e){return e(n)})),t)return t(n)},f=setTimeout(d.bind(null,void 0,{type:"timeout",target:s}),12e4);s.onerror=d.bind(null,s.onerror),s.onload=d.bind(null,s.onload),u&&document.head.appendChild(s)}}}(),function(){n.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}}(),function(){n.p="/"}(),function(){if("undefined"!==typeof document){var e=function(e,t,n,r,o){var i=document.createElement("link");i.rel="stylesheet",i.type="text/css";var a=function(n){if(i.onerror=i.onload=null,"load"===n.type)r();else{var a=n&&("load"===n.type?"missing":n.type),s=n&&n.target&&n.target.href||t,u=new Error("Loading CSS chunk "+e+" failed.\n("+s+")");u.code="CSS_CHUNK_LOAD_FAILED",u.type=a,u.request=s,i.parentNode&&i.parentNode.removeChild(i),o(u)}};return i.onerror=i.onload=a,i.href=t,n?n.parentNode.insertBefore(i,n.nextSibling):document.head.appendChild(i),i},t=function(e,t){for(var n=document.getElementsByTagName("link"),r=0;r<n.length;r++){var o=n[r],i=o.getAttribute("data-href")||o.getAttribute("href");if("stylesheet"===o.rel&&(i===e||i===t))return o}var a=document.getElementsByTagName("style");for(r=0;r<a.length;r++){o=a[r],i=o.getAttribute("data-href");if(i===e||i===t)return o}},r=function(r){return new Promise((function(o,i){var a=n.miniCssF(r),s=n.p+a;if(t(a,s))return o();e(r,s,null,o,i)}))},o={143:0};n.f.miniCss=function(e,t){var n={737:1};o[e]?t.push(o[e]):0!==o[e]&&n[e]&&t.push(o[e]=r(e).then((function(){o[e]=0}),(function(t){throw delete o[e],t})))}}}(),function(){var e={143:0};n.f.j=function(t,r){var o=n.o(e,t)?e[t]:void 0;if(0!==o)if(o)r.push(o[2]);else{var i=new Promise((function(n,r){o=e[t]=[n,r]}));r.push(o[2]=i);var a=n.p+n.u(t),s=new Error,u=function(r){if(n.o(e,t)&&(o=e[t],0!==o&&(e[t]=void 0),o)){var i=r&&("load"===r.type?"missing":r.type),a=r&&r.target&&r.target.src;s.message="Loading chunk "+t+" failed.\n("+i+": "+a+")",s.name="ChunkLoadError",s.type=i,s.request=a,o[1](s)}};n.l(a,u,"chunk-"+t,t)}},n.O.j=function(t){return 0===e[t]};var t=function(t,r){var o,i,a=r[0],s=r[1],u=r[2],l=0;if(a.some((function(t){return 0!==e[t]}))){for(o in s)n.o(s,o)&&(n.m[o]=s[o]);if(u)var c=u(n)}for(t&&t(r);l<a.length;l++)i=a[l],n.o(e,i)&&e[i]&&e[i][0](),e[i]=0;return n.O(c)},r=self["webpackChunkfrontent_spa"]=self["webpackChunkfrontent_spa"]||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))}();var r=n.O(void 0,[998],(function(){return n(6708)}));r=n.O(r)})();
//# sourceMappingURL=app.b3a95636.js.map