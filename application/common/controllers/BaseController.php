<?php

/**
 * +----------------------------------------------------------------------
 * | TickyPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: luomingui <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: BaseController.php 29529 2018-2-12 luomingui $
 * +----------------------------------------------------------------------
 * | Description：BaseController
 * +----------------------------------------------------------------------
 */

namespace application\common\controllers;

use ticky\Controller;
use ticky\Config;
use application\common\models\MemberModel;

class BaseController extends Controller {

    protected $user = null;
    protected $md = null;

    //生成验证码 <img src="verify" onclick='this.src = this.src + "?" + Math.random()'  />
    public function verify() {
        $config = array(
            'imageH' => 62, // 验证码图片高度
            'imageW' => 250, // 验证码图片宽度
            'length' => 5, // 验证码位数
        );
        $Verify = new \ticky\Verify($config);
        $Verify->entry();
    }

    public function chekcVerify() {
        $code = $_GET['code'];
        $v = new \ticky\Verify();
        if ($v->check($code)) {
            echo json_encode(['valid' => true]);
        } else {
            echo json_encode(['valid' => false]);
        }
    }

    public function getlogininfo() {
        $_auth = cookie('auth');
        if ($_auth) {
            return $_auth;
        } else {
            return null;
        }
    }

    //退出
    public function logout() {
        // 清除
        cookie(null, 'ticky_');
        redirect('/' . $this->module . '/member/login');
    }

    //登陆
    public function login() {
        if (IS_POST) {
            $yzm = trim($_GET["code"]);
            $name = trim($_GET['admin_username']);
            $password = trim($_GET['admin_password']);
            if (is_null($yzm) || is_null($name) || is_null($password)) {
                $this->error('登陆失败：请输入用户名和密码', '/' . $this->module . '/member/login');
            }
            $member = (new MemberModel())->where("username='" . $name . "'")->find();
            if ($member) {
                //判断用户是否激活
                if (intval($member['status']) == 2) {
                    $this->error('登陆失败：' . $name . '帐号没有激活，请激活帐号', '/admin/member/login');
                    exit;
                }
                //检查用户最近30分钟密码错误次数
                $uid = $member['uid'];
                $res = (new MemberModel())->checkPassWrongTime($uid);
                //错误次数超过限制次数
                if ($res === false) {
                    $this->error('登陆失败：你刚刚输错很多次密码，为了保证账户安全，系统已经将您账号锁定30min', '/admin/member/login');
                    exit;
                }
                //判断密码是否正确
                $isRightPass = (new MemberModel())->password_verify($password, $member['password']);
                unset($member['password']);
                //登录成功
                if ($isRightPass) {
                    cookie('auth', $member, 864000);
                    $data = array();
                    $data['uid'] = $member['uid'];
                    $data['lastloginip'] = get_client_ip();
                    $data['lastlogintime'] = NOW_TIME;
                    (new MemberModel())->where(array('uid' => $member['uid']))->update($data);
                    if ($member['adminid'] > 0) {
                        $this->success('登录成功', '/admin');
                    } else {
                        $this->success('登录成功', '/home');
                    }
                    exit;
                } else {
                    //记录密码错误次数
                    (new MemberModel())->recordPassWrongTime($admin['uid']);
                    $this->error('登陆失败：密码错误请重新输入', '/' . $this->module . '/member/login');
                    exit;
                }
            } else {
                $this->success('登陆失败:用户名错误', '/' . $this->module . '/member/login');
            }
        } else {
            if ($this->user != null) {
                if ($this->md == "admin") {
                    redirect('/' . $this->module . '/');
                }
            } else {
                $this->assign('title', L('login'));
                $this->assign('keywords', L('login'));
                $this->assign('description', L('login'));
                $this->render();
            }
        }
    }

    //注册
    public function register() {
        if (IS_POST) {
            $username = trim($_GET['username']);
            $password = trim($_GET["password"]);
            $repassword = trim($_GET["repassword"]);
            $email = trim($_GET['email']);
            $code = $_GET['code'];
            //定义激活码
            $token = md5($username . $password . time());
            $token_exptime = time() + 60 * 60 * 24;
            if (is_null($username) || is_null($password) || is_null($email) || $password != $repassword) {
                $this->error('注册失败：请输入用户名,密码和邮箱,或两次密码输入错误', '/' . $this->module . '/member/register');
            }

            $member = (new MemberModel())->where("username='" . $username . "'")->find();
            if ($member) {
                $this->error('注册失败：用户名已经存在', '/' . $this->module . '/member/register');
            }
            $member = (new MemberModel())->where("email='" . $email . "'")->find();
            if ($member) {
                $this->error('注册失败：邮箱已经存在', '/' . $this->module . '/member/register');
            }
            $data = array(
                'token_exptime' => $token_exptime,
                'token' => $token,
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'avatarstatus' => 0,
                'regip' => get_client_ip(),
                'regdate' => NOW_TIME,
                'adminid' => 0,
                'score' => 0,
                'status' => 2,
                'lastloginip' => get_client_ip(),
                'lastlogintime' => NOW_TIME,
                'dateline' => NOW_TIME
            );
            try {
                $data['uid'] = (new MemberModel())->addData($data);
                $stmp = new \application\common\lib\smtp();
                $subject = Config::get('title') . ":邮箱激活";
                $body = "亲爱的" . $username . "：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/>
                        <a href='" . Config::get('app_host') . $this->module . "/member/activateEmail?token=$token' target='_blank'>"
                        . Config::get('app_host') . $this->module . "/member/activateEmail?token=$token</a>"
                        . "<br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";
                $stmp->send($email, $subject, $body);

                $this->success('请登录' . $email . '邮箱激活帐号，才能正常启动.', '/' . $this->module . '/member/login');
            } catch (Exception $exc) {
                (new MemberModel())->delete($data['uid']);
                $this->error('注册失败：' . $exc->getTraceAsString(), '/' . $this->module . '/member/register');
            }
            /*
              cookie('auth', $data, 864000);
              if ($data['adminid'] > 0) {
              $this->success('登录成功', '/admin');
              } else {
              $this->success('登录成功', '/home');
              }
             */
        } else {
            $this->assign('title', L('register'));
            $this->assign('keywords', L('register'));
            $this->assign('description', L('register'));
            $this->render();
        }
    }

    //激活邮箱
    public function activateEmail() {
        $token = $_GET['token'];
        $member = (new MemberModel())->where("token='" . $token . "'")->find();
        if (is_array($member)) {
            $uid = $member['uid'];
            $member['status'] = 1;
            (new MemberModel())->where(array('uid' => $uid))->update($member);
            $this->success($member['username'] . '帐号已激活', '/' . $this->module . '/member/login');
        } else {
            $this->error('激活码不存在', Config::get('app_host'));
        }
    }

    //修改密码
    public function changepassword() {
        if (is_null($this->user)) {
            $this->error('修改密码必须要登陆', '/' . $this->module . '/member/login');
        }
        if (IS_POST) {
            $uid = $this->user['uid'];
            $oldpassword = $_GET['oldpassword'];
            $newpassword = $_GET['newpassword'];
            $repassword = $_GET['repassword'];

            $admin = (new MemberModel())->where(array('uid' => $uid))->find();

            if ($admin && ($admin['password'] == $oldpassword ) && ($newpassword == $repassword)) {
                $data = array();
                $data['uid'] = $uid;
                $data['password'] = $newpassword;
                (new MemberModel())->where(array('uid' => $uid))->update($data);
                $this->success("修改密码成功", '/' . $this->module . '/member/changepassword');
            } else {
                $this->error("修改密码失败", '/' . $this->module . '/member/changepassword');
            }
        } else {
            $this->assign('title', L('changepassword'));
            $this->assign('action', L('changepassword'));
            $this->assign('keywords', L('changepassword'));
            $this->assign('description', L('changepassword'));
            $this->assign('postUrl', '/' . $this->module . '/member/changepassword/');
            $this->render();
        }
    }

    public function checkUserName() {
        $username = $_GET['username'];
        //\ticky\Log::record('checkUserName:' . $username);
        if (!empty($username)) {
            $member = (new MemberModel())->where("username='" . $username . "'")->find();
            if (!empty($member) && is_array($member)) {
                echo json_encode(['valid' => false, 'message' => '用户名已存在']);
            } else {
                echo json_encode(['valid' => true, 'message' => '用户名可以用']);
            }
        } else {
            echo json_encode(['valid' => true, 'message' => '用户名可以用']);
        }
    }

    public function checkEmail() {
        $email = $_GET['email'];
        //\ticky\Log::record('checkUserName:' . $username);
        if (!empty($email)) {
            $member = (new MemberModel())->where("email='" . $email . "'")->find();
            if (!empty($member) && is_array($member)) {
                echo json_encode(['valid' => false, 'message' => '邮箱已存在']);
            } else {
                echo json_encode(['valid' => true, 'message' => '邮箱可以用']);
            }
        } else {
            echo json_encode(['valid' => false, 'message' => '邮箱不可以用']);
        }
    }

}
