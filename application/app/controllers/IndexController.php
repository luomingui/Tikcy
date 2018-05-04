<?php

/**
 * +----------------------------------------------------------------------
 * | TickyPHP [ This is a freeware ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2015 All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: luomingui <e-mail:minguiluo@163.com> <QQ:271391233>
 * | SVN: $Id: IndexController.php 29529 2018-2-26 luomingui $
 * +----------------------------------------------------------------------
 * | Description：IndexController
 * +----------------------------------------------------------------------
 */

namespace application\app\controllers;

use application\common\controllers\AppController;

class IndexController extends AppController {

    public function __construct($module, $controller, $action) {
        parent::__construct($module, $controller, $action);
    }

    //首页
    public function index() {
         $this->render();
    }

}
