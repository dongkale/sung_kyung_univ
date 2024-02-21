function setCookie(name, value, minutes) {
    let expires = "";
    if (minutes) {
        let date = new Date();
        date.setTime(date.getTime() + minutes * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie =
        name + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function getCookie(key) {
    const cookieString = document.cookie;
    const cookies = cookieString.split(";");

    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        const [cookieKey, cookieValue] = cookie.split("=");
        if (cookieKey === key) {
            return decodeURIComponent(cookieValue);
        }
    }

    return null;
}

function leftpad(num, digits = 2) {
    return num.toString().padStart(digits, "0");
}

// Date() to YYYY-MM-DD HH:MM:SS
function getDateFormat(date) {
    const TIME_ZONE = 9 * 60 * 60 * 1000; // 9시간

    return new Date(date.getTime() + TIME_ZONE)
        .toISOString()
        .replace("T", " ")
        .slice(0, -5);
}

function numFormat(num) {
    return Number(num).toLocaleString("en");
}

function requestPost(url, params) {
    return new Promise((resolve, reject) => {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            },
        });
        $.ajax({
            url: url,
            dataType: "json",
            type: "post",
            data: params,
            success: function (res) {
                var result = false;
                var dataList = [];

                if (res.result_code === 0) {
                    result = true;
                    dataList = res.result_data;
                } else {
                    result = false;
                    dataList = [];
                }

                resolve({
                    result: result,
                    dataList: dataList,
                });
            },
            error: function (err) {
                reject({ err });
            },
        });
    });
}

function compareDateString(dateString1, dateString2) {
    return new Date(dateString1) - new Date(dateString2);
}

function rand(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

function isValidDateString(dateString) {
    return new Date(dateString) != "Invalid Date";
}

function formatPhoneNumber(phoneNumberString) {
    var cleaned = ("" + phoneNumberString).replace(/\D/g, "");
    var match = cleaned.match(/^(\d{3})(\d{4})(\d{4})$/);
    if (match) {
        return match[1] + "-" + match[2] + "-" + match[3];
    }
    return null;
}
