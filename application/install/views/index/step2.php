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
        <script type="text/javascript"  src="/static/lib/jquery/jquery.js"></script>
        <script type="text/javascript"  src="/static/lib/jquery/jquery.icheck.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('input[type="radio"]').on('ifChecked', function (event) {
                    if (this.id == 'radio-0') {
                        $('.select-module').show();
                    } else {
                        $('.select-module').hide();
                    }
                }).iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
                $('input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
                $('#next').click(function () {
                    if ($('#cms').attr('checked') && $('#shop').attr('checked')) {
                        $('#install_form').submit();
                    } else {
                        alert('商城与CMS必须安装');
                    }
                });
            });
        </script>
    </head>

    <body>
        <!--{template header}-->
        <div class="main">
            <div class="step-box" id="step2">
                <div class="text-nav">
                    <h1>Step.2</h1>
                    <h2>选择安装方式</h2>
                    <h5>根据需要选择系统模块完全或手动安装</h5>
                </div>
                <div class="procedure-nav">
                    <div class="schedule-ico"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
                    <div class="schedule-point-now"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
                    <div class="schedule-point-bg"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
                    <div class="schedule-line-now"><em></em></div>
                    <div class="schedule-line-bg"></div>
                    <div class="schedule-text">
                        <span class="a">检查安装环境</span>
                        <span class="b">选择安装方式</span>
                        <span class="c">创建数据库</span>
                        <span class="d">安装</span>
                    </div>
                </div>
            </div>
            <form method="get" id="install_form" action="/install/">
                <input type="hidden" value="3" name="step">
                <div class="select-install">
                    <label>
                        <input type="radio" name="iCheck" value="full" id="radio-1" class="green-radio" checked >
                        <h4>完全安装 <?php echo config('title'); ?></h4>
                        <h5>系统</h5>
                    </label>
                </div>
                <div class="select-module" id="result" style="display:none">
                    <div class="arrow"></div>
                    <ul>
                        <li class="cms">
                            <input type="checkbox" name="cms" id="cms" value="1" checked="checked"  disabled="">
                            <div class="ico"></div>
                            <h4>商城</h4>
                            <p>商城模块是一套功能完善的多用户商城系统，也是整套电商门户的核心程序...</p>
                        </li>
                        <li class="shop">
                            <input type="checkbox" name="shop" id="shop" value="1" checked="checked" disabled="">
                            <div class="ico"></div>
                            <h4>CMS</h4>
                            <p>CMS模块拥有文章、画报、专题发布等功能，自定义编辑模板,可在文章内容中关联商品...</p>
                        </li>
                        <li class="circle">
                            <input type="checkbox" name="circle" value="1" checked="checked" disabled="">
                            <div class="ico"></div>
                            <h4>圈子</h4>
                            <p>圈子模块是会员交流互动的理想环境，增强站点人气。主题帖中可与商品关联，特色鲜明...</p>
                        </li>
                        <li class="microshop">
                            <input type="checkbox" name="microshop" value="1" checked="checked" disabled="">
                            <div class="ico"></div>
                            <h4>微商城</h4>
                            <p>微商城模块以新颖的形式展示会员已购商品、实物秀图，提高商品浏览量，促进商城经营...</p>
                        </li>
                    </ul>
                </div>
                <div class="btn-box">
                    <a href="/install/?step=1" class="btn btn-primary">上一步</a>
                    <a id="next" href="javascript:void(0);" class="btn btn-primary">下一步</a></div>
            </form>
        </div>
        <!--{template footer}-->
    </body>
</html>
