<?php

/**
 * +----------------------------------------------------------------------
 * | LCLPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: 罗敏贵 <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: PermModel.php 97946 2018-02-12 15:33:10 luomingui $
 * +----------------------------------------------------------------------
 * | 文件功能：//tky_perm
 * +----------------------------------------------------------------------
 */

namespace application\common\models;

class AuthruleModel extends BaseModel {

    public function __construct() {
        $this->table = 'tky_authrule';
        $this->pk = 'ruleid';
        parent::__construct();
    }

}
