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

namespace application\common\models;

use ticky\Model;
use ticky\Page;

class BaseModel extends Model {

    public function getPage($where, $start = 0, $limit = 13) {
        $count = $this->where($where)->count();
        $multi = new Page($count, $limit);
        $list = $this->where($where)->order($this->pk . ' desc')->limit($start . ',' . $limit)->select();
        $rdata = array();
        foreach ($list as $row) {
            $row['dateline'] = date("Y-m-d  H:i:s", $row['dateline']);
            $rdata[] = $row;
        }
        return array(
            'list' => $rdata,
            'paging' => $multi->fpage(1, 2, 3, 4, 5, 6, 7),
        );
    }

    /**
     * 添加数据
     * @param    array    $data    数据
     * @return   integer           新增数据的id
     */
    public function addData($data) {
        $id = $this->add($data);
        return $id;
    }

    /**
     * 修改数据
     * @param    array    $map    where语句数组形式
     * @param    array    $data   修改的数据
     * @return    boolean         操作是否成功
     */
    public function editData($map, $data) {
        $result = $this->where($map)->update($data);
        return $result;
    }

    /**
     * 删除数据
     * @param    array    $map    where语句数组形式
     * @return   boolean          操作是否成功
     */
    public function deleteData($map) {
        $result = $this->where($map)->delete();
        return $result;
    }

}
