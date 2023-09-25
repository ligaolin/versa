export const setItem = (key,data,expirTime=0)=>{ // 0 永久，>0 过期时间，<0 浏览器刷新或关闭丢失
    let addTime = Date.now()
    if(!expirTime){
        localStorage.setItem(key,JSON.stringify({data:data,expirTime:expirTime,addTime:addTime}))
    }else if(expirTime<0){
        sessionStorage.setItem(key,JSON.stringify({data:data,expirTime:expirTime,addTime:addTime}))
    }else{
        localStorage.setItem(key,JSON.stringify({data:data,expirTime:expirTime,addTime:addTime}))
    }
}

export const getItem = (key)=>{
    let data = localStorage.getItem(key),isLocal = true
    if(!data) {
        data  = sessionStorage.getItem(key)
        isLocal = false
    }
    if(data && data!='undefined' && data!='[object Object]' && typeof(data)=='string') {
        data = JSON.parse(data)
    }

    if(data && data.expirTime && data.expirTime>0 && data.addTime){
        let addTime = Date.now(),time = data.addTime+(data.expirTime*1000)
        if(addTime>time) {
            data = null
            if(isLocal) localStorage.removeItem(key)
            else sessionStorage.removeItem(key)
        }
    }
    if(data.data) return data.data
    else return null
}