!function (e) {
    var t, n, o, c, i, d,
        l = '<svg><symbol id="icon-gouwuche" viewBox="0 0 1024 1024"><path d="M1007.4 225.7c-4.6-5.9-11.7-9.7-19.2-9.7L201.2 216 167.8 40.5C165.6 29 155.5 21 143.7 21L34 21C20.5 21 9.6 32 9.6 45.5S20.5 70 34 70l89.5 0L155 245.4c0 0.1 0 0.2 0 0.4l98.8 513.6C256 770.9 267 779 278.7 779l587.2 0c13.5 0 24.5-11 24.5-24.5s-11-24.5-24.5-24.5L298.9 730l-15.1-77.2 612.3 3.2c0 0 0 0 0 0 11.3 0 21.2-9.5 23.8-20.5l92-389C1013.7 239.1 1012 231.5 1007.4 225.7zM876.8 603.7l-602.3-1.2-44.6-233.9L210.5 266l746.8 0L876.8 603.7z"  ></path><path d="M353.1 829.4c-47.2 0-85.6 38.4-85.6 85.6s38.4 85.6 85.6 85.6c47.2 0 85.6-38.4 85.6-85.6S400.3 829.4 353.1 829.4zM353.1 951.8c-20.2 0-36.7-16.5-36.7-36.7 0-20.2 16.5-36.7 36.7-36.7 20.2 0 36.7 16.5 36.7 36.7C389.8 935.3 373.3 951.8 353.1 951.8z"  ></path><path d="M769 829.4c-47.2 0-85.6 38.4-85.6 85.6s38.4 85.6 85.6 85.6c47.2 0 85.6-38.4 85.6-85.6S816.3 829.4 769 829.4zM769 951.8c-20.2 0-36.7-16.5-36.7-36.7 0-20.2 16.5-36.7 36.7-36.7 20.2 0 36.7 16.5 36.7 36.7C805.7 935.3 789.3 951.8 769 951.8z"  ></path></symbol></svg>',
        a = (a = document.getElementsByTagName("script"))[a.length - 1].getAttribute("data-injectcss");
    if (a && !e.__iconfont__svg__cssinject__) {
        e.__iconfont__svg__cssinject__ = !0;
        try {
            document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>")
        } catch (e) {
            console && console.log(e)
        }
    }

    function s() {
        i || (i = !0, o())
    }

    t = function () {
        var e, t, n, o;
        (o = document.createElement("div")).innerHTML = l, l = null, (n = o.getElementsByTagName("svg")[0]) && (n.setAttribute("aria-hidden", "true"), n.style.position = "absolute", n.style.width = 0, n.style.height = 0, n.style.overflow = "hidden", e = n, (t = document.body).firstChild ? (o = e, (n = t.firstChild).parentNode.insertBefore(o, n)) : t.appendChild(e))
    }, document.addEventListener ? ~["complete", "loaded", "interactive"].indexOf(document.readyState) ? setTimeout(t, 0) : (n = function () {
        document.removeEventListener("DOMContentLoaded", n, !1), t()
    }, document.addEventListener("DOMContentLoaded", n, !1)) : document.attachEvent && (o = t, c = e.document, i = !1, (d = function () {
        try {
            c.documentElement.doScroll("left")
        } catch (e) {
            return void setTimeout(d, 50)
        }
        s()
    })(), c.onreadystatechange = function () {
        "complete" == c.readyState && (c.onreadystatechange = null, s())
    })
}(window);