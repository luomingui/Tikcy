<?php

/**
 * +----------------------------------------------------------------------
 * | TickyPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 http://tickyphp.cn All rights reserved.
 * +----------------------------------------------------------------------
 * | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * +----------------------------------------------------------------------
 * | Author: luomingui <e-mail:minguiluo@163.com> <QQ:271391233>
 * +----------------------------------------------------------------------
 * | SVN: $Id: CommentController.php 29529 2018-3-5 luomingui $
 * +----------------------------------------------------------------------
 * | Description：CommentController
 * +----------------------------------------------------------------------
 */

namespace application\common\controllers;

use application\common\controllers\HomeController;
use application\common\models\CommentModel;
use ticky\Page;

class CommentController extends HomeController {

    private $dao = null;

    public function __construct($module, $controller, $action) {
        $this->dao = (new CommentModel());
        parent::__construct($module, $controller, $action);
    }

    public function index() {
        if (isset($_GET['dosubmit'])) {
            $arr = array();
            if (strlen(trim($_GET['comment_box'])) > 0) {
                $arr['message'] = empty($_GET['comment_box']) ? "" : trim($_GET['comment_box']);
            }
            if (strlen(trim($_GET['id'])) > 0) {
                $arr['id'] = empty($_GET['id']) ? "" : trim($_GET['id']);
            }
            if (strlen(trim($_GET['idtype'])) > 0) {
                $arr['idtype'] = empty($_GET['idtype']) ? "" : trim($_GET['idtype']);
            }
            $arr['uid'] = empty($_GET['uid']) ? "0" : trim($_GET['uid']);
            $arr['ip'] = get_client_ip();
            $arr['port'] = 80;
            $arr['upid'] = 0;
            $arr['status'] = 0;
            $arr['dateline'] = NOW_TIME;
            $this->dao->addData($arr);
            redirect('/common/comment/?id=' . $_GET['id'] . '&idtype=' . $_GET['idtype']);
        }

        $page = isset($_GET['page']) ? max(0, intval($_GET['page'])) : '0';
        $action = isset($_GET['action']) ? $_GET['action'] : 'comment';

        $limit = 5;
        $where = $this->search_frm();
        $count = $this->dao->where($where)->count();
        $multi = new Page($count, $limit);
        $list = $this->dao->where($where)->order('cid desc')->limit($page . ',' . $limit)->select();

        foreach ($list as $row) {
            $row['dateline'] = date("Y-m-d  H:i:s", $row['dateline']);
            $member = M()->table('tky_member')->where('uid=' . $row['uid'])->find();
            if ($member) {
                $row['username'] = $member['realname'] . $member['username'];
            } else {
                $row['username'] = '匿名网友';
            }
            $data[] = $row;
        }

        $paging = $multi->loadmore();

        if ($action == 'comment') {
            $this->assign('title', '评论');
            $this->assign('comment_lable', '我的评论');
            $this->assign('comment_box', '请输入评论');
        } else {
            $this->assign('title', '留言');
            $this->assign('comment_lable', '我的留言');
            $this->assign('comment_box', '请输入留言');
        }
        $this->assign('uid', $this->getlogininfo()[0]);
        $this->assign('items', $data);

        $this->assign('multi', $paging);
        $this->render();
    }

    //查询条件
    private function search_frm() {
        $wheresql = " 1=1 ";
        if (strlen($_GET ["cid"]) > 0) {
            $wheresql = $wheresql . " and cid='" . trim($_GET['cid']) . "'";
        }
        if (strlen($_GET["upid"]) > 0) {
            $wheresql = $wheresql . " and upid='" . trim($_GET['upid']) . "'";
        }
        if (strlen($_GET ["uid"]) > 0) {
            $wheresql = $wheresql . " and uid='" . trim($_GET['uid']) . "'";
        }
        if (strlen($_GET ["id"]) > 0) {
            $wheresql = $wheresql . " and id='" . trim($_GET['id']) . "'";
        }
        if (strlen($_GET["idtype"]) > 0) {
            $wheresql = $wheresql . " and idtype='" . trim($_GET['idtype']) . "'";
        }
        if (strlen($_GET["message"]) > 0) {
            $wheresql = $wheresql . " and message='" . trim($_GET['message']) . "'";
        }
        if (strlen($_GET ["ip"]) > 0) {
            $wheresql = $wheresql . " and ip='" . trim($_GET['ip']) . "'";
        }
        if (strlen($_GET["port"]) > 0) {
            $wheresql = $wheresql . " and port='" . trim($_GET['port']) . "'";
        }
        if (strlen($_GET["status"]) > 0) {
            $wheresql = $wheresql . " and status='" . trim($_GET['status']) . "'";
        }
        if (strlen($_GET["dateline"]) > 0) {
            $wheresql = $wheresql . " and dateline='" . trim($_GET['dateline']) . "'";
        }
        return $wheresql;
    }

}
