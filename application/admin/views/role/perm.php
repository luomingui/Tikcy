<!--{template header}-->
<style>
    .group-item {
        display: block;
        width: 200px;
        float: left;
        font-size: 14px;
    }
    .text-right {
        border-right: #cfcfcf 1px solid;
        padding-right: 10px;
    }
</style>
<script type="text/javascript">
    function selectAll(checker, scope, type)
    {
        if (scope)
        {
            if (type == 'button')
            {
                $('#' + scope + ' input').each(function ()
                {
                    $(this).prop("checked", true)
                });
            } else if (type == 'checkbox')
            {
                $('#' + scope + ' input').each(function ()
                {
                    $(this).prop("checked", checker.checked)
                });
            }
        } else
        {
            if (type == 'button')
            {
                $('input:checkbox').each(function ()
                {
                    $(this).prop("checked", true)
                });
            } else if (type == 'checkbox')
            {
                $('input:checkbox').each(function ()
                {
                    $(this).prop("checked", checker.checked)
                });
            }
        }
    }
</script>
<ol class="breadcrumb">
    <li><a href="/"><?php echo L('home'); ?></a></li>
    <li><a href="/admin/role"><?php echo L('tky_authrole'); ?></a></li>
    <li class="active"><?php echo L('tky_authrule'); ?></li>
</ol>
<div class='outer'>
    <div class="container" id="cpcontainer">
        <div id="titlebar">
            <div class="heading">
                <i class="icon-bug"></i>【<?php echo $role['title']; ?>】<?php echo L('tky_authrule'); ?>
            </div>
            <div class="actions">

            </div>
            <div id="querybox" class="show">

            </div>
        </div>
        <form method="post" action="/admin/role/perm/<?php echo $role['roleid']; ?>" class="form-inline" role="form">
            <table class='table table-condensed table-hover table-striped tablesorter table-fixed table-selectable'
                   id='RoleList'>
                <thead>
                    <tr>
                        <th style="width: 200px;">模块</th>
                        <th>方法</th>
                    </tr>
                <tbody>

                    <?php echo $list; ?>

                    <tr>
                        <td colspan="15">
                            <div>
                                <input type='checkbox' name='allchecker[]' onclick='selectAll(this, "", "checkbox")' /><?php echo L('chkall'); ?>
                                <input type="submit" class="btn" id="submit" name="submit" value="<?php echo L('submit'); ?>" />
                            </div>
                        </td>
                    </tr>
            </table>
        </form>
    </div>
</div>
<!--{template footer}-->
