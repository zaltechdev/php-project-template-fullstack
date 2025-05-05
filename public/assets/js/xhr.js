function xhr(endpoint,method,data,callback){
    const xhr = new XMLHttpRequest();
    xhr.open(method,endpoint);
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
            callback(JSON.parse(xhr.response));
        }
    }
    xhr.send(data);
}