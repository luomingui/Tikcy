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
 * | SVN: $Id: HomeController.php 29529 2018-3-5 luomingui $
 * +----------------------------------------------------------------------
 * | Description：HomeController
 * +----------------------------------------------------------------------
 */

namespace application\common\controllers;

use application\common\models\NewsModel;

class HomeController extends BaseController {

    public function _initialize() {
        $this->md = 'home';
        $this->user = $this->getlogininfo();
        $this->assign('user', $this->user);
    }

}
