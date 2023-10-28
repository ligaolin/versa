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

export const Fullscreen = (isFull)=>{
    if(isFull){ // 全屏
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen()
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen()
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen()
        } else if (document.documentElement.msRequestFullscreen) {
            document.documentElement.msRequestFullscreen()
        }
    }else{ // 退出全屏
        if (document.exitFullscreen) {
            document.exitFullscreen()
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen()
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen()
        }
    }
}