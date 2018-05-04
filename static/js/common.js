function changetoVersion(arg1, arg2) {
    setcookie('lang', arg1);
    if (location.href.indexOf('?lang=') != '-1' || location.href.indexOf('?') == '-1') {
        arg1 = '?lang=' + arg1;
        arg2 = '?lang=' + arg2;
    } else {
        arg1 = '&lang=' + arg1;
        arg2 = '&lang=' + arg2;
    }
    if (location.href.indexOf(arg1) != '-1') {
        location.reload();
    } else if (location.href.indexOf(arg2) != '-1') {
        location.href = location.href.replace(arg2, '')
                + arg1;
    } else {
        location.href += arg1;
    }
}

/**
 * 修改指定表的指定字段值
 */
function changeTableVal(url, table, id_name, id_value, field, obj) {
    var src = "";
    var value = 0;
    if ($(obj).attr('src').indexOf("cancel.png") > 0) {
        src = '/static/images/yes.png';
        value = 0;
    } else {
        src = '/static/images/cancel.png';
        value = 1;
    }
    var url = url + '/changeTableVal/?table=' + table + '&id_name=' + id_name + "&id_value=" + id_value + "&field=" + field + "&value=" + value;
    debug(url);
    $.ajax({
        url: url,
        success: function (data) {
            $(obj).attr('src', src);
        }
    });
}
/**
 * 修改指定表的排序字段
 */
function updateSort(table, id_name, id_value, field, obj) {
    var value = $(obj).val();
    $.ajax({
        url: siteurl + "/ajax.php?action=changeTableVal&table=" + table + "&id_name=" + id_name + "&id_value=" + id_value + "&field=" + field + '&value=' + value,
        success: function (data) {
            //layer.msg('更新成功', {icon: 1});
        }
    });
}
function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
    if (cookieValue == '' || seconds < 0) {
        cookieValue = '';
        seconds = -2592000;
    }
    if (seconds) {
        var expires = new Date();
        expires.setTime(expires.getTime() + seconds * 1000);
    }
    domain = !domain ? cookiedomain : domain;
    path = !path ? cookiepath : path;
    document.cookie = escape(cookiepre + cookieName) + '=' + escape(cookieValue)
            + (expires ? '; expires=' + expires.toGMTString() : '')
            + (path ? '; path=' + path : '/')
            + (domain ? '; domain=' + domain : '')
            + (secure ? '; secure' : '');
}
function getcookie(name, nounescape) {
    name = cookiepre + name;
    var cookie_start = document.cookie.indexOf(name);
    var cookie_end = document.cookie.indexOf(";", cookie_start);
    if (cookie_start == -1) {
        return '';
    } else {
        var v = document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length));
        return !nounescape ? unescape(v) : v;
    }
}
function saveUserdata(name, data) {
    try {
        if (window.localStorage) {
            localStorage.setItem('luomg_' + name, data);
        } else if (window.sessionStorage) {
            sessionStorage.setItem('luomg_' + name, data);
        }
    } catch (e) {
        if (BROWSER.ie) {
            if (data.length < 54889) {
                with (document.documentElement) {
                    setAttribute("value", data);
                    save('luomg_' + name);
                }
            }
        }
    }
    setcookie('clearUserdata', '', -1);
}
function loadUserdata(name) {
    if (window.localStorage) {
        return localStorage.getItem('luomg_' + name);
    } else if (window.sessionStorage) {
        return sessionStorage.getItem('luomg_' + name);
    } else if (BROWSER.ie) {
        with (document.documentElement) {
            load('luomg_' + name);
            return getAttribute("value");
        }
    }
}
/**
 * 根据QueryString参数名称获取值
 */
function getQueryStringByName(key) {
    return (document.location.search.match(new RegExp("(?:^\\?|&)" + key + "=(.*?)(?=&|$)")) || ['', null])[1];
}
/**
 * 地理定位
 */
function getLocation() {
    var options = {
        enableHighAccuracy: true,
        maximumAge: 1000
    };
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError, options);
    } else {
        debug("浏览器不支持地理定位.");
    }
}
function showPosition(position) {
    var lat = position.coords.latitude; //纬度
    var lag = position.coords.longitude; //经度
    var latlon = lat + ',' + lag;
    //baidu
    var url = "http://api.map.baidu.com/geocoder/v2/?ak=C93b5178d7a8ebdb830b9b557abce78b&callback=renderReverse&location=" + latlon + "&output=json&pois=0";
    $.ajax({
        type: "GET",
        dataType: "jsonp",
        url: url,
        beforeSend: function () {
            debug("正在定位...");
        },
        success: function (json) {
            if (json.status === 0) {
                HTMLNODE.latlon = json.result.formatted_address;
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            debug("定位失败," + latlon + "地址位置获取失败");
        }
    });
}
function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            debug("定位失败,用户拒绝请求地理定位", 'warn');
            break;
        case error.POSITION_UNAVAILABLE:
            debug("定位失败,位置信息是不可用", 'warn');
            break;
        case error.TIMEOUT:
            debug("定位失败,请求获取用户位置超时", 'warn');
            break;
        case error.UNKNOWN_ERROR:
            debug("定位失败,定位系统失效", 'warn');
            break;
    }
}
function debug(msg, type) {
    if (is_debug) {
        if (console) {
            if (typeof (type) == "undefined") {
                console.log(msg);
            } else {
                switch (type) {
                    case 'info':
                        console.info(msg);
                        break;
                    case 'error':
                        console.error(msg);
                        break;
                    case 'warn':
                        console.warn(msg);
                        break;
                    case 'dir':
                        console.warn(msg);
                        break;
                    case 'dirxml':
                        console.dirxml(msg);
                        break;
                    case 'table':
                        console.table(msg);
                        break;
                    default:
                        console.log(msg);
                }
            }
        } else {
            var div = document.createElement("div");
            var divattr = document.createAttribute("class");
            divattr.value = "debuginfo";
            div.setAttributeNode(divattr);
            div.appendChild(msg);
            document.getElementsByTagName("body").item(0).appendChild(div);
        }
    }
}
/**
 * 判断是否移动设备
 */
function mobileplayer() {
    var platform = navigator.platform;
    var ua = navigator.userAgent;
    var ios = /iPhone|iPad|iPod/.test(platform) && ua.indexOf("AppleWebKit") > -1;
    var andriod = ua.indexOf("Android") > -1;
    if (ios || andriod) {
        return true;
    } else {
        return false;
    }
}
function tip(title, message) {
    if (window.Notification && Notification.permission !== "denied") {
        Notification.requestPermission(function (status) {
            var n;
            if (status === "granted") {
                var n = new Notification(title, {
                    body: message,
                    dir: "auto", //文字方向，可能的值为auto、ltr（从左到右）和rtl（从右到左），一般是继承浏览器的设置。
                    lang: "zh-CN",
                    tag: "a1" //icon: ""
                });
            } else {
                n = new Notification(title, {body: message});
            }
            n.onerror = function () {
                debug('Notification have be click!');
                n.close(); // 手动关闭
            };
        });
    } else {
        alert(title + "\n\t" + message);
    }
}
function getHost(url) {
    var host = "null";
    if (typeof url == "undefined" || null == url) {
        url = window.location.href;
    }
    var regex = /^\w+\:\/\/([^\/]*).*/;
    var match = url.match(regex);
    if (typeof match != "undefined" && null != match) {
        host = match[1];
    }
    return host;
}
function display(id) {
    var obj = document.getElementById(id);
    if (obj.style.visibility) {
        obj.style.visibility = obj.style.visibility == 'visible' ? 'hidden' : 'visible';
    } else {
        obj.style.display = obj.style.display == '' ? 'none' : '';
    }
}
/**
 * 实现checkbox全选与全不选
 */
function checkAll(type, form, value, checkall, changestyle) {
    var checkall = checkall ? checkall : 'chkall';
    for (var i = 0; i < form.elements.length; i++) {
        var e = form.elements[i];
        if (type == 'option' && e.type == 'radio' && e.value == value && e.disabled != true) {
            e.checked = true;
        } else if (type == 'value' && e.type == 'checkbox' && e.getAttribute('chkvalue') == value) {
            e.checked = form.elements[checkall].checked;
            if (changestyle) {
                multiupdate(e);
            }
        } else if (type == 'prefix' && e.name && e.name != checkall && (!value || (value && e.name.match(value)))) {
            e.checked = form.elements[checkall].checked;
            if (changestyle) {
                if (e.parentNode && e.parentNode.tagName.toLowerCase() == 'li') {
                    e.parentNode.className = e.checked ? 'checked' : '';
                }
                if (e.parentNode.parentNode && e.parentNode.parentNode.tagName.toLowerCase() == 'div') {
                    e.parentNode.parentNode.className = e.checked ? 'item checked' : 'item';
                }
            }
        }
    }
}
var multiids = new Array();
function multiupdate(obj) {
    v = obj.value;
    if (obj.checked) {
        multiids[v] = v;
    } else {
        multiids[v] = null;
    }
}
/**
 * 加入收藏夹
 */
function addFavorite(url, title) {
    try {
        window.external.addFavorite(url, title);
    } catch (e) {
        try {
            window.sidebar.addPanel(title, url, '');
        } catch (e) {
            tip('notice', "请按 Ctrl+D 键添加到收藏夹");
        }
    }
}
/**
 * 设为首页
 */
function setHomePage(url) {
    if (document.all) {
        document.body.style.behavior = 'url(#default#homepage)';
        document.body.setHomePage(url);
    } else if (window.sidebar) {
        if (window.netscape) {
            try {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            } catch (e) {
                tip('提示', '该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入 about:config,然后将项 signed.applets.codebase_principal_support 值该为true');
            }
        }
        var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
        prefs.setCharPref('browser.startup.homepage', url);
    }
}
/**
 * 动态加载 CSS 样式文件
 */
function loadcss(url) {
    try {
        document.createStyleSheet(url);
    } catch (e) {
        var cssLink = document.createElement('link');
        cssLink.rel = 'stylesheet';
        cssLink.type = 'text/css';
        cssLink.href = url;
        var head = document.getElementsByTagName('head')[0];
        head.appendChild(cssLink);
    }
}
/**
 * @desc   为元素添加class
 * @param  {HTMLElement} ele
 * @param  {String} cls
 * var hasClass = require('./hasClass');
 */
function addClass(ele, cls) {
    if (!hasClass(ele, cls)) {
        ele.className += ' ' + cls;
    }
}
/**
 *
 * @desc 判断元素是否有某个class
 * @param {HTMLElement} ele
 * @param {String} cls
 * @return {Boolean}
 */
function hasClass(ele, cls) {
    return (new RegExp('(\\s|^)' + cls + '(\\s|$)')).test(ele.className);
}
/**
 *
 * @desc 为元素移除class
 * @param {HTMLElement} ele
 * @param {String} cls
 */
function removeClass(ele, cls) {
    if (hasClass(ele, cls)) {
        var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
        ele.className = ele.className.replace(reg, ' ');
    }
}
function openWindow(url, windowName, width, height) {//打开一个窗体通用方法
    var x = parseInt(screen.width / 2.0) - (width / 2.0);
    var y = parseInt(screen.height / 2.0) - (height / 2.0);
    var isMSIE = (navigator.appName == "Microsoft Internet Explorer");
    if (isMSIE) {
        var p = "resizable=1,location=no,scrollbars=no,width=";
        p = p + width;
        p = p + ",height=";
        p = p + height;
        p = p + ",left=";
        p = p + x;
        p = p + ",top=";
        p = p + y;
        retval = window.open(url, windowName, p);
    } else {
        var win = window.open(url, "ZyiisPopup", "top=" + y + ",left=" + x + ",scrollbars=" + scrollbars + ",dialog=yes,modal=yes,width=" + width + ",height=" + height + ",resizable=no");
        eval("try { win.resizeTo(width, height); } catch(e) { }");
        win.focus();
    }
}
function insertBefore(newNode, targetNode) {
    var parentNode = targetNode.parentNode;
    var next = targetNode.nextSibling;
    if (targetNode.id && targetNode.id.indexOf('temp') > -1) {
        parentNode.insertBefore(newNode, targetNode);
    } else if (!next) {
        parentNode.appendChild(newNode);
    } else {
        parentNode.insertBefore(newNode, targetNode);
    }
}
function insertAfter(newNode, targetNode) {
    var parentNode = targetNode.parentNode;
    var next = targetNode.nextSibling;
    if (next) {
        parentNode.insertBefore(newNode, next);
    } else {
        parentNode.appendChild(newNode);
    }
}
function getEvent() {
    if (document.all)
        return window.event;
    func = getEvent.caller;
    while (func != null) {
        var arg0 = func.arguments[0];
        if (arg0) {
            if ((arg0.constructor == Event || arg0.constructor == MouseEvent) || (typeof (arg0) == "object" && arg0.preventDefault && arg0.stopPropagation)) {
                return arg0;
            }
        }
        func = func.caller;
    }
    return null;
}
/**
 * 兼容浏览器绑定元素事件
 *
 * obj：元素
 *
 * evt:时间名称
 *
 * fn:触发函数
 *
 */
function _attachEvent(obj, evt, func, eventobj) {
    eventobj = !eventobj ? obj : eventobj;
    if (obj.addEventListener) {
        obj.addEventListener(evt, func, false);
    } else if (eventobj.attachEvent) {
        obj.attachEvent('on' + evt, func);
    }
}
function _detachEvent(obj, evt, func, eventobj) {
    eventobj = !eventobj ? obj : eventobj;
    if (obj.removeEventListener) {
        obj.removeEventListener(evt, func, false);
    } else if (eventobj.detachEvent) {
        obj.detachEvent('on' + evt, func);
    }
}
function isUndefined(variable) {
    return typeof variable == 'undefined' ? true : false;
}
function in_array(needle, haystack) {
    if (typeof needle == 'string' || typeof needle == 'number') {
        for (var i in haystack) {
            if (haystack[i] == needle) {
                return true;
            }
        }
    }
    return false;
}
function trim(str) {
    return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}
function strlen(str) {
    return (BROWSER.ie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}
function mb_strlen(str) {
    var len = 0;
    for (var i = 0; i < str.length; i++) {
        len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
    }
    return len;
}
function mb_cutstr(str, maxlen, dot) {
    var len = 0;
    var ret = '';
    var dot = !dot ? '...' : dot;
    maxlen = maxlen - dot.length;
    for (var i = 0; i < str.length; i++) {
        len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
        if (len > maxlen) {
            ret += dot;
            break;
        }
        ret += str.substr(i, 1);
    }
    return ret;
}
function preg_replace(search, replace, str, regswitch) {
    var regswitch = !regswitch ? 'ig' : regswitch;
    var len = search.length;
    for (var i = 0; i < len; i++) {
        re = new RegExp(search[i], regswitch);
        str = str.replace(re, typeof replace == 'string' ? replace : (replace[i] ? replace[i] : replace[0]));
    }
    return str;
}
function htmlspecialchars(str) {
    return preg_replace(['&', '<', '>', '"'], ['&amp;', '&lt;', '&gt;', '&quot;'], str);
}
/**
 * 清除脚本内容
 */
function stripscript(s) {
    return s.replace(/<script.*?>.*?<\/script>/ig, '');
}
/**
 * 返回脚本内容
 */
function evalscript(s) {
    if (s.indexOf('<script') == -1)
        return s;
    var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
    var arr = [];
    while (arr = p.exec(s)) {
        var p1 = /<script[^\>]*?src=\"([^\>]*?)\"[^\>]*?(reload=\"1\")?(?:charset=\"([\w\-]+?)\")?><\/script>/i;
        var arr1 = [];
        arr1 = p1.exec(arr[0]);
        if (arr1) {
            appendscript(arr1[1], '', arr1[2], arr1[3]);
        } else {
            p1 = /<script(.*?)>([^\x00]+?)<\/script>/i;
            arr1 = p1.exec(arr[0]);
            appendscript('', arr1[2], arr1[1].indexOf('reload=') != -1);
        }
    }
    return s;
}
/**
 * 动态加载脚本文件
 */
function appendscript(src, text, reload, charset) {
    var id = hash(src + text);
    if (!reload && in_array(id, evalscripts))
        return;
    if (reload && document.getElementById(id)) {
        document.getElementById(id).parentNode.removeChild(document.getElementById(id));
    }
    evalscripts.push(id);
    var scriptNode = document.createElement("script");
    scriptNode.type = "text/javascript";
    scriptNode.id = id;
    scriptNode.charset = charset ? charset : (BROWSER.firefox ? document.characterSet : document.charset);
    try {
        if (src) {
            scriptNode.src = src;
            scriptNode.onloadDone = false;
            scriptNode.onload = function () {
                scriptNode.onloadDone = true;
                JSLOADED[src] = 1;
            };
            scriptNode.onreadystatechange = function () {
                if ((scriptNode.readyState == 'loaded' || scriptNode.readyState == 'complete') && !scriptNode.onloadDone) {
                    scriptNode.onloadDone = true;
                    JSLOADED[src] = 1;
                }
            };
        } else if (text) {
            scriptNode.text = text;
        }
        document.getElementsByTagName('head')[0].appendChild(scriptNode);
    } catch (e) {
    }
}

function $F(func, args, script) {
    var run = function () {
        var argc = args.length, s = '';
        for (i = 0; i < argc; i++) {
            s += ',args[' + i + ']';
        }
        eval('var check = typeof ' + func + ' == \'function\'');
        if (check) {
            eval(func + '(' + s.substr(1) + ')');
        } else {
            setTimeout(function () {
                checkrun();
            }, 50);
        }
    };
    var checkrun = function () {
        if (JSLOADED[src]) {
            run();
        } else {
            setTimeout(function () {
                checkrun();
            }, 50);
        }
    };
    script = script || 'common_extra';
    src = JSPATH + script + '.js?' + VERHASH;
    if (!JSLOADED[src]) {
        appendscript(src);
    }
    return checkrun();
}
function ajaxget(url, showid, waitid, loading, display, recall) {
    $F('_ajaxget', arguments, 'ajax');
}
function ajaxpost(formid, showid, waitid, showidclass, submitbtn, recall) {
    $F('_ajaxpost', arguments, 'ajax');
}
function hash(string, length) {
    var length = length ? length : 32;
    var start = 0;
    var i = 0;
    var result = '';
    filllen = length - string.length % length;
    for (i = 0; i < filllen; i++) {
        string += "0";
    }
    while (start < string.length) {
        result = stringxor(result, string.substr(start, length));
        start += length;
    }
    return result;
}
function stringxor(s1, s2) {
    var s = '';
    var hash = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var max = Math.max(s1.length, s2.length);
    for (var i = 0; i < max; i++) {
        var k = s1.charCodeAt(i) ^ s2.charCodeAt(i);
        s += hash.charAt(k % 52);
    }
    return s;
}
/**
 * 对字符串进行加密
 */
function compileStr(code) {
    var c = String.fromCharCode(code.charCodeAt(0) + code.length);
    for (var i = 1; i < code.length; i++) {
        c += String.fromCharCode(code.charCodeAt(i) + code.charCodeAt(i - 1));
    }
    return escape(c);
}
/**
 * 字符串进行解密
 */
function uncompileStr(code) {
    code = unescape(code);
    var c = String.fromCharCode(code.charCodeAt(0) - code.length);
    for (var i = 1; i < code.length; i++) {
        c += String.fromCharCode(code.charCodeAt(i) - c.charCodeAt(i - 1));
    }
    return c;
}
/**
 * 获取域名主机 params: url:域名
 */
function getHost(url) {
    var host = "null";
    if (typeof url == "undefined" || null == url) {
        url = window.location.href;
    }
    var regex = /^\w+\:\/\/([^\/]*).*/;
    var match = url.match(regex);
    if (typeof match != "undefined" && null != match) {
        host = match[1];
    }
    return host;
}
/**
 * 转义html标签
 */
function htmlEncode(text) {
    return text.replace(/&/g, '&amp').replace(/\"/g, '&quot;').replace(/</g,
            '&lt;').replace(/>/g, '&gt;');
}
/**
 * 还原html标签
 */
function htmlDecode(text) {
    return text.replace(/&amp;/g, '&').replace(/&quot;/g, '\"').replace(
            /&lt;/g, '<').replace(/&gt;/g, '>');
}
/**
 * 与insertBefore方法（已存在）对应的insertAfter方法
 *
 *
 */
function insertAfter(newChild, refChild) {
    var parElem = refChild.parentNode;
    if (parElem.lastChild == refChild) {
        refChild.appendChild(newChild);
    } else {
        parElem.insertBefore(newChild, refChild.nextSibling);
    }
}
/**
 * 光标停在文字的后面，文本框获得焦点时调用
 */
function focusLast() {
    var e = event.srcElement;
    var r = e.createTextRange();
    r.moveStart('character', e.value.length);
    r.collapse(true);
    r.select();
}
/**
 * 检验URL链接是否有效
 *
 * .Open("GET",URL, false) true:异步；false:同步
 */
function getUrlState(URL) {
    var suc = false;
    var xmlhttp = new ActiveXObject("microsoft.xmlhttp");
    xmlhttp.Open("GET", URL, false);
    try {
        xmlhttp.Send();
    } catch (e) {
    } finally {
        var result = xmlhttp.responseText;
        if (result) {
            if (xmlhttp.Status == 200) {
                suc = true;
            } else {
                suc = false;
            }
        } else {
            suc = false;
        }
    }
    return suc;
}
/**
 * 格式化CSS样式代码
 */
function formatCss(s) {// 格式化代码
    s = s.replace(/\s*([\{\}\:\;\,])\s*/g, "$1");
    s = s.replace(/;\s*;/g, ";"); // 清除连续分号
    s = s.replace(/\,[\s\.\#\d]*{/g, "{");
    s = s.replace(/([^\s])\{([^\s])/g, "$1 {\n\t$2");
    s = s.replace(/([^\s])\}([^\n]*)/g, "$1\n}\n$2");
    s = s.replace(/([^\s]);([^\s\}])/g, "$1;\n\t$2");
    return s;
}
/**
 * 压缩CSS样式代码
 */
function yasuoCss(s) {// 压缩代码
    s = s.replace(/\/\*(.|\n)*?\*\//g, ""); // 删除注释
    s = s.replace(/\s*([\{\}\:\;\,])\s*/g, "$1");
    s = s.replace(/\,[\s\.\#\d]*\{/g, "{"); // 容错处理
    s = s.replace(/;\s*;/g, ";"); // 清除连续分号
    s = s.match(/^\s*(\S+(\s+\S+)*)\s*$/); // 去掉首尾空白
    return (s == null) ? "" : s[1];
}
/**
 * 获取当前路径
 */
function getCurrentPageUrl() {
    var currentPageUrl = "";
    if (typeof this.href === "undefined") {
        currentPageUrl = document.location.toString().toLowerCase();
    } else {
        currentPageUrl = this.href.toString().toLowerCase();
    }
    return currentPageUrl;
}
/**
 * 完美判断是否为网址
 */
function IsURL(strUrl) {
    var regular = /^\b(((https?|ftp):\/\/)?[-a-z0-9]+(\.[-a-z0-9]+)*\.(?:com|edu|gov|int|mil|net|org|biz|info|name|museum|asia|coop|aero|[a-z][a-z]|((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]\d)|\d))\b(\/[-a-z0-9_:\@&?=+,.!\/~%\$]*)?)$/i;
    if (regular.test(strUrl)) {
        return true;
    } else {
        return false;
    }
}
var keyCodeMap = {
    8: 'Backspace',
    9: 'Tab',
    13: 'Enter',
    16: 'Shift',
    17: 'Ctrl',
    18: 'Alt',
    19: 'Pause',
    20: 'Caps Lock',
    27: 'Escape',
    32: 'Space',
    33: 'Page Up',
    34: 'Page Down',
    35: 'End',
    36: 'Home',
    37: 'Left',
    38: 'Up',
    39: 'Right',
    40: 'Down',
    42: 'Print Screen',
    45: 'Insert',
    46: 'Delete',
    48: '0',
    49: '1',
    50: '2',
    51: '3',
    52: '4',
    53: '5',
    54: '6',
    55: '7',
    56: '8',
    57: '9',
    65: 'A',
    66: 'B',
    67: 'C',
    68: 'D',
    69: 'E',
    70: 'F',
    71: 'G',
    72: 'H',
    73: 'I',
    74: 'J',
    75: 'K',
    76: 'L',
    77: 'M',
    78: 'N',
    79: 'O',
    80: 'P',
    81: 'Q',
    82: 'R',
    83: 'S',
    84: 'T',
    85: 'U',
    86: 'V',
    87: 'W',
    88: 'X',
    89: 'Y',
    90: 'Z',
    91: 'Windows',
    93: 'Right Click',
    96: 'Numpad 0',
    97: 'Numpad 1',
    98: 'Numpad 2',
    99: 'Numpad 3',
    100: 'Numpad 4',
    101: 'Numpad 5',
    102: 'Numpad 6',
    103: 'Numpad 7',
    104: 'Numpad 8',
    105: 'Numpad 9',
    106: 'Numpad *',
    107: 'Numpad +',
    109: 'Numpad -',
    110: 'Numpad .',
    111: 'Numpad /',
    112: 'F1',
    113: 'F2',
    114: 'F3',
    115: 'F4',
    116: 'F5',
    117: 'F6',
    118: 'F7',
    119: 'F8',
    120: 'F9',
    121: 'F10',
    122: 'F11',
    123: 'F12',
    144: 'Num Lock',
    145: 'Scroll Lock',
    182: 'My Computer',
    183: 'My Calculator',
    186: ';',
    187: '=',
    188: ',',
    189: '-',
    190: '.',
    191: '/',
    192: '`',
    219: '[',
    220: '\\',
    221: ']',
    222: '\''
};
/**
 * @desc 根据keycode获得键名
 * @param  {Number} keycode
 * @return {String}
 */
function getKeyName(keycode) {
    if (keyCodeMap[keycode]) {
        return keyCodeMap[keycode];
    } else {
        debug('Unknow Key(Key Code:' + keycode + ')');
        return '';
    }
}
/**视口的大小，部分移动设备浏览器对innerWidth的兼容性不好，需要
 *document.documentElement.clientWidth或者document.body.clientWidth
 *来兼容（混杂模式下对document.documentElement.clientWidth不支持）。
 *使用方法 ： getViewPort().width;
 */
function getViewPort() {
    if (document.compatMode == "BackCompat") {   //浏览器嗅探，混杂模式
        return {
            width: document.body.clientWidth,
            height: document.body.clientHeight
        };
    } else {
        return {
            width: document.documentElement.clientWidth,
            height: document.documentElement.clientHeight
        };
    }
}
/**
 * 银行卡号按4位一空格显示（     使用 onkeyup(setBankNoStyle(this.value))   ）
 * */
function setBankNoStyle(BankNo) {
    var lKeyCode = (navigator.appname == "Netscape") ? event.which : event.keyCode;
    if (lKeyCode != 8) {
        if (BankNo.value == "")
            return;
        var account = new String(BankNo.value).replace(/\s/g, '');
        var strTemp = "";
        for (var i = 0; i < account.length; i++) {
            if (!isNaN(account[i])) {
                strTemp = strTemp + account[i];
            }
        }
        var strValue = strTemp.substr(0, 19);
        strTemp = "";
        for (var j = 0; j < strValue.length; j++) {
            if ((j + 1) % 4 == 0) {
                strTemp = strTemp + strValue[j] + " ";
            } else {
                strTemp = strTemp + strValue[j];
            }
        }
        $(BankNo).val(strTemp);
    }

}
/**
 * 正则验证
 * @param s 验证字符串
 * @param type 验证类型 money,china,mobile等
 * @return
 */
function mCheck(s, type) {
    var objbool = false;
    var objexp = "";
    switch (type) {
        case 'money': //金额格式,格式定义为带小数的正数，小数点后最多三位
            objexp = "^[0-9]+[\.][0-9]{0,3}$";
            break;
        case 'numletter_': //英文字母和数字和下划线组成
            objexp = "^[0-9a-zA-Z\_]+$";
            break;
        case 'numletter': //英文字母和数字组成
            objexp = "^[0-9a-zA-Z]+$";
            break;
        case 'numletterchina': //汉字、字母、数字组成
            objexp = "^[0-9a-zA-Z\u4e00-\u9fa5]+$";
            break;
        case 'email': //邮件地址格式
            objexp = "^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$";
            break;
        case 'tel': //固话格式
            objexp = /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/;
            break;
        case 'mobile': //手机号码
            objexp = "^(13[0-9]|15[0-9]|18[0-9])([0-9]{8})$";
            break;
        case 'decimal': //浮点数
            objexp = "^[0-9]+([.][0-9]+)?$";
            break;
        case 'url': //网址
            objexp = "(https://|https://){0,1}[\w\/\.\?\&\=]+";
            break;
        case 'date': //日期 YYYY-MM-DD格式
            objexp = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/;
            break;
        case 'int': //整数
            objexp = "^[0-9]*[1-9][0-9]*$";
            break;
        case 'int+': //正整数包含0
            objexp = "^\\d+$";
            break;
        case 'int-': //负整数包含0
            objexp = "^((-\\d+)|(0+))$";
            break;
        case 'china': //中文
            objexp = /^[\u0391-\uFFE5]+$/;
            break;
    }
    var re = new RegExp(objexp);
    if (re.test(s)) {
        return true;
    } else {
        return false;
    }
}
/**
 * 弹出窗口居中方法
 */
function openWin(url, name, iWidth, iHeight) {
    //获得窗口的垂直位置
    var iTop = (window.screen.availHeight - 30 - iHeight) / 2;
    //获得窗口的水平位置
    var iLeft = (window.screen.availWidth - 10 - iWidth) / 2;
    window.open(url, name, 'height=' + iHeight + ',innerHeight=' + iHeight + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft + ',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=0,titlebar=no');
}

/**
 * 清除空格 为String 对象添加方法 trim（） 以此兼容不支持此方法的浏览器
 */
if (!String.prototype.trim) {
    String.prototype.trim = function () {
        var reExtraSpace = /^\s*(.*?)\s+$/;
        return this.replace(reExtraSpace, "$1");
    };
}
/**
 * 替换全部,多种方式的替换规则 为String 对象添加方法 replaceAll 兼容浏览器
 *
 * 第三参数 修饰符 描述 i 执行对大小写不敏感的匹配。 g 执行全局匹配（查找所有匹配而非在找到第一个匹配后停止）。 m 执行多行匹配。
 */
if (!String.prototype.replaceAll) {
    String.prototype.replaceAll = function (s1, s2, type) {
        return this.replace(new RegExp(s1, type), s2);
    };
}
/**
 * 清除左空格/右空格：
 * */
String.prototype.ltrim = function () {
    return this.replace(/^(\s*| *)/g, '');
}
String.prototype.rtrim = function () {
    return this.replace(/(\s*| *)$/g, '');
}
/**
 * 判断是否以某个字符串开头
 * */
String.prototype.startWith = function (s) {
    return this.indexOf(s) == 0;
}
/**
 * 判断是否以某个字符串结束
 * */
String.prototype.endWith = function (s) {
    var d = this.length - s.length;
    return (d >= 0 && this.lastIndexOf(s) == d);
}
/**
 * 清除相同的数组
 * */
String.prototype.unique = function () {
    var x = this.split(/[\r\n]+/);
    var y = '';
    for (var i = 0; i < x.length; i++) {
        if (!new RegExp("^" + x.replace(/([^\w])/ig, "\\$1") + "$", "igm").test(y)) {
            y += x + "\r\n"
        }
    }
    return y
}
/**
 * 时间日期格式转换
 * */
Date.prototype.Format = function (formatStr) {
    var str = formatStr;
    var Week = ['日', '一', '二', '三', '四', '五', '六'];
    str = str.replace(/yyyy|YYYY/, this.getFullYear());
    str = str.replace(/yy|YY/, (this.getYear() % 100) > 9 ? (this.getYear() % 100).toString() : '0' + (this.getYear() % 100));
    str = str.replace(/MM/, (this.getMonth() + 1) > 9 ? (this.getMonth() + 1).toString() : '0' + (this.getMonth() + 1));
    str = str.replace(/M/g, (this.getMonth() + 1));
    str = str.replace(/w|W/g, Week[this.getDay()]);
    str = str.replace(/dd|DD/, this.getDate() > 9 ? this.getDate().toString() : '0' + this.getDate());
    str = str.replace(/d|D/g, this.getDate());
    str = str.replace(/hh|HH/, this.getHours() > 9 ? this.getHours().toString() : '0' + this.getHours());
    str = str.replace(/h|H/g, this.getHours());
    str = str.replace(/mm/, this.getMinutes() > 9 ? this.getMinutes().toString() : '0' + this.getMinutes());
    str = str.replace(/m/g, this.getMinutes());
    str = str.replace(/ss|SS/, this.getSeconds() > 9 ? this.getSeconds().toString() : '0' + this.getSeconds());
    str = str.replace(/s|S/g, this.getSeconds());
    return str
}
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (element, index) {
        var length = this.length;
        if (index == null) {
            index = 0;
        } else {
            index = (!isNaN(index) ? index : parseInt(index));
            if (index < 0)
                index = length + index;
            if (index < 0)
                index = 0;
        }
        for (var i = index; i < length; i++) {
            var current = this[i];
            if (!(typeof (current) === 'undefined') || i in this) {
                if (current === element)
                    return i;
            }
        }
        return -1;
    };
}
if (!Array.prototype.filter) {
    Array.prototype.filter = function (fun, thisp) {
        var len = this.length;
        if (typeof fun != "function")
            throw new TypeError();
        var res = new Array();
        var thisp = arguments[1];
        for (var i = 0; i < len; i++) {
            if (i in this) {
                var val = this[i];
                if (fun.call(thisp, val, i, this))
                    res.push(val);
            }
        }
        return res;
    };
}

function browserVersion(types) {
    var other = 1;
    for (i in types) {
        var v = types[i] ? types[i] : i;
        if (USERAGENT.indexOf(v) != -1) {
            var re = new RegExp(v + '(\\/|\\s|:)([\\d\\.]+)', 'ig');
            var matches = re.exec(USERAGENT);
            var ver = matches != null ? matches[2] : 0;
            other = ver !== 0 && v != 'mozilla' ? 0 : other;
        } else {
            var ver = 0;
        }
        eval('BROWSER.' + i + '= ver');
    }
    BROWSER.other = other;
}
var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
browserVersion({
    'ie': 'msie',
    'firefox': '',
    'chrome': '',
    'opera': '',
    'safari': '',
    'mozilla': '',
    'webkit': '',
    'maxthon': '',
    'qq': 'qqbrowser',
    'rv': 'rv'
});
if (BROWSER.safari || BROWSER.rv) {
    BROWSER.firefox = true;
}
BROWSER.opera = BROWSER.opera ? opera.version() : 0;
HTMLNODE = document.getElementsByTagName('head')[0].parentNode;
if (BROWSER.ie) {
    BROWSER.iemode = parseInt(typeof document.documentMode !== 'undefined' ? document.documentMode : BROWSER.ie);
    HTMLNODE.className = 'ie_all ie' + BROWSER.iemode;
    document.documentElement.addBehavior("#default#userdata");
}
if (BROWSER.firefox && window.HTMLElement) {
    HTMLElement.prototype.__defineGetter__("innerText", function () {
        var anyString = "";
        var childS = this.childNodes;
        for (var i = 0; i < childS.length; i++) {
            if (childS[i].nodeType === 1) {
                anyString += childS[i].tagName === "BR" ? '\n' : childS[i].innerText;
            } else if (childS[i].nodeType === 3) {
                anyString += childS[i].nodeValue;
            }
        }
        return anyString;
    });
    HTMLElement.prototype.__defineSetter__("innerText", function (sText) {
        this.textContent = sText;
    });
    HTMLElement.prototype.__defineSetter__('outerHTML', function (sHTML) {
        var r = this.ownerDocument.createRange();
        r.setStartBefore(this);
        var df = r.createContextualFragment(sHTML);
        this.parentNode.replaceChild(df, this);
        return sHTML;
    });
    HTMLElement.prototype.__defineGetter__('outerHTML', function () {
        var attr;
        var attrs = this.attributes;
        var str = '<' + this.tagName.toLowerCase();
        for (var i = 0; i < attrs.length; i++) {
            attr = attrs[i];
            if (attr.specified)
                str += ' ' + attr.name + '="' + attr.value + '"';
        }
        if (!this.canHaveChildren) {
            return str + '>';
        }
        return str + '>' + this.innerHTML + '</' + this.tagName.toLowerCase() + '>';
    });
    HTMLElement.prototype.__defineGetter__('canHaveChildren', function () {
        switch (this.tagName.toLowerCase()) {
            case 'area':
            case 'base':
            case 'basefont':
            case 'col':
            case 'frame':
            case 'hr':
            case 'img':
            case 'br':
            case 'input':
            case 'isindex':
            case 'link':
            case 'meta':
            case 'param':
                return false;
        }
        return true;
    });
}
var JSLOADED = [];
var safescripts = {}, evalscripts = [];
var cookiedomain = "", cookiepath = '/', cookiepre = "ticky_";