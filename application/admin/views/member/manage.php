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
                <i class='icon-bug'></i><?php echo L('add'); ?>
            </div>
            <div class='show'>
                <form action="<?php echo $postUrl; ?>" method="post" class="form-horizontal" id="cpform" name="cpform" role="form" autocomplete='off' >
                    <input type='hidden' name='uid' value="<?php echo $item['uid'] ?>" />

                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label"><?php echo L('tky_member_username'); ?></label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" id="username" name='username' value="<?php echo $item['username'] ?>" maxlength="15" tabindex="2" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="PASSWORD" class="col-sm-2 control-label"><?php echo L('tky_member_PASSWORD'); ?></label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" id="PASSWORD" name='PASSWORD' value="<?php echo $item['PASSWORD'] ?>" maxlength="15" tabindex="3" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label"><?php echo L('tky_member_email'); ?></label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" id="email" name='email' value="<?php echo $item['email'] ?>" maxlength="90" tabindex="4" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="avatarstatus" class="col-sm-2 control-label"><?php echo L('tky_member_avatarstatus'); ?></label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" id="avatarstatus" name='avatarstatus' value="<?php echo $item['avatarstatus'] ?>" maxlength="1" tabindex="5" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="score" class="col-sm-2 control-label"><?php echo L('tky_member_score'); ?></label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" id="score" name='score' value="<?php echo $item['score'] ?>" maxlength="8" tabindex="6" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="adminid" class="col-sm-2 control-label"><?php echo L('tky_member_adminid'); ?></label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" id="adminid" name='adminid' value="<?php echo $item['adminid'] ?>" maxlength="1" tabindex="11" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="timeoffset" class="col-sm-2 control-label"><?php echo L('tky_member_timeoffset'); ?></label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" id="timeoffset" name='timeoffset' value="<?php echo $item['timeoffset'] ?>" maxlength="4" tabindex="12" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="STATUS" class="col-sm-2 control-label"><?php echo L('tky_member_STATUS'); ?></label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" id="STATUS" name='STATUS' value="<?php echo $item['STATUS'] ?>" maxlength="1" tabindex="13" class='form-control' />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type='submit' name='dosubmit' class='btn  btn-default' value='<?php echo L('submit'); ?>' />
                        </div>
                    </div>
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

                                    username: {
                                        message: '<?php echo L('tky_member_username'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_username'); ?>不能为空'
                                            }
                                        }
                                    },

                                    PASSWORD: {
                                        message: '<?php echo L('tky_member_PASSWORD'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_PASSWORD'); ?>不能为空'
                                            }
                                        }
                                    },

                                    email: {
                                        message: '<?php echo L('tky_member_email'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_email'); ?>不能为空'
                                            }
                                        }
                                    },

                                    avatarstatus: {
                                        message: '<?php echo L('tky_member_avatarstatus'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_avatarstatus'); ?>不能为空'
                                            }
                                        }
                                    },

                                    score: {
                                        message: '<?php echo L('tky_member_score'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_score'); ?>不能为空'
                                            }
                                        }
                                    },

                                    adminid: {
                                        message: '<?php echo L('tky_member_adminid'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_adminid'); ?>不能为空'
                                            }
                                        }
                                    },

                                    timeoffset: {
                                        message: '<?php echo L('tky_member_timeoffset'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_timeoffset'); ?>不能为空'
                                            }
                                        }
                                    },
                                    STATUS: {
                                        message: '<?php echo L('tky_member_STATUS'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_member_STATUS'); ?>不能为空'
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