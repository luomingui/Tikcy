<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="x5-page-mode" content="no-title" />
        <meta name="format-detection" content="telephone=no"/>
        <meta name="HandheldFriendly" content="True"/>
        <meta name="MobileOptimized" content="320"/>
        <meta http-equiv="cleartype" content="on"/>
        <title><?php echo $title ?><?php echo config('title'); ?></title>
        <link rel="apple-touch-icon-precomposed" href="/static/images/touch_logo.png"/>
        <link rel="shortcut icon" href="<?php echo config('app_host'); ?>static/images/favicon.ico"/>

        <!--<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=8qSBetGi06FbMEiAMAiT0qf4GOxaan6l"></script>-->
        <link  href="<?php echo config('app_host'); ?>static/lib/bootstrap/css/bootstrap.min.css" type="text/css" media="all" rel="stylesheet"/>
        <script src="<?php echo config('app_host'); ?>static/lib/jquery/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo config('app_host'); ?>static/lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="<?php echo config('app_host'); ?>static/app/css/app.css" type="text/css" media="all" rel="stylesheet"/>
        <script src="<?php echo config('app_host'); ?>static/app/js/app.js" type="text/javascript"></script>
    </head>
    <body id="<?php echo BIND_CONTROLLER; ?>" >
        <div>

