import{Z as w,a as d,H as V,w as l,az as z,l as E,d as y,q as r,e as a,a4 as D,P,E as T,i as x,k as B,a6 as K,__tla as N}from"./index-7aad57f9.js";import U,{__tla as q}from"./edit-7754f140.js";import{__tla as H}from"./other-1d706a0b.js";let k,L=Promise.all([(()=>{try{return N}catch{}})(),(()=>{try{return q}catch{}})(),(()=>{try{return H}catch{}})()]).then(async()=>{k={__name:"index",setup(M){const b=w(),o=d(""),i=d(""),g=()=>{let e={pid:0};return o.value&&(e.name=o.value),i.value&&(e.comment=i.value),["TableList",e]},m=d(null),_=e=>{m.value.Del("TableDel",e,"name")},p=(e={})=>{e.name?(e.oldName=e.name,m.value.Edit("\u7F16\u8F91 "+e.name,e)):m.value.Edit("\u6DFB\u52A0",e)},v=e=>{b.push("/setting/table/field?table="+e.name)},C=()=>{D.confirm("\u786E\u5B9A\u5907\u4EFD\u6570\u636E\u5E93\u5417").then(()=>{P("TableBackups").then(e=>{e.code==2e3&&T({message:e.msg,type:"success"})})}).catch(()=>{})};return(e,n)=>{const f=x,u=B,c=K,h=z;return E(),V(h,{getData:g,editPage:U,ref_key:"listEleme",ref:m,rowKey:"name",page:!1},{search:l(()=>[y("label",null,[r("\u6570\u636E\u8868\u540D\u79F0\uFF1A"),a(f,{clearable:"",modelValue:o.value,"onUpdate:modelValue":n[0]||(n[0]=t=>o.value=t)},null,8,["modelValue"])]),y("label",null,[r("\u6570\u636E\u8868\u6CE8\u91CA\uFF1A"),a(f,{clearable:"",modelValue:i.value,"onUpdate:modelValue":n[1]||(n[1]=t=>i.value=t)},null,8,["modelValue"])])]),operation:l(({ids:t})=>[a(u,{type:"primary",onClick:n[2]||(n[2]=s=>p())},{default:l(()=>[r("\u6DFB\u52A0")]),_:1}),a(u,{type:"danger",onClick:s=>_(t)},{default:l(()=>[r("\u6279\u91CF\u5220\u9664")]),_:2},1032,["onClick"]),a(u,{onClick:n[3]||(n[3]=s=>C())},{default:l(()=>[r("\u6570\u636E\u5E93\u5907\u4EFD")]),_:1})]),default:l(()=>[a(c,{type:"selection",width:"55",align:"center"}),a(c,{prop:"name",label:"\u6570\u636E\u8868\u540D\u79F0",align:"center"}),a(c,{prop:"comment",label:"\u6570\u636E\u8868\u6CE8\u91CA",align:"center"}),a(c,{label:"\u64CD\u4F5C",align:"center"},{default:l(t=>[a(u,{type:"primary",size:"small",onClick:s=>v(t.row)},{default:l(()=>[r("\u5B57\u6BB5")]),_:2},1032,["onClick"]),a(u,{type:"primary",size:"small",onClick:s=>p(t.row)},{default:l(()=>[r("\u7F16\u8F91")]),_:2},1032,["onClick"]),a(u,{type:"danger",size:"small",onClick:s=>_(t.row.name)},{default:l(()=>[r("\u5220\u9664")]),_:2},1032,["onClick"])]),_:1})]),_:1},512)}}}});export{L as __tla,k as default};
