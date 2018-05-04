<?php

/**
 * +----------------------------------------------------------------------
 * | LCLPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: 罗敏贵 <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: CommentModel.php 40094 2018-03-05 17:32:33 luomingui $
 * +----------------------------------------------------------------------
 * | 文件功能：//tky_comment
 * +----------------------------------------------------------------------
 */

namespace application\common\models;

class CommentModel extends BaseModel {

    public function __construct() {
        $this->table = 'tky_comment';
        $this->pk = 'cid';
        parent::__construct();
    }

}
