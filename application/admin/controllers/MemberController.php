<?php

/**
 * +----------------------------------------------------------------------
 * | LCLPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: 罗敏贵 <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: MemberController.php 57145 2018-02-12 16:09:08 luomingui $
 * +----------------------------------------------------------------------
 * | 文件功能：对应的表名:tky_member
 * +----------------------------------------------------------------------
 */

namespace application\admin\controllers;

use application\common\controllers\AdminController;
use application\common\models\MemberModel;

class MemberController extends AdminController {

    private $dao = null;

    public function __construct($module, $controller, $action) {
        $this->dao = (new MemberModel());
        parent::__construct($module, $controller, $action);
    }

    //首页
    public function index() {

        $arr = $this->search_frm();

        $pagedate = $this->dao->getPage($arr, $_GET['page']);
        foreach ($pagedate['list'] as $row) {

            $row['lastlogintime'] = date("Y-m-d  H:i:s", $row['lastlogintime']);
            $row['regdate'] = date("Y-m-d  H:i:s", $row['regdate']);
            if ($row['gender'] == 'f') {
                $row['gender'] = '男';
            } else {
                $row['gender'] = '女';
            }
            $data[] = $row;
        }
        $this->assign('title', L('tky_member'));
        $this->assign('items', $data);
        $this->assign('multi', $pagedate['paging']);
        $this->render();
    }

    // 操作管理
    public function manage($uid = 0) {
        $item = array();
        if ($uid <= 0) {
            $this->assign('postUrl', '/admin/Member/add');
            $this->assign('action', L('add'));
        } else {
            $item = $this->dao->where('uid=' . $uid)->find();
            $this->assign('postUrl', '/admin/Member/update');
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
        $this->success('添加成功', '/admin/Member');
    }

    // 更新记录
    public function update() {
        $data = $this->post_frm();
        $this->dao->update($data);
        $this->success('修改成功', '/admin/Member');
    }

    // 批量删除
    public function batchremove() {
        $optype = $_GET['optype'];
        $ids = $_GET['ids'];

        if ($optype == "del") {
            $this->dao->delete(implode(",", $ids)); // 删除主键为1,2和5的用户数据
            $this->success('批量删除成功', '/admin/member');
        } else if ($optype == 'role') {
            $roleid = $_GET['roleid'];
            for ($i = 0; $i <= count($ids); $i++) {
                $tid = $ids[$i];
                if (!is_null($tid)) {
                    $sql = "INSERT INTO `tky_authrolemember` (`uid`, `roleid`) VALUES ('" . $tid . "', '" . $roleid . "');";
                    $this->dao->execute($sql);
                }
            }
            $this->success('批量设置角色成功', '/admin/member');
        }
    }

    // 删除记录
    public function delete($uid = null) {
        $this->dao->where('uid=' . $uid)->delete(); // 删除id为5的用户数据
        $this->success('删除成功', '/admin/Member');
    }

    //查询条件
    private function search_frm() {
        $wheresql = " 1=1 ";
        if (strlen($_GET["uid"]) > 0) {
            $wheresql = $wheresql . " and uid='" . trim($_GET['uid']) . "'";
        }
        if (strlen($_GET["username"]) > 0) {
            $wheresql = $wheresql . " and username='" . trim($_GET['username']) . "'";
        }
        if (strlen($_GET["password"]) > 0) {
            $wheresql = $wheresql . " and password='" . trim($_GET['password']) . "'";
        }
        if (strlen($_GET["email"]) > 0) {
            $wheresql = $wheresql . " and email='" . trim($_GET['email']) . "'";
        }
        if (strlen($_GET["avatarstatus"]) > 0) {
            $wheresql = $wheresql . " and avatarstatus='" . trim($_GET['avatarstatus']) . "'";
        }
        if (strlen($_GET["score"]) > 0) {
            $wheresql = $wheresql . " and score='" . trim($_GET['score']) . "'";
        }
        if (strlen($_GET["regip"]) > 0) {
            $wheresql = $wheresql . " and regip='" . trim($_GET['regip']) . "'";
        }
        if (strlen($_GET["regdate"]) > 0) {
            $wheresql = $wheresql . " and regdate='" . trim($_GET['regdate']) . "'";
        }
        if (strlen($_GET["lastloginip"]) > 0) {
            $wheresql = $wheresql . " and lastloginip='" . trim($_GET['lastloginip']) . "'";
        }
        if (strlen($_GET["lastlogintime"]) > 0) {
            $wheresql = $wheresql . " and lastlogintime='" . trim($_GET['lastlogintime']) . "'";
        }
        if (strlen($_GET["adminid"]) > 0) {
            $wheresql = $wheresql . " and adminid='" . trim($_GET['adminid']) . "'";
        }
        if (strlen($_GET["timeoffset"]) > 0) {
            $wheresql = $wheresql . " and timeoffset='" . trim($_GET['timeoffset']) . "'";
        }
        if (strlen($_GET["status"]) > 0) {
            $wheresql = $wheresql . " and status='" . trim($_GET['status']) . "'";
        }
        if (strlen($_GET["dateline"]) > 0) {
            $wheresql = $wheresql . " and dateline='" . trim($_GET['dateline']) . "'";
        }
        return $wheresql;
    }

    //表单数据
    private function post_frm() {
        $arr = array();
        if (strlen(trim($_GET['uid'])) > 0) {
            $arr['uid'] = empty($_GET['uid']) ? "" : trim($_GET['uid']);
        }
        $arr['username'] = empty($_GET['username']) ? "" : trim($_GET['username']);
        $arr['password'] = empty($_GET['password']) ? "" : trim($_GET['password']);
        $arr['email'] = empty($_GET['email']) ? "" : trim($_GET['email']);
        $arr['avatarstatus'] = empty($_GET['avatarstatus']) ? "" : trim($_GET['avatarstatus']);
        $arr['score'] = empty($_GET['score']) ? "" : trim($_GET['score']);
        $arr['regip'] = empty($_GET['regip']) ? "" : trim($_GET['regip']);
        $arr['regdate'] = empty($_GET['regdate']) ? "" : trim($_GET['regdate']);
        $arr['lastloginip'] = empty($_GET['lastloginip']) ? "" : trim($_GET['lastloginip']);
        $arr['lastlogintime'] = empty($_GET['lastlogintime']) ? "" : trim($_GET['lastlogintime']);
        $arr['adminid'] = empty($_GET['adminid']) ? "" : trim($_GET['adminid']);
        $arr['timeoffset'] = empty($_GET['timeoffset']) ? "" : trim($_GET['timeoffset']);
        $arr['status'] = empty($_GET['status']) ? "" : trim($_GET['status']);
        $arr['dateline'] = time();
        return $arr;
    }


}
