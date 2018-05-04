<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title ?>  -<?php echo config('title'); ?></title>
        <meta name="keywords" content="<?php echo $keywords ?>,<?php echo config('keywords'); ?>" />
        <meta name="description" content="<?php echo $description ?> <?php echo config('description'); ?>" />
        <!-- 解决部分兼容性问题，如果安装了GCF，则使用GCF来渲染页面，如果未安装GCF，则使用最高版本的IE内核进行渲染。 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <!-- 页面按原比例显示 -->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- 用来防止别人在框架里调用你的页面 -->
        <meta http-equiv="Window-target" content="_top">
        <!-- Favicons -->
        <link rel="apple-touch-icon" href="/static/images/apple-touch-icon.png"/>
        <link rel="icon" href="/static/images/favicon.ico"/>

        <link rel="stylesheet" href="/static/lib/bootstrap/css/bootstrap.min.css" type="text/css"/>
        <link rel="stylesheet" href="/static/lib/bootstrapvalidator/css/bootstrapValidator.css" type="text/css"/>
        <link rel="stylesheet" href="/static/images/admin/admincp.css" type="text/css" media="all"/>

        <script type="application/javascript" src="/static/lib/jquery/jquery.min.js"></script>
        <script type="application/javascript" src="/static/lib/bootstrap/js/bootstrap.min.js"></script>
        <script type="application/javascript" src="/static/lib/bootstrapvalidator/js/bootstrapValidator.js"></script>
        <!--[if lt IE 9]><script src="/static/lib/bootstrap/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="application/javascript" src="/static/js/common.js"></script>
        <script>
            var is_debug = true;
        </script>
    </head>
    <body>
        <?php if (BIND_ACTION != "login") { ?>
            <header id='header'>
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                        </div>
                        <div>
                            <ul class="nav navbar-nav">
                                <li><a href="/"><span class="glyphicon glyphicon-home"></span><?php echo L('home'); ?></a></li>
                                <li <?php
                                if (BIND_CONTROLLER == 'hospital' || BIND_CONTROLLER == 'doctor' || BIND_CONTROLLER == 'order' || BIND_CONTROLLER == 'patient' || BIND_CONTROLLER == 'booking') {
                                    echo 'class="active"';
                                }
                                ?> >
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo L('oacsp_hospital'); ?></a>
                                    <ul class="dropdown-menu">
                                        <li <?php
                                        if (BIND_CONTROLLER == 'hospital') {
                                            echo 'class="active"';
                                        }
                                        ?> >
                                            <a href="/admin/hospital"><?php echo L('oacsp_hospital'); ?></a>
                                        </li>

                                        <li <?php
                                        if (BIND_CONTROLLER == 'doctor') {
                                            echo 'class="active"';
                                        }
                                        ?> >
                                            <a href="/admin/doctor"><?php echo L('oacsp_doctor'); ?></a>
                                        </li>
                                        <li <?php
                                        if (BIND_CONTROLLER == 'order') {
                                            echo 'class="active"';
                                        }
                                        ?> >
                                            <a href="/admin/order"><?php echo L('oacsp_order'); ?></a>
                                        </li>

                                        <li <?php
                                        if (BIND_CONTROLLER == 'patient') {
                                            echo 'class="active"';
                                        }
                                        ?> >
                                            <a href="/admin/patient"><?php echo L('oacsp_patient'); ?></a>
                                        </li>
                                        <li <?php
                                        if (BIND_CONTROLLER == 'booking') {
                                            echo 'class="active"';
                                        }
                                        ?> >
                                            <a href="/admin/booking"><?php echo L('oacsp_booking'); ?></a>
                                        </li>
                                    </ul>
                                </li>
                                <li <?php
                                if (BIND_CONTROLLER == 'dispatch') {
                                    echo 'class="active"';
                                }
                                ?>><a href="/admin/dispatch">调度</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user['username']; ?><b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/admin/member/changepassword"><?php echo L('changepassword'); ?></a></li>
                                    </ul>
                                </li>
                                <li <?php
                                if (BIND_CONTROLLER == 'member' || BIND_CONTROLLER == 'role') {
                                    echo 'class="active"';
                                }
                                ?> >
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="glyphicon glyphicon-cog"></span><?php echo L('org'); ?><b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/admin/member"><?php echo L('tky_member'); ?></a></li>
                                        <li><a href="/admin/role"><?php echo L('tky_authrole'); ?></a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="glyphicon glyphicon-th-large"></span><?php echo L('language'); ?><b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:changetoVersion('zh-cn','en-us')" class="xi2 xw1">中文版</a></li>
                                        <li><a href="javascript:changetoVersion('en-us','zh-cn')" class="xi2 xw1">English</a></li>
                                    </ul>
                                </li>
                                <li><a href="/admin/member/logout"><span class="glyphicon glyphicon-log-out"></span><?php echo L('logout'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
        <?php } ?>
        <div id='wrap'>