var notify
(function() {
notify = function(title, message, image) {
    var havePermission = window.webkitNotifications.checkPermission();

    if (havePermission == 0) {
        var wrap = document.createElement("div");
        wrap.innerHTML = message;
        message = (wrap.innerText) ? wrap.innerText : message;

        // 0 is PERMISSION_ALLOWED
        var notification = window.webkitNotifications.createNotification(
          'http://png-4.findicons.com/files/icons/2443/bunch_of_cool_bluish_icons/512/chat.png', // image
          title,
          message
        );

        notification.onclick = function() {
            window.focus();
            notification.cancel();
        };

        notification.show();

        setTimeout(function() {
            notification.cancel();
        }, 10000)
    } else {
        window.webkitNotifications.requestPermission();
    }
};

})()
