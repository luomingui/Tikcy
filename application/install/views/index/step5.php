<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title ?>   <?php echo config('title'); ?></title>
        <meta name="keywords" content="<?php echo $keywords ?>,<?php echo config('keywords'); ?>" />
        <meta name="description" content="<?php echo $description ?> <?php echo config('description'); ?>" />
        <link rel="apple-touch-icon" href="/static/images/apple-touch-icon.png"/>
        <link rel="icon" href="/static/images/favicon.ico"/>
        <link href="/static/images/install/install.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/static/lib/jquery/jquery.js"></script>
        <link href="/static/images/install/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/static/lib/jquery/perfect-scrollbar.min.js"></script>
        <script type="text/javascript" src="/static/lib/jquery/jquery.mousewheel.js"></script>
    </head>
    <body>
        <!--{template header}-->
        <div class="main">
            <div class="final-succeed"> <span class="ico"></span>
                <h2>程序已成功安装</h2>
                <h5>选择您要进入的页面</h5>
            </div>
            <div class="final-site-nav">
                <div class="arrow"></div>
                <ul>
                    <li class="shop">
                        <div class="ico"></div>
                        <h5><a href="<?php echo $auto_site_url; ?>" target="_blank">首页</a></h5>
                        <h6>系统首页</h6>
                    </li>

                    <li class="admin">
                        <div class="ico"></div>
                        <h5><a href="<?php echo $auto_site_url; ?>admin" target="_blank">系统管理</a></h5>
                        <h6>系统后台</h6>
                    </li>
                </ul>
            </div>
            <div class="final-intro">
                <p><strong>系统管理默认地址:&nbsp;</strong><a href="/admin" target="_blank"><?php echo $auto_site_url; ?>admin</a></p>
                <p><strong>网站首页默认地址:&nbsp;</strong><a href="/" target="_blank"><?php echo $auto_site_url; ?></a></p>
            </div>
        </div>
        <!--{template footer}-->
        <script type="text/javascript">
            $(document).ready(function () {
                //自定义滚定条
                $('#text-box').perfectScrollbar();
            });
        </script>
    </body>
</html>