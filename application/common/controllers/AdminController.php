<?php

/**
 * +----------------------------------------------------------------------
 * | TickyPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: luomingui <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: AdminController.php 29529 2018-2-12 luomingui $
 * +----------------------------------------------------------------------
 * | Description：AdminController
 * +----------------------------------------------------------------------
 */

namespace application\common\controllers;

use ticky\Auth;

class AdminController extends BaseController {

    public function _initialize() {

        $this->md = 'admin';
        $this->user = $this->getlogininfo();
        $this->assign('user', $this->user);

        $_filter_controller = array('upload');
        $_filter = array('changetableval', 'render', 'set', '__set', 'search_frm', 'post_frm', 'logout', 'login', 'register',
            'changepassword', 'verify', 'chekcverify', 'checkusername', 'checkemail');
        if (!in_array(strtolower($this->controller), $_filter_controller)) {
            if (!in_array(strtolower($this->action), $_filter)) {

                if ($this->md == 'admin' && is_null($this->user)) {
                    $this->error("请登陆系统", '/' . $this->module . '/member/login');
                }

                $rule_name = $this->module . '-' . $this->controller . '-' . $this->action;
                $rule = M()->table('tky_auth_rule')->where('name="' . strtolower($rule_name) . '"')->find();
                if (!$rule) {
                    $idata = array();
                    $idata['module'] = strtolower($this->module . '-' . $this->controller);
                    $idata['type'] = "1";
                    $idata['name'] = strtolower($rule_name);
                    $idata['title'] = "";
                    $idata['regex'] = "";
                    $idata['status'] = "1";
                    M()->table('tky_auth_rule')->add($idata);
                }

                if ($this->user && $this->user['username'] != 'admin') {
                    // 用户权限检查
                    $auth = new Auth();
                    $result = $auth->check(strtolower($rule_name), $user[0]);
                    if (!$result) {
                        $this->error('您没有权限访问' . strtolower($rule_name));
                    }
                }
            }
        }
    }

}
