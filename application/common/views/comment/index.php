<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title ?> - TickyPHP</title>
        <!-- Favicons -->
        <link rel="icon" href="/static/images/favicon.ico"/>
        <link rel="stylesheet" href="/static/lib/bootstrap/css/bootstrap.min.css" type="text/css"/>
        <link rel="stylesheet" href="/static/lib/bootstrapvalidator/css/bootstrapValidator.css" type="text/css"/>
        <link rel="stylesheet" href="/static/images/home/home.css" type="text/css" />

        <script type="text/javascript" src="/static/lib/jquery/jquery.js"></script>
        <script type="text/javascript" src="/static/lib/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript"  src="/static/lib/bootstrapvalidator/js/bootstrapValidator.js"></script>
        <style type="text/css">
            .html-body-overflow
            {
                overflow-x:hidden;
                overflow-y:hidden;
            }
        </style>
    </head>
    <body >
        <div class="lb_wrap">
            <!--{if cookie('auth')}-->
            <div class="comment_form">
                <form action="/common/comment/" method="post" class="form-horizontal" id="cpform" name="cpform" role="form" autocomplete='off' >
                    <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>" />
                    <input type="hidden" id="idtype" name="idtype" value="<?php echo $_GET['idtype']; ?>" />
                    <input type="hidden" id="uid" name="uid" value="<?php echo $uid; ?>" />
                    <div class="form-group">
                        <label for="comment_box"><?php echo $comment_lable; ?></label>
                        <textarea placeholder="<?php echo $comment_box; ?>" id="comment_box" name="comment_box" class="form-control" rows="3"></textarea>
                    </div>
                    <div style="float: right;height: 30px;">
                        <input type='submit' id="dosubmit" name='dosubmit' class='btn  btn-default' value='<?php echo L('submit'); ?>' />
                    </div>
                </form>
            </div>
            <!--{/if}-->
            <script type="text/javascript">
                $(function () {
                    // valid form
                    $('#cpform').bootstrapValidator({
                        message: 'This value is not valid',
                        feedbackIcons: {
                            valid: 'glyphicon glyphicon-ok',
                            invalid: 'glyphicon glyphicon-remove',
                            validating: 'glyphicon glyphicon-refresh'
                        }, fields: {
                            comment_box: {
                                message: '评论无效',
                                validators: {
                                    notEmpty: {
                                        message: '评论不能为空'
                                    },
                                    stringLength: {
                                        min: 10,
                                        max: 530,
                                        message: '评论长度必须在10到530之间'
                                    },
                                }
                            }
                            //end fields
                        }
                    });
                });
            </script>
            <?php foreach ($items as $item): ?>
                <div class="comment_list">
                    <img class="comment_user_pic" src="/static/images/home/user2.png"/>
                    <div class="comment_info">
                        <span class="comment_user_name"><?php echo $item['username']; ?></span>
                        <span class="comment_time"><?php echo $item['dateline']; ?></span>
                    </div>
                    <p class="comment_content">
                        <?php echo $item['message']; ?>
                    </p>
                </div>
            <?php endforeach ?>
            <?php echo $multi; ?>
        </div>
    </body>
</html>
