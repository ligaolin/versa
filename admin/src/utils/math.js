export const AccAdd = (arg1, arg2) => {
    var r1, r2, m;
    try { r1 = arg1.toString().split(".")[1].length } catch (e) { r1 = 0 }
    try { r2 = arg2.toString().split(".")[1].length } catch (e) { r2 = 0 }
    m = Math.pow(10, Math.max(r1, r2));
    return (arg1 * m + arg2 * m) / m;
}

export const AccSub = (arg1, arg2) => { // 浮点数减法
    var r1, r2, m, n;
    try {
        r1 = arg1.toString().split(".")[1].length;
    } catch (e) {
        r1 = 0;
    }
    try {
        r2 = arg2.toString().split(".")[1].length;
    } catch (e) {
        r2 = 0;
    }
    m = Math.pow(10, Math.max(r1, r2)); //last modify by deeka //动态控制精度长度  
    n = (r1 >= r2) ? r1 : r2;
    return ((arg1 * m - arg2 * m) / m).toFixed(n);
}

export const AccMul = (arg1, arg2) => { // 浮点数乘法
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try {
        m += s1.split(".")[1].length;
    } catch (e) { }
    try {
        m += s2.split(".")[1].length;
    } catch (e) { }
    return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}

// 获取随机整数，包含start，不包括end
export const Random = (start, end) => {
    start = parseInt(start)
    end = parseInt(end)
    return Math.floor((end - start) * Math.random() + start)
}

const itemRam = (arr, tmp) => {
    let index = this.Random(0, arr.length)
    let checked = false
    for (let i in tmp) {
        if (tmp[i] == arr[index]) {
            checked = true
        }
    }
    if (checked) {
        return itemRam(arr, tmp)
    } else {
        return arr[index]
    }
}

// 从数组中获取指定数量的随机元素组成的新数组
export const ArrRandom = (num, arr) => {
    if (num > arr.length) return arr
    let tmp = []
    for (let i = 0; i < num; i++) {
        tmp.push(itemRam(arr, tmp))
    }
    return tmp;
}