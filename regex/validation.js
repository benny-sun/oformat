/**
 * Created by Hao on 2017/5/5.
 */

var regex = {
    Name: /^([\u4e00-\u9fa5A-z\s]{0,})$/,
    Mobile: /^(09\d{2})?((\+)?886\d{3})?-?\d{3}-?\d{3}$/,
    Tel: /^(0\d+)-?(-?[\d{7,8}])+(?:(?:#)(\d+))?$/,
    Address: /^[^;'<>@#\$%\^&\*]+$/,
    Email: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    Integer: /^[+\-]?\d+$/,
    PositiveInt: /^\d+$/,
    Numeric: /[0-9]+.[0-9]+/,
    Url: /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/,
    Youtube: /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/,
    Account: /^[A-z0-9]+$/,
    Password_01: /.*/,  //任意字
    Password_02: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{0,}$/,   //至少 1字母 1數字
    Password_03: /"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{0,}$"/   //至少 1大寫字母 1小寫字母 1數字
};

function sgwValidate(id, value, index, allowEmpty, minLength) {
    allowEmpty = (typeof allowEmpty !== 'undefined') ? allowEmpty : false;
    var status = 0;
    var isEmpty = value.replace(/\s/g,'') === "";
    if (typeof regex[index] === "undefined") {
        status = -1;
    } else if (id === "") {
        status = -2;
    } else {
        if (!(allowEmpty && isEmpty)) {
            if (isEmpty) {
                status += 2;
            } else {
                if (! regex[index].test(value)) {
                    status += 1;
                }
                if (value.length < minLength) {
                    status += 4;
                }
            }
        }
    }
    return {id: id, value: value, code: index, error: status};
}

function ValidScan() {
    var count = document.getElementsByClassName("sgwValid").length;
    var sgwValid = document.getElementsByClassName("sgwValid");
    result = [];
    for (i=0; i<count; i++) {
        id = sgwValid[i].id;
        index = sgwValid[i].getAttribute("sgwValid");
        min_length = sgwValid[i].getAttribute("sgwMinLength");
        allow_empty = sgwValid[i].getAttribute("sgwAllowEmpty");
        if (index === null) { continue; }
        val = sgwValid[i].value;
        result.push(sgwValidate(id, val, index, allow_empty, min_length));
        // if (id === "") {
        //     result.push(sgwValidate(id, val, index, allow_empty, min_length));
        // } else {
        //     result.push(sgwValidate(id, val, index, allow_empty, min_length));
        // }
    }
    console.log(result);
    return result;
}