<!--{template header}-->
<ol class="breadcrumb">
    <li><a href="/"><?php echo L('home'); ?></a></li>
    <li class="active"><a href="/admin/member"><?php echo L('tky_member'); ?></a></li>
</ol>
<div class='outer'>
    <div class="container" id="cpcontainer">
        <div id="titlebar">
            <div class="heading">
                <i class="icon-bug"></i><?php echo L('add'); ?>
            </div>
            <div class="actions">
                <a href="/admin/member/manage" class="btn export iframe"><i
                        class="icon-common-export icon-download-alt"></i><?php echo L('add'); ?></a>
            </div>
            <div id="querybox" class="show">
                <form method="get" autocomplete="off" action="/admin/member/" id="tb_search" class="form-inline" role="form">
                    <div class="form-group">
                        <label for="uid"><?php echo L('tky_member_uid'); ?></label>
                        <input type="text" class="form-control" id="uid" name="uid" value="<?php echo $_GET["uid"] ?>" maxlength="8" tabindex="1" />
                    </div>
                    <div class="form-group">
                        <label for="username"><?php echo L('tky_member_username'); ?></label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $_GET["username"] ?>" maxlength="15" tabindex="2" />
                    </div>

                    <div class="form-group">
                        <label for="email"><?php echo L('tky_member_email'); ?></label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $_GET["email"] ?>" maxlength="90" tabindex="4" />
                    </div>
                    <input type="submit" value="<?php echo L('search'); ?>" class='btn  btn-default' />
                </form>
            </div>
        </div>
        <form method="post" action="/admin/member/batchremove" class="form-inline" role="form">
            <table class='table table-condensed table-hover table-striped tablesorter table-fixed table-selectable'
                   id='MemberList'>
                <thead>
                    <tr>
                        <th></th>
                        <th><?php echo L('tky_member_uid'); ?></th>
                        <th><?php echo L('tky_member_username'); ?></th>
                        <th><?php echo L('tky_member_email'); ?></th>
                        <th><?php echo L('tky_member_score'); ?></th>
                        <th><?php echo L('tky_member_regip'); ?></th>
                        <th><?php echo L('tky_member_regdate'); ?></th>
                        <th><?php echo L('tky_member_lastloginip'); ?></th>
                        <th><?php echo L('tky_member_lastlogintime'); ?></th>
                        <th><?php echo L('tky_member_STATUS'); ?></th>
                        <th><?php echo L('tky_member_dateline'); ?></th>
                        <th><?php echo L('edit'); ?></th>
                    </tr>
                </thead>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="ids[]" value="<?php echo $item['uid'] ?>"></td>
                        <td><?php echo $item['uid'] ?></td>
                        <td><?php echo $item['username'] ?></td>
                        <td><?php echo $item['email'] ?></td>
                        <td><?php echo $item['score'] ?></td>
                        <td><?php echo $item['regip'] ?></td>
                        <td><?php echo $item['regdate'] ?></td>
                        <td><?php echo $item['lastloginip'] ?></td>
                        <td><?php echo $item['lastlogintime'] ?></td>
                        <td><?php echo $item['STATUS'] ?>
                            <?php
                            if ($item['status'] == 0) {
                                echo ' <img src="/static/images/yes.png" width="16" height="16" alt=""
                                 onclick=\'changeTableVal("member","tky_member", "uid", "' . $item['uid'] . '", "status", this)\' />';
                            } else {
                                echo '<img src="/static/images/cancel.png" width="16" height="16" alt=""
                                 onclick=\'changeTableVal("member","tky_member", "uid", "' . $item['uid'] . '", "status", this)\' />';
                            }
                            ?>
                        </td>
                        <td><?php echo $item['dateline'] ?></td>
                        <td>
                            <a href="/admin/member/manage/<?php echo $item['uid'] ?>"><?php echo L('edit'); ?></a>
                            <a href="/admin/member/delete/<?php echo $item['uid'] ?>"><?php echo L('delete'); ?></a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
                <tr>
                    <td colspan="15">
                        <div>
                            <input type="checkbox" name="chkall" id="chkall" class="checkbox" onclick="checkAll('prefix', this.form, 'ids')" /><?php echo L('chkall'); ?>
                            <input type="radio" class="radio" id="optype_outer" name="optype" value="del" /><?php echo L('batchremove'); ?>
                            <input type="radio" class="radio" id="optype_outer" name="optype" value="role">设置角色
                            <?php echo showselectrole(); ?>
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