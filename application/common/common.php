<?php

use application\common\models\MemberModel;
use application\common\models\AuthroleModel;
use application\common\models\NewsauthorModel;
use application\common\models\NewsbefromModel;
use application\common\models\NewsclassModel;

// 应用公共文件
/**
 * 用户 显示树形下拉框.
 *
 * @param string $uid  选中id.
 *
 * @return string.
 */
function showselectmember($uid = '') {
    $s = 'selected="selected"';
    $str = '<select id="uid" name="uid" class="form-control" style="width: 200px;"><option  value="">==请选择==</option>';
    $list = (new MemberModel())->select();
    foreach ($list as $val) {
        $act = trim($val['uid']) == trim($uid) ? $s : "";
        $str .= '<option ' . $act . ' value="' . $val['uid'] . '">' . $val['username'] . '</option>';
    }
    $str .= '</select>';
    return $str;
}

/**
 * 角色 显示树形下拉框.
 *
 * @param string $roleid  选中id.
 *
 * @return string.
 */
function showselectrole($roleid = '') {
    $s = 'selected="selected"';
    $str = '<select id="roleid" name="roleid" class="form-control" style="width: 200px;"><option  value="">==请选择==</option>';
    $list = (new AuthroleModel())->select();
    foreach ($list as $val) {
        $act = trim($val['roleid']) == trim($roleid) ? $s : "";
        $str .= '<option ' . $act . ' value="' . $val['roleid'] . '">' . $val['title'] . '</option>';
    }
    $str .= '</select>';
    return $str;
}

