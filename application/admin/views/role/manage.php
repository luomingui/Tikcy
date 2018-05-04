<!--{template header}-->
<ol class="breadcrumb">
    <li><a href="/"><?php echo L('home'); ?></a></li>
    <li class="active"><a href="/admin/role"><?php echo L('tky_authrole'); ?></a></li>
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
                    <input type='hidden' name='roleid' value="<?php echo $item['roleid'] ?>" />

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"><?php echo L('tky_authrole_title'); ?></label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" id="title" name='title' value="<?php echo $item['title'] ?>" maxlength="30" tabindex="2" class='form-control' />
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
                                    title: {
                                        message: '<?php echo L('tky_authrole_title'); ?>无效',
                                        validators: {
                                            notEmpty: {
                                                message: '<?php echo L('tky_authrole_title'); ?>不能为空'
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
