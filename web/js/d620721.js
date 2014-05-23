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

/**
 * @link https://github.com/joewalnes/reconnecting-websocket/blob/master/reconnecting-websocket.js
 */
function ReconnectingWebSocket(url, protocols) {
    protocols = protocols || [];

    // These can be altered by calling code.
    this.debug = false;
    this.reconnectInterval = 1000;
    this.timeoutInterval = 2000;

    var self = this;
    var ws;
    var forcedClose = false;
    var timedOut = false;
    
    this.url = url;
    this.protocols = protocols;
    this.readyState = WebSocket.CONNECTING;
    this.URL = url; // Public API

    this.onopen = function(event) {
    };

    this.onclose = function(event) {
    };

    this.onconnecting = function(event) {
    };

    this.onmessage = function(event) {
    };

    this.onerror = function(event) {
    };

    function connect(reconnectAttempt) {
        ws = new WebSocket(url, protocols);
        
        self.onconnecting();
        if (self.debug || ReconnectingWebSocket.debugAll) {
            console.debug('ReconnectingWebSocket', 'attempt-connect', url);
        }
        
        var localWs = ws;
        var timeout = setTimeout(function() {
            if (self.debug || ReconnectingWebSocket.debugAll) {
                console.debug('ReconnectingWebSocket', 'connection-timeout', url);
            }
            timedOut = true;
            localWs.close();
            timedOut = false;
        }, self.timeoutInterval);
        
        ws.onopen = function(event) {
            clearTimeout(timeout);
            if (self.debug || ReconnectingWebSocket.debugAll) {
                console.debug('ReconnectingWebSocket', 'onopen', url);
            }
            self.readyState = WebSocket.OPEN;
            reconnectAttempt = false;
            self.onopen(event);
        };
        
        ws.onclose = function(event) {
            clearTimeout(timeout);
            ws = null;
            if (forcedClose) {
                self.readyState = WebSocket.CLOSED;
                self.onclose(event);
            } else {
                self.readyState = WebSocket.CONNECTING;
                self.onconnecting();
                if (!reconnectAttempt && !timedOut) {
                    if (self.debug || ReconnectingWebSocket.debugAll) {
                        console.debug('ReconnectingWebSocket', 'onclose', url);
                    }
                    self.onclose(event);
                }
                setTimeout(function() {
                    connect(true);
                }, self.reconnectInterval);
            }
        };
        ws.onmessage = function(event) {
            if (self.debug || ReconnectingWebSocket.debugAll) {
                console.debug('ReconnectingWebSocket', 'onmessage', url, event.data);
            }
            self.onmessage(event);
        };
        ws.onerror = function(event) {
            if (self.debug || ReconnectingWebSocket.debugAll) {
                console.debug('ReconnectingWebSocket', 'onerror', url, event);
            }
            self.onerror(event);
        };
    }
    connect(url);

    this.send = function(data) {
        if (ws) {
            if (self.debug || ReconnectingWebSocket.debugAll) {
                console.debug('ReconnectingWebSocket', 'send', url, data);
            }
            return ws.send(data);
        } else {
            throw 'INVALID_STATE_ERR : Pausing to reconnect websocket';
        }
    };

    this.close = function() {
        forcedClose = true;
        if (ws) {
            ws.close();
        }
    };

    /**
     * Additional public API method to refresh the connection if still open (close, re-open).
     * For example, if the app suspects bad data / missed heart beats, it can try to refresh.
     */
    this.refresh = function() {
        if (ws) {
            ws.close();
        }
    };
}

/**
 * Setting this to true is the equivalent of setting all instances of ReconnectingWebSocket.debug to true.
 */
ReconnectingWebSocket.debugAll = false;
var conn;

(function() {
    var unreadMessages = 0

    function Parameters(storage) {
        this.storage = storage
        this.defaults = {
            "beepOnPing": true,
            "notifOnMessage": true,
            "notifOnPing": true
        }
    }
    Parameters.prototype = {
        set: function(key, value) {
            this.storage.setItem(key, value)
        },
        get: function(key) {
            var value = this.storage.getItem(key)

            if (null === value) {
                this.set(key, this.defaults[key])

                return this.defaults[key]
            }

            return value
        },
        remove: function(key) {
            this.storage.removeItem(key)
        },
        forEach: function(callable) {
            for (var i in this.defaults) {
                if (!this.defaults.hasOwnProperty(i)) {
                    continue
                }

                callable(i, this.get(i))
            }
        }
    }

    var ima = $("#chat-nickname").text()
        parameters = new Parameters(localStorage)


    function ParseEvent() {
        this.propagationStopped = false
    }
    ParseEvent.prototype = {
        stopPropagation: function() {
            this.propagationStopped = true
        },
        isPropagationStopped: function() {
            return this.propagationStopped
        }
    }

    function WhoAreYou() {
    }
    WhoAreYou.prototype = {
        matches: function(input) {
            return input.cmd == 'WHORU'
        },
        execute: function(conn, input) {
            conn.send(JSON.stringify({cmd: "IMA", data: ima}))
        }
    }

    function NewlineParser() {
    }
    NewlineParser.prototype = {
        parse: function(content, event) {
            return content.replace(/\n/g, "<br>")
        }
    }
    function ImageParser() {
    }
    ImageParser.prototype = {
        parse: function(content, event) {
            if (!content.split('.').pop().toLowerCase().match(/(jpg|jpeg|png|gif)/)) {
                return content
            }

            if (('http://' != content.slice(0, 7))
                && ('https://' != content.slice(0, 8))
                && ('//' != content.slice(0, 2))
            ) {
                return content
            }

            event.stopPropagation()

            var loader = new Image
            loader.src = "http://www.inis.qc.ca/public/inis/images/loader.gif"
            loader.setAttribute("class", "img loader")

            return ''+
                '<a target="_blank" href="'+content+'">'+
                    '<img src="'+content+'" class="hidden" onload="$(this).attr(\'class\', \'img\'); $(this).next().remove(); $(\'.messages-container\').scrollTop(99999999)">'+
                    loader.outerHTML+
                '</a>'
            ;
        }
    }

    function SafelizeParser() {
    }
    SafelizeParser.prototype = {
        parse: function(content, event) {
            return content.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }
    }
    function LinkParser() {
    }
    LinkParser.prototype = {
        parse: function(content, event) {
            if (('http://' == content.slice(0, 7)) || ('https://' == content.slice(0, 8)) || ('//' == content.slice(0, 2))) {
                event.stopPropagation()

                return '<a target="_blank" href="'+content+'">'+content+'</a>';
            }

            return content.replace(/http([^\s\b]+)/gi, '<a href="http$1" target="_blank">http$1</a>')
        }
    }
    function YoutubeParser() {
    }
    YoutubeParser.prototype = {
        parse: function(content, event) {
            if (-1 == content.indexOf("youtube.com/watch")
                && -1 == content.indexOf("youtu.be")
            ) {
                return content
            }

            var matches = content.match(/(?:\?|&)v=([^$\&\b]+)/),
                ytid = null

            if (null !== matches) {
                ytid = matches[1]
            } else {
                matches = content.match(/youtu.be\/([^$\&\b]+)/)

                if (null !== matches) {
                    ytid = matches[1]
                }
            }

            if (null === ytid) {
                return content
            }

            event.stopPropagation()

            return '<iframe width="560" height="315" src="//www.youtube.com/embed/'+ytid+'?rel=0" frameborder="0" allowfullscreen></iframe>'
        }
    }
    function AtTargetParser() {
    }
    AtTargetParser.prototype = {
        parse: function(content, event) {
            if (!content.match(new RegExp("\@"+ima))) {
                return content
            }

            if ('true' == parameters.get("notifOnPing") && document.webkitHidden) {
                notify("@"+ima, content)
            }

            if ('true' == parameters.get("beepOnPing")) {
                document.getElementById("beeper").play()
            }

            return content
        }
    }

    function Message() {
        this.parsers = [new SafelizeParser, new NewlineParser, new YoutubeParser, new ImageParser, new LinkParser, new AtTargetParser]
    }
    Message.prototype = {
        addParser: function(parser) {
            this.parsers.push(parser)
        },
        matches: function(input) {
            return input.cmd == 'MSG'
        },
        execute: function(conn, input) {
            var content = input.data.content
            var event = new ParseEvent;

            for (i in this.parsers) {
                content = this.parsers[i].parse(content, event)

                if (event.isPropagationStopped()) {
                    break;
                }
            }

            if (document.webkitHidden) {
                unreadMessages++;
                $("title").text("("+unreadMessages+") - Chat Room");

                if ('true' == parameters.get("notifOnMessage") && input.data.from != ima) {
                    notify(input.data.from, content)
                }
            }

            var last = $(".message-container:last")

            if (last.length && last.attr("data-author") == input.data.from) {
                box = last.find(".message-box")[0]

                var message = document.createElement("div")
                message.setAttribute("class", "message")
                message.innerHTML = content

                box.appendChild(message)

                var date = new Date,
                    hours = date.getHours() < 10 ? '0'+date.getHours() : date.getHours(),
                    mins = date.getMinutes() < 10 ? '0'+date.getMinutes() : date.getMinutes(),
                    secs = date.getSeconds() < 10 ? '0'+date.getSeconds() : date.getSeconds()

                var hour = document.createElement("div")
                hour.setAttribute("class", "pull-right hour")
                hour.innerHTML = hours+':'+mins+':'+secs

                box.insertBefore(hour, message)

                $(".messages-container").scrollTop(99999999)

                return;
            }

            var container = document.createElement("div")
            container.setAttribute("class", "message-container row")
            container.setAttribute("data-author", input.data.from)

            var author = document.createElement('div')
            author.setAttribute("class", "author col-md-1")
            author.innerHTML = input.data.from

            container.appendChild(author)

            var box = document.createElement("div")
            box.setAttribute("class", "message-box col-md-11")

            var message = document.createElement("div")
            message.setAttribute("class", "message")
            message.innerHTML = content

            box.appendChild(message)

            var date = new Date,
                hours = date.getHours() < 10 ? '0'+date.getHours() : date.getHours(),
                mins = date.getMinutes() < 10 ? '0'+date.getMinutes() : date.getMinutes(),
                secs = date.getSeconds() < 10 ? '0'+date.getSeconds() : date.getSeconds()

            var hour = document.createElement("div")
            hour.setAttribute("class", "pull-right hour")
            hour.innerHTML = hours+':'+mins+':'+secs

            box.insertBefore(hour, message)

            container.appendChild(box)

            $(container).appendTo($(".messages-container"))
            $(".messages-container").scrollTop(99999999)
        }
    }

    function Welcome() {
    }
    Welcome.prototype = {
        matches: function(input) {
            return input.cmd == 'WELCOME'
        },
        execute: function(conn, input) {
            if ($("#overlay").is(":visible")) {
                $("#overlay").fadeOut()
            }

            conn.send(JSON.stringify({cmd: "GIMELIST", data:null}))

            var container = document.createElement("div")
            container.setAttribute("class", "message-container row")
            container.setAttribute("data-author", input.data)

            var author = document.createElement('div')
            author.setAttribute("class", "author col-md-1")
            author.innerHTML = input.data

            container.appendChild(author)

            var box = document.createElement("div")
            box.setAttribute("class", "message-box col-md-11")

            var message = document.createElement("div")
            message.setAttribute("class", "message")
            message.innerHTML = "*** JOINED CHAT ***"

            box.appendChild(message)

            container.appendChild(box)

            $(container).appendTo($(".messages-container"))
            $(".messages-container").scrollTop(99999999)
        }
    }

    function Leaving() {
    }
    Leaving.prototype = {
        matches: function(input) {
            return input.cmd == 'LEAVE'
        },
        execute: function(conn, input) {
            conn.send(JSON.stringify({cmd: "GIMELIST", data:null}))

            var container = document.createElement("div")
            container.setAttribute("class", "message-container row")
            container.setAttribute("data-author", input.data)

            var author = document.createElement('div')
            author.setAttribute("class", "author col-md-1")
            author.innerHTML = input.data

            container.appendChild(author)

            var box = document.createElement("div")
            box.setAttribute("class", "message-box col-md-11")

            var message = document.createElement("div")
            message.setAttribute("class", "message")
            message.innerHTML = "*** LEFT CHAT ***"

            box.appendChild(message)

            container.appendChild(box)

            $(container).appendTo($(".messages-container"))
            $(".messages-container").scrollTop(99999999)
        }
    }

    function DaList() {
    }
    DaList.prototype = {
        matches: function(input) {
            return input.cmd == 'DALIST'
        },
        execute: function(conn, input) {
            var users = $(".users-container")
            users.html('')

            input.data.forEach(function(user) {
                var container = document.createElement("div")
                container.setAttribute("class", "user")
                container.setAttribute("data-reference", user)

                var link = document.createElement("a")
                link.setAttribute("href", "#")
                link.innerHTML = user

                container.appendChild(link)

                $(container).appendTo(users)
            })
        }
    }

    $("#chat-sender").on("keydown", function(event) {
        var keyCode = (event.which ? event.which : event.keyCode);

        if (keyCode != 10 && keyCode != 13) {
            return;
        }

        if (true === event.ctrlKey) {
            $(this).val($(this).val() + String.fromCharCode("13"))

            return;
        }

        event.preventDefault()
        var send = $(this).val()

        if (!send) {
            return
        }

        $(this).val('')

        var command = "MSG",
            data = send

        if ('/' == send.slice(0, 1)) {
            var last = send.indexOf(" ")

            if (last == -1) {
                last = undefined
            }

            var command = send.slice(1, last),
                data = null

            if (undefined !== last) {
                data = send.slice(last + 1)
            }
        }

        conn.send(JSON.stringify({cmd: command, data: data}))
    })

    $(".users-container").on("click", ".user", function(event) {
        event.preventDefault()

        $("#chat-sender").val($("#chat-sender").val() + '@' + $(this).attr("data-reference") + ' ')

        $("#chat-sender")[0].focus()
    })

    $("#chat-sender").on("focus", function(event) {
        if (this.setSelectionRange) {
            var len = $(this).val().length * 2;
            this.setSelectionRange(len, len);
        } else {
            $(this).val($(this).val())
        }

        this.scrollTop = 999999;
    })

    $(".parameters-container").on("click", "[data-parameter]", function(element) {
        parameters.set($(this).attr("data-parameter"), $(this).is(":checked"))
    })

    parameters.forEach(function(parameter, value) {
        value = !!('true' == value)

        $(".parameters-container").find('[data-parameter="'+parameter+'"]').prop("checked", value)
    })

    var commands = [
        new WhoAreYou,
        new Message,
        new Welcome,
        new Leaving,
        new DaList
    ]


    conn = new ReconnectingWebSocket('ws://chat.devel:8080/socket');

    conn.onmessage = function(e) {
        var data = JSON.parse(e.data)

        commands.forEach(function(element) {
            if (true === element.matches(data)) {
                element.execute(conn, data)
            }
        })
    };
    conn.onerror = function(e) {
        if ($("#overlay").is(":hidden")) {
            $("#overlay").fadeIn()
        }

        $("#overlay-content").text('Déconnecté du chat. Réessai...')
    };
    conn.onclose = function(e) {
        if ($("#overlay").is(":hidden")) {
            $("#overlay").fadeIn()
        }

        $("#overlay-content").text('Déconnecté du chat. Réessai...')
    };

    document.addEventListener("webkitvisibilitychange", function(e) {
        if (!document.webkitHidden) {
            unreadMessages = 0;
            $("title").text("Chat Room");
        }
    });

    document.getElementById("chat-sender").focus()
})()
