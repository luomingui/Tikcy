<?php

/**
 * +----------------------------------------------------------------------
 * | LCLPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: 罗敏贵 <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: RoleController.php 43357 2018-02-12 16:09:16 luomingui $
 * +----------------------------------------------------------------------
 * | 文件功能：对应的表名:tky_role
 * +----------------------------------------------------------------------
 */

namespace application\admin\controllers;

use application\common\controllers\AdminController;
use application\common\models\AuthroleModel;

class RoleController extends AdminController {

    private $dao = null;

    public function __construct($module, $controller, $action) {
        $this->dao = (new AuthroleModel());
        parent::__construct($module, $controller, $action);
    }

    //首页
    public function index() {
        $page = isset($_GET['page']) ? max(0, intval($_GET['page'])) : '0';
        $arr = $this->search_frm();
        $pagedate = $this->dao->getPage($arr, $page);

        $this->assign('title', L('tky_authrole'));
        $this->assign('items', $pagedate['list']);
        $this->assign('multi', $pagedate['paging']);
        $this->render();
    }

    // 操作管理
    public function manage($roleid = 0) {
        $item = array();
        if ($roleid <= 0) {
            $this->assign('postUrl', '/admin/role/add');
            $this->assign('action', L('add'));
        } else {
            $item = $this->dao->where('roleid=' . $roleid)->find();
            $this->assign('postUrl', '/admin/role/update');
            $this->assign('action', L('edit'));
        }
        $this->assign('title', '管理条目');
        $this->assign('item', $item);
        $this->render();
    }

    // 添加记录
    public function add() {
        $data = $this->post_frm();
        $this->dao->add($data);
        $this->success('添加成功', '/admin/role');
    }

    // 更新记录
    public function update() {
        $data = $this->post_frm();
        $this->dao->update($data);
        $this->success('修改成功', '/admin/role');
    }

    // 批量删除
    public function batchremove() {
        $optype = $_GET['optype'];
        $ids = $_GET['ids'];
        if ($optype == "del") {
            $this->dao->delete(implode(",", $ids)); // 删除主键为1,2和5的用户数据
            $this->success('批量删除成功', '/admin/role');
        }
    }

    // 删除记录
    public function delete($roleid = null) {
        $this->dao->where('roleid=' . $roleid)->delete(); // 删除id为5的用户数据
        $this->success('删除成功', '/admin/role');
    }

    // 权限
    public function perm($roleid = 0) {
        $role = $this->dao->where('roleid=' . $roleid)->find();
        if (is_array($role)) {

        }
        if (isset($_GET['submit'])) {
            //$ids = $_GET['ids'];
            $actions = $_GET['actions'];
            foreach ($actions as $k => $v) {
                $methods = $v;
                foreach ($methods as $key => $val) {
                    $ids[] = $val;
                }
            }
            //debug($ids);
            $this->dao->addRolePerm($roleid, $ids);
        }
        $rdata = $this->dao->getAllRolePerm($roleid);
        $this->assign('title', $role['title'] . '权限');
        $this->assign('role', $role);
        $this->assign('list', $rdata);
        $this->render();
    }

    //查询条件
    private function search_frm() {
        $wheresql = " 1=1 ";
        if (strlen($_GET["roleid"]) > 0) {
            $wheresql = $wheresql . " and roleid='" . trim($_GET['roleid']) . "'";
        }
        if (strlen($_GET["title"]) > 0) {
            $wheresql = $wheresql . " and title='" . trim($_GET['title']) . "'";
        }
        if (strlen($_GET["status"]) > 0) {
            $wheresql = $wheresql . " and status='" . trim($_GET['status']) . "'";
        }
        if (strlen($_GET["rules"]) > 0) {
            $wheresql = $wheresql . " and rules='" . trim($_GET['rules']) . "'";
        }
        return $wheresql;
    }

    //表单数据
    private function post_frm() {
        $arr = array();
        if (strlen(trim($_GET['roleid'])) > 0) {
            $arr['roleid'] = empty($_GET['roleid']) ? "" : trim($_GET['roleid']);
        }
        $arr['title'] = empty($_GET['title']) ? "" : trim($_GET['title']);
        $arr['status'] = empty($_GET['status']) ? "1" : trim($_GET['status']);
        $arr['rules'] = empty($_GET['rules']) ? "" : trim($_GET['rules']);
        return $arr;
    }

    //获取模块下所有的控制器和方法写入到权限表
    public function initperm() {
        $modules = array('admin');  //模块名称
        $i = 0;
        foreach ($modules as $module) {
            $all_controller = $this->getController($module);
            foreach ($all_controller as $controller) {
                $all_action = $this->getAction($module, $controller);
                foreach ($all_action as $action) {
                    $controller = str_replace('Controller', '', $controller);
                    $data[$i]['module'] = $module;
                    $data[$i]['controller'] = $controller;
                    $data[$i]['action'] = $action;

                    //入库
                    if (!empty($module) && !empty($controller) && !empty($action)) {
                        $rule_name = $module . '-' . $controller . '-' . $action;
                        $rule = M()->table('tky_authrule')->where('name="' . strtolower($rule_name) . '"')->find();
                        if (!$rule) {
                            $idata = array();
                            $idata['module'] = strtolower($module . '-' . $controller);
                            $idata['type'] = "1";
                            $idata['name'] = strtolower($rule_name);
                            $idata['title'] = "";
                            $idata['regex'] = "";
                            $idata['status'] = "1";
                            M()->table('tky_authrule')->add($idata);
                        }
                    }

                    $i++;
                }
            }
        }
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    //获取所有控制器名称
    private function getController($module) {
        if (empty($module)) {
            return null;
        }
        $module_path = APP_PATH . '/' . $module . '/controllers/';  //控制器路径
        if (!is_dir($module_path)) {
            return null;
        }
        $module_path .= '/*.php';
        $ary_files = glob($module_path);
        foreach ($ary_files as $file) {
            if (is_dir($file)) {
                continue;
            } else {
                $files[] = basename($file, '.php');
            }
        }
        return $files;
    }

    //获取所有方法名称
    protected function getAction($module, $controller) {
        if (empty($controller)) {
            return null;
        }
        $file = APP_PATH . $module . '/controllers/' . $controller . '.php';
        if (file_exists($file)) {
            $content = file_get_contents($file);
            preg_match_all("/.*?public.*?function(.*?)\(.*?\)/i", $content, $matches);
            $functions = $matches[1];
            //排除部分方法
            $inherents_functions = array('_initialize', '__construct', 'getActionName', 'isAjax', 'display', 'show', 'fetch', 'buildHtml', 'assign', '__set', 'get', '__get', '__isset', '__call', 'error', 'success', 'ajaxReturn', 'redirect', '__destruct', '_empty');
            foreach ($functions as $func) {
                $func = trim($func);
                if (!in_array($func, $inherents_functions)) {
                    $customer_functions[] = $func;
                }
            }
            return $customer_functions;
        } else {
            \ticky\Log::record('is not file ' . $file, Log::INFO);
        }
        return null;
    }

}
