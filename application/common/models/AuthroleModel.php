<?php

/**
 * +----------------------------------------------------------------------
 * | TickyPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: luomingui <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: AuthroleModel.php 29529 2018-2-13 luomingui $
 * +----------------------------------------------------------------------
 * | Description：AuthroleModel
 * +----------------------------------------------------------------------
 */

namespace application\common\models;

class AuthroleModel extends BaseModel {

    public function __construct() {
        $this->table = 'tky_authrole';
        $this->pk = 'roleid';
        parent::__construct();
    }

    public function getAllRolePerm($roleid) {
        $role = $this->where('roleid=' . $roleid)->find();
        $role_rulearr = explode(",", $role['rules']);
        $checkedall = false;
        $htable = "";
        $modules = $this->query("SELECT DISTINCT module FROM tky_authrule");
        foreach ($modules as $module) {
            $topkey = $module['module'];

            $labModuleArr = explode("-", $topkey);
            $labModule = $labModuleArr[count($labModuleArr) - 1];
            $showModule = L($labModule);
            $row = "<tr>
            <th class = 'text-right w-150px'>" . $showModule . "<input type = 'checkbox' name = 'allchecker[]' onclick = \"selectAll(this,'$topkey', 'checkbox')\"  " . ($checkedall ? ' checked' : '') . "/></th>
            <td id = '" . $topkey . "' class = 'pv-10px'>";
            $methods = $this->query("SELECT * FROM tky_authrule WHERE module='" . $module['module'] . "'");

            $chk = 0;
            for ($i = 0; $i < count($methods); $i++) {
                $method = $methods[$i];
                $fun = $method['name'];

                $labfunArr = explode("-", $fun);
                $labfun = end($labfunArr);
                $showfun = L($labfun);

                $checked = in_array($method['ruleid'], $role_rulearr) ? "checked" : "";
                if ($checked) {
                    $chk++;
                }
                $row .= "<div class = 'group-item'>
                       <input type = 'checkbox' name = 'actions[" . $topkey . "][]' value = '" . $method['ruleid'] . "' " . ($checked ? ' checked' : '') . " />
                       <span class = 'priv' id = '" . $fun . "'>" . $showfun . "</span>
                   </div>";
            }
            if ($chk == count($methods)) {
                $checkedall = true;
            }
            $row .= '</td></tr>';
            $htable .= $row;
        }
        return $htable;
    }

    public function getRolePerm($roleid) {
        $role = $this->where('roleid=' . $roleid)->find();
        $role_rulearr = explode(",", $role['rules']);
        $perm = (new AuthruleModel());
        $rules = $perm->select();
        $rulearr = array();
        foreach ($rules as $rule) {
            $rule['checked'] = in_array($rule['ruleid'], $role_rulearr) ? "checked" : "";
            $rulearr[] = $rule;
        }
        return $rulearr;
    }

    //添加角色权限
    public function addRolePerm($roleid, $actions) {
        if (is_array($actions)) {
            $ruleids = implode(",", $actions);
            $this->editData("roleid=" . $roleid, array('rules' => $ruleids));
        }
    }

}
