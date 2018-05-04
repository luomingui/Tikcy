<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title></title>
        <!-- 移动适配JS脚本 -->
        <script type="text/javascript">
            if (/AppleWebKit.*Mobile/i.test(navigator.userAgent) || /\(Android.*Mobile.+\).+Gecko.+Firefox/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))) {
                if (window.location.href.indexOf("?mobile") < 0) {
                    try {
                        if (/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
                            window.location.href = "<?php echo config('app_host'); ?>app/hospital/";
                        } else if (/iPad/i.test(navigator.userAgent)) {
                            window.location.href = "<?php echo config('app_host'); ?>ipad/"
                        } else {
                            window.location.href = "<?php echo config('app_host'); ?>home/"
                        }
                    } catch (e) {
                    }
                }
            }
        </script>
    </head>
    <body>
        <h1>:(</h1>
    </body>
</html>