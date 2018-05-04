<?php

/**
 * +----------------------------------------------------------------------
 * | TickyPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: luomingui <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: IndexController.php 29529 2018-2-27 luomingui $
 * +----------------------------------------------------------------------
 * | Description：IndexController
 * +----------------------------------------------------------------------
 */

namespace application\admin\controllers;

use application\common\controllers\AdminController;

class IndexController extends AdminController {

    public function index() {
        redirect('/admin/hospital/');
    }

}
