import{a as v,c as y,e as a,w as s,ay as f,l as V,q as g,P as h,E as d,i as E,k,__tla as U}from"./index-8a19135e.js";import{O as q,E as x,__tla as A}from"./other-c7b5f4f5.js";let n,P=Promise.all([(()=>{try{return U}catch{}})(),(()=>{try{return A}catch{}})()]).then(async()=>{let m;m={class:"edit_table"},n={__name:"edit",props:["data"],emits:["submit"],setup(_,{emit:i}){const c=_,e=v({id:"",pid:0,level:1,name:"",route:""});q(c.data,e.value);const p=()=>{x([[!e.value.name,"\u6743\u9650\u540D\u79F0\u4E0D\u80FD\u4E3A\u7A7A"]])&&h("UserAuthAdminEdit",e.value).then(l=>{l.code==2e3?(d({message:l.msg,type:"success"}),i("submit")):d({message:l.msg,type:"error"})})};return(l,t)=>{const o=E,u=f,b=k;return V(),y("table",m,[a(u,{label:"\u6743\u9650\u540D\u79F0",required:""},{default:s(()=>[a(o,{clearable:"",modelValue:e.value.name,"onUpdate:modelValue":t[0]||(t[0]=r=>e.value.name=r)},null,8,["modelValue"])]),_:1}),a(u,{label:"\u8DEF\u7531"},{default:s(()=>[a(o,{clearable:"",modelValue:e.value.route,"onUpdate:modelValue":t[1]||(t[1]=r=>e.value.route=r)},null,8,["modelValue"])]),_:1}),a(u,null,{default:s(()=>[a(b,{type:"primary",onClick:p},{default:s(()=>[g("\u63D0\u4EA4")]),_:1})]),_:1})])}}}});export{P as __tla,n as default};
