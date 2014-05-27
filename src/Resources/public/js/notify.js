var notify
(function() {
notify = function(title, message, image) {
    if (!("Notification" in window)) {
        return
    }

    var permissions = Notification.permission

    if (permissions !== "granted") {
        Notification.requestPermission(function (permission) {
            notify(title, message, image)
        })
    }

    if (permissions === "granted") {
        var wrap = document.createElement("div");
        wrap.innerHTML = message;
        message = (wrap.innerText) ? wrap.innerText : message;

        var notification = new Notification(title, {
            body: message,
            icon: 'http://png-4.findicons.com/files/icons/2443/bunch_of_cool_bluish_icons/512/chat.png', // image
        });

        notification.onclick = function() {
            window.focus();
            notification.close();
        };

        setTimeout(function() {
            notification.close();
        }, 10000)
    }
};

})()
