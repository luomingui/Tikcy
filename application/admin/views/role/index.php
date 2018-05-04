<!--{template header}-->
<ol class="breadcrumb">
    <li><a href="/"><?php echo L('home'); ?></a></li>
    <li class="active"><a href="/admin/role"><?php echo L('tky_authrole'); ?></a></li>
</ol>
<div class='outer'>
    <div class="container" id="cpcontainer">
        <div id="titlebar">
            <div class="heading">
                <i class="icon-bug"></i><?php echo L('add'); ?>
            </div>
            <div class="actions">
                <a href="/admin/role/manage" class="btn export iframe"><i class="glyphicon glyphicon-plus"></i><?php echo L('add'); ?></a>
                <?php if ($user['username'] == 'admin'): ?>
                    <a href="/admin/role/initperm" class="btn export iframe">初始化</a>
                <?php endif ?>
            </div>
            <div id="querybox" class="show">
                <form method="get" autocomplete="off" action="/admin/authrole/" id="tb_search" class="form-inline" role="form">
                    <div class="form-group">
                        <label for="roleid"><?php echo L('tky_authrole_roleid'); ?></label>
                        <input type="text" class="form-control" id="roleid" name="roleid" value="<?php echo $_GET["roleid"] ?>" maxlength="8" tabindex="1" />
                    </div>
                    <div class="form-group">
                        <label for="title"><?php echo L('tky_authrole_title'); ?></label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $_GET["title"] ?>" maxlength="30" tabindex="2" />
                    </div>
                    <input type="submit" value="<?php echo L('search'); ?>" class='btn  btn-default' />
                </form>
            </div>
        </div>
        <form method="post" action="/admin/authrole/detail" class="form-inline" role="form">
            <table class='table table-condensed table-hover table-striped tablesorter table-fixed table-selectable'
                   id='AuthroleList'>
                <thead>
                    <tr>
                        <th></th>
                        <th><?php echo L('tky_authrole_roleid'); ?></th>
                        <th><?php echo L('tky_authrole_title'); ?></th>
                        <th><?php echo L('tky_authrole_STATUS'); ?></th>
                        <th><?php echo L('edit'); ?></th>
                    </tr>
                </thead>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="ids[]" value="<?php echo $item['roleid'] ?>"></td>
                        <td><?php echo $item['roleid'] ?></td>
                        <td><?php echo $item['title'] ?></td>
                        <td>
                            <?php
                            if ($item['status'] == 0) {
                                echo ' <img src="/static/images/yes.png" width="16" height="16" alt=""
                                 onclick=\'changeTableVal("role","tky_authrole", "roleid", "' . $item['roleid'] . '", "status", this)\' />';
                            } else {
                                echo '<img src="/static/images/cancel.png" width="16" height="16" alt=""
                                 onclick=\'changeTableVal("role","tky_authrole", "roleid", "' . $item['roleid'] . '", "status", this)\' />';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="/admin/role/perm/<?php echo $item['roleid'] ?>"><?php echo L('tky_authrule'); ?></a>
                            <i class="glyphicon glyphicon-pencil"></i><a href="/admin/role/manage/<?php echo $item['roleid'] ?>"><?php echo L('edit'); ?></a>
                            <i class="glyphicon glyphicon-minus"></i><a href="/admin/role/delete/<?php echo $item['roleid'] ?>"><?php echo L('delete'); ?></a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
                <tr>
                    <td colspan="15">
                        <div>
                            <input type="checkbox" name="chkall" id="chkall" class="checkbox" onclick="checkAll('prefix', this.form, 'ids')" /><?php echo L('chkall'); ?>
                            <input type="radio" class="radio" id="optype_outer" name="optype" value="del" /><?php echo L('batchremove'); ?>
                            <input type="submit" class="btn" name="sendsubmit" value="<?php echo L('submit'); ?>" />
                            <ul class="pagination right">
                                <?php echo $multi; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<!--{template footer}-->
