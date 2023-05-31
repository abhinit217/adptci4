
const rootUrl = $('#rootUrl').val();
console.log(rootUrl);

const get = (url, isSameUrl) => {
    let path = isSameUrl ? url : rootUrl + url;
    return new Promise((resolve, reject) => {
        $.ajax({
            "type": "GET",
            "url": path,
            "headers": {
                "Content-Type": "application/json"
            },
            "success": (response) => {
                if (!path.includes('.html')) {
                    response = JSON.parse(response);
                }
                resolve(response);
            },
            "error": (err) => {
                reject(err);
            }
        });
    });
}

const post = (url, requestBody) => {
    let path = rootUrl + url;
    return new Promise((resolve, reject) => {
        $.ajax({
            "type": "POST",
            "url": path,
            "data": JSON.stringify(requestBody),
            "success": (response) => {
                response = JSON.parse(response);
                resolve(response);
            },
            "error": (err) => {
                reject(err);
            }
        });
    });

}
const clone = (obj) => {
   return JSON.parse(JSON.stringify(obj));
}