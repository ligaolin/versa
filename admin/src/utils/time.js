export let TimeFormatChinese = (timestamp) => { // 时间戳转换为中文式时间
    function zeroize(num) {
        return (String(num).length == 1 ? '0' : '') + num;
    }
    var curTimestamp = parseInt(new Date().getTime() / 1000); //当前时间戳
    var timestampDiff = curTimestamp - timestamp; // 参数时间戳与当前时间戳相差秒数
    var curDate = new Date(curTimestamp * 1000); // 当前时间日期对象
    var tmDate = new Date(timestamp * 1000);  // 参数时间戳转换成的日期对象
    var Y = tmDate.getFullYear(), m = tmDate.getMonth() + 1, d = tmDate.getDate();
    var H = tmDate.getHours(), i = tmDate.getMinutes(), s = tmDate.getSeconds();
    if (timestampDiff < 60) { // 一分钟以内
        return "刚刚";
    } else if (timestampDiff < 3600) { // 一小时前之内
        return Math.floor(timestampDiff / 60) + "分钟前";
    } else if (curDate.getFullYear() == Y && curDate.getMonth() + 1 == m && curDate.getDate() == d) {
        return '今天' + zeroize(H) + ':' + zeroize(i);
    } else {
        var newDate = new Date((curTimestamp - 86400) * 1000); // 参数中的时间戳加一天转换成的日期对象
        if (newDate.getFullYear() == Y && newDate.getMonth() + 1 == m && newDate.getDate() == d) {
            return '昨天' + zeroize(H) + ':' + zeroize(i);
        } else if (curDate.getFullYear() == Y) {
            return zeroize(m) + '月' + zeroize(d) + '日 ' + zeroize(H) + ':' + zeroize(i);
        } else {
            return Y + '年' + zeroize(m) + '月' + zeroize(d) + '日 ' + zeroize(H) + ':' + zeroize(i);
        }
    }
}

export let DateFormat = (stamp, format) => { // 时间戳转时间
    // var time = new Date(stamp*1000);
    var time = new Date(stamp);
    let moth = time.getMonth() + 1;
    let date = time.getDate();
    let hours = time.getHours();
    let minutes = time.getMinutes();
    let second = time.getSeconds();

    format = format.replace("y", time.getFullYear());
    format = format.replace("m", moth < 10 ? '0' + moth : moth);
    format = format.replace("d", date < 10 ? '0' + date : date);
    format = format.replace("h", hours < 10 ? '0' + hours : hours);
    format = format.replace("i", minutes < 10 ? '0' + minutes : minutes);
    format = format.replace("s", second < 10 ? '0' + second : second);
    return format;
}

export let RemainingTime = (stamp) => {// 时间戳转剩余时间
    //作为除数的数字
    var divNumSecond = 1;
    var divNumMinute = 60;
    var divNumHour = 3600;
    var divNumDay = 3600 * 24;

    const day = parseInt(stamp / parseInt(divNumDay))
    const hour = parseInt((stamp % parseInt(divNumDay)) / parseInt(divNumHour))
    const minute = parseInt((parseInt((stamp % parseInt(divNumDay)) % parseInt(divNumHour))) / parseInt(divNumMinute))
    const second = ((parseInt((stamp % parseInt(divNumDay)) % parseInt(divNumHour))) % parseInt(divNumMinute)) / parseInt(divNumSecond)
    return { day: day, hour: hour, minute: minute, second: second };
}