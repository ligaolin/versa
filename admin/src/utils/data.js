export const ObjSetObj = (data1, data2) => {
    for(let i in data2){
        for(let j in data1){
            if(i==j) data2[i] = data1[j]
        }
    }
}

export const Error = (data) => {
    for(let i in data){
        if(data[i].length>=2 && data[i][0]) {ElMessage({message:data[i][1],type:'error'});return false;}
    }
    return true
}

export const Submit = (edit,param,emit,fun='submit') => {
    edit(param).then(res=>{
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            emit(fun)
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}

import Request from '@/utils/request'
export const SetUrl = async (apiArr,key,param) => {
    for(let i in apiArr){
        if(apiArr[i].length>=2 &&  key==apiArr[i][0]){
            return await Request.post(apiArr[i][1],param)
        }
    }
}