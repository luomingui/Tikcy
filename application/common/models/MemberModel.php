<?php

/**
 * +----------------------------------------------------------------------
 * | LCLPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: 罗敏贵 <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: MemberModel.php 24809 2018-02-12 15:33:04 luomingui $
 * +----------------------------------------------------------------------
 * | 文件功能：//tky_member
 * +----------------------------------------------------------------------
 */

namespace application\common\models;

class MemberModel extends BaseModel {

    public function __construct() {
        $this->table = 'tky_member';
        $this->pk = 'uid';
        parent::__construct();
    }

    /**
     * 检查用户最近$min分钟密码错误次数
     * $uid 用户ID
     * $min  锁定时间
     * $wTIme 错误次数
     * @return 错误次数超过返回false,其他返回错误次数，提示用户
     */
    public function checkPassWrongTime($uid, $min = 30, $wTime = 3) {
        if (empty($uid)) {
            return false;
        }
        $time = time();
        $prevTime = time() - $min * 60;
        //用户所在登录ip
        $ip = get_client_ip();
        $sql = "select * from tky_memberlogininfo where uid=$uid and status=2 and UNIX_TIMESTAMP(logintime) between $prevTime and $time and ipaddr='$ip'";
        $data = $this->query($sql);
        //统计错误次数
        $wrongTime = count($data);
        //判断错误次数是否超过限制次数
        if ($wrongTime > $wTime) {
            return false;
        }
        return $wrongTime;
    }

    /**
     * 记录密码输出信息
     * $uid 用户ID
     */
    public function recordPassWrongTime($uid) {
        $ip = get_client_ip();
        $time = date('Y-m-d H:i:s');
        $sql = "insert into tky_memberlogininfo(uid,ipaddr,logintime,status) values($uid,'$ip','$time',2)";
        $this->execute($sql);
    }

    /**
     * 密码验证
     * $uid 用户ID
     */
    public function password_verify($input_pass, $db_pass) {
        return $input_pass == $db_pass;
    }

}
