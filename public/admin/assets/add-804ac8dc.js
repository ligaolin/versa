import{a as b,c as f,e as t,w as l,ay as h,l as v,q as g,P as V,E as m,i as k,k as E,__tla as q}from"./index-8a19135e.js";import{O as x,E as P,__tla as j}from"./other-c7b5f4f5.js";let n,w=Promise.all([(()=>{try{return q}catch{}})(),(()=>{try{return j}catch{}})()]).then(async()=>{let s;s={class:"edit_table"},n={__name:"add",props:["data"],emits:["submit"],setup(d,{emit:_}){const c=d,a=b({path:"",name:""});x(c.data,a.value);const o=()=>{P([[!a.value.name,"\u540D\u79F0\u4E0D\u80FD\u4E3A\u7A7A"]])&&V("FileAdd",a.value).then(e=>{e.code==2e3?(m({message:e.msg,type:"success"}),_("submit")):m({message:e.msg,type:"error"})})};return(e,r)=>{const i=k,u=h,p=E;return v(),f("table",s,[t(u,{label:"\u540D\u79F0",required:""},{default:l(()=>[t(i,{clearable:"",modelValue:a.value.name,"onUpdate:modelValue":r[0]||(r[0]=y=>a.value.name=y)},null,8,["modelValue"])]),_:1}),t(u,null,{default:l(()=>[t(p,{type:"primary",onClick:o},{default:l(()=>[g("\u63D0\u4EA4")]),_:1})]),_:1})])}}}});export{w as __tla,n as default};
