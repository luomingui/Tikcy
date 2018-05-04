<!--{template header}-->
<ol class="breadcrumb">
    <li><a href="/"><?php echo L('home'); ?></a></li>
    <li class="active"><a href="/admin/member"><?php echo L('tky_member'); ?></a></li>
    <li class="active"><?php echo $action ?></li>
</ol>
<div class='outer'>
    <div class="container" id="cpcontainer">
        <div id='titlebar'>
            <div class='heading'>
                <i class='icon-bug'></i><?php echo L('changepassword'); ?>
            </div>
            <div class='show'>
                <form action="<?php echo $postUrl; ?>" method="post" class="form-horizontal" id="cpform" name="cpform" role="form" autocomplete='off' >
                    <input type='hidden' name='uid' value="<?php echo cookie('uid') ?>" />
                    <div class="form-group">
                        <label for="oldpassword" class="col-sm-2 control-label">原密码</label>
                        <div class="col-sm-10">
                            <input type="text" id="oldpassword" name='oldpassword' value="" maxlength="30" tabindex="2" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newpassword" class="col-sm-2 control-label">新密码</label>
                        <div class="col-sm-10">
                            <input type="text" id="newpassword" name='newpassword' value="" maxlength="15" tabindex="3" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword" class="col-sm-2 control-label">确认密码</label>
                        <div class="col-sm-10">
                            <input type="text" id="confirmpassword" name='confirmpassword' value="" maxlength="15" tabindex="4" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type='submit' id="submit" name='submit' class='btn  btn-default' value='<?php echo L('submit'); ?>' />
                        </div>
                    </div>

                </form>
                <script type="text/javascript">
                    $(function() {
                        // valid form
                        $('#cpform').bootstrapValidator({
                            message: 'This value is not valid',
                            feedbackIcons: {
                                valid: 'glyphicon glyphicon-ok',
                                invalid: 'glyphicon glyphicon-remove',
                                validating: 'glyphicon glyphicon-refresh'
                            }, fields: {
                                oldpassword: {
                                    message: '用户旧密码无效',
                                    validators: {
                                        notEmpty: {
                                            message: '用户旧密码不能为空'
                                        },
                                        stringLength: {
                                            min: 6,
                                            max: 19,
                                            message: '用户旧密码长度大于5小于20'
                                        },
                                        regexp: {
                                            regexp: /^[^ ]+$/,
                                            message: '用户旧密码不能有空格'
                                        }
                                    }
                                },
                                newpassword: {
                                    message: '新密码无效',
                                    validators: {
                                        notEmpty: {
                                            message: '用户新密码不能为空'
                                        },
                                        identical: {
                                            field: 'confirmpassword',
                                            message: '用户新密码与确认密码不一致！'
                                        },
                                        stringLength: {
                                            min: 6,
                                            max: 19,
                                            message: '用户新密码长度大于5小于20'
                                        },
                                        regexp: {
                                            regexp: /^[^ ]+$/,
                                            message: '用户新密码不能有空格'
                                        }
                                    }
                                },
                                confirmpassword: {
                                    message: '确认密码无效',
                                    validators: {
                                        identical: {
                                            field: 'newpassword',
                                            message: '用户新密码与确认密码不一致！'
                                        },
                                        notEmpty: {
                                            message: '确认密码不能为空'
                                        },
                                        stringLength: {
                                            min: 6,
                                            max: 19,
                                            message: '用户确认密码长度大于5小于20'
                                        },
                                        regexp: {
                                            regexp: /^[^ ]+$/,
                                            message: '用户确认密码不能有空格'
                                        }
                                    }
                                }
                                //end fields
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<!--{template footer}-->