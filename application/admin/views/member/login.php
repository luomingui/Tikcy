<!--{template header}-->
<style>
    #wrap {
        background: #fff;
    }
</style>
<div id="container">
    <div class="row">
        <div class="panel panel-default" style="width: 500px;margin-left: 30%; margin-top: 10%">
            <div class="panel-heading">
                <div class="hd">
                    <strong>{$title}</strong>
                </div>
            </div>
            <div class="panel-body"><br>
                <link rel="stylesheet" href="/static/lib/bootstrapvalidator/css/bootstrapValidator.css" type="text/css"/>
                <script type="application/javascript" src="/static/lib/bootstrapvalidator/js/bootstrapValidator.js"></script>
                <form action="/admin/member/login" method="post" class="form-horizontal" id="cpform" name="cpform" role="form" autocomplete='off'>
                    <div class="form-group">
                        <label for="admin_username" class="col-sm-2 control-label"><?php echo L('tky_member_username'); ?></label>
                        <div class="col-sm-10" style="width: 250px;">
                            <input type="text" id="admin_username" name='admin_username' value="" maxlength="30" tabindex="1" class='form-control' autocomplete='off' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin_password" class="col-sm-2 control-label"><?php echo L('tky_member_password'); ?></label>
                        <div class="col-sm-10" style="width: 250px;">
                            <input type="password" id="admin_password" name='admin_password' value="" maxlength="90" tabindex="2" class='form-control' autocomplete='off'/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-2 control-label">验证码</label>
                        <div class="col-sm-10 form-inline" style="width: 250px;">
                            <input type="text" name="code" class='form-control' style="width: 150px;"  tabindex="3"  maxlength="6" autocomplete='off' />
                            <a href="javascript:void(0)" class="reloadverify" title="换一张">换一张？</a><br>
                            <img class="verifyimg reloadverify" src="/admin/member/verify" style="margin-top: 9px;" alt="点击切换"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input name="loginsubmit" value="登录"  tabindex="5" type="submit" class="btn btn-primary" />
                            &nbsp;&nbsp; <a href="/admin/member/reset">忘记密码</a>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(function () {
                            $('.reloadverify').click(function () {
                                $('.verifyimg').attr('src', "/admin/member/verify?" + Math.random());
                            });
                            // valid form
                            $('#cpform').bootstrapValidator({
                                message: 'This value is not valid',
                                feedbackIcons: {
                                    valid: 'glyphicon glyphicon-ok',
                                    invalid: 'glyphicon glyphicon-remove',
                                    validating: 'glyphicon glyphicon-refresh'
                                }, fields: {
                                    admin_username: {
                                        message: '<?php echo L('tky_member_username'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_username'); ?>不能为空'
                                            }
                                        }
                                    },
                                    admin_password: {
                                        message: '<?php echo L('tky_member_password'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_password'); ?>不能为空'
                                            }
                                        }
                                    },
                                    code: {
                                        message: '验证码无效',
                                        validators: {
                                            notEmpty: {
                                                message: '验证码不能为空'
                                            }
                                        }
                                    }
                                    //end fields
                                }
                            });
                        });
                    </script>

                </form>
            </div>
        </div>
    </div>
</div>
<!--{template footer}-->