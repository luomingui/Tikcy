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
 * | SVN: $Id: IndexController.php 29529 2018-3-8 luomingui $
 * +----------------------------------------------------------------------
 * | Description：IndexController
 * +----------------------------------------------------------------------
 */

namespace application\install\controllers;

use application\common\controllers\BaseController;

class IndexController extends BaseController {

    //首页
    public function index() {
        $step = G('get.step');
        switch ($step) {
            case 1:
                $envItems = array();
                $dirfileItems = array(
                    array('type' => 'dir', 'path' => 'install/data'),
                    array('type' => 'dir', 'path' => 'install'),
                );
                $funcItems = array(
                    array('name' => 'mysql_connect'),
                    array('name' => 'fsockopen'),
                    array('name' => 'gethostbyname'),
                    array('name' => 'file_get_contents'),
                    array('name' => 'mb_convert_encoding'),
                    array('name' => 'json_encode'),
                    array('name' => 'curl_init'),
                );
                $this->envCheck($envItems);
                $this->dirfileCheck($dirfileItems);
                $this->functionCheck($funcItems);
                $this->assign('title', '系统安装向导');
                $this->assign('envItems', $envItems);
                $this->assign('dirfileItems', $dirfileItems);
                $this->assign('funcItems', $funcItems);
                $this->render('index/step1');
                break;
            case 2:
                $this->assign('title', '选择安装方式');
                $this->render('index/step2');
                break;
            case 3:
                $installError = '';
                $installRecover = '';
                $demoData = file_exists(APP_PATH . 'install/data/utf8_add.sql') ? true : false;
                $this->step3($installError, $installRecover);
                $this->assign('title', '创建数据库');
                $this->assign('demoData', $demoData);
                $this->assign('installError', $installError);
                $this->assign('installRecover', $installRecover);
                $this->render('index/step3');
                break;
            case 4:
                $installError = '';
                $installRecover = '';
                $demoData = file_exists(APP_PATH . 'install/data/utf8_add.sql') ? true : false;
                $this->step4($installError, $installRecover);
                $this->assign('title', '安装');
                $this->render('index/step4');
                break;
            case 5:
                $sitepath = strtolower(substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')));
                $sitepath = str_replace('install', "", $sitepath);
                $auto_site_url = strtolower('http://' . $_SERVER['HTTP_HOST'] . '/');
                $this->assign('title', '安装完成');
                $this->assign('sitepath', $sitepath);
                $this->assign('auto_site_url', $auto_site_url);
                $this->render('index/step5');
                break;
            default :
                $this->assign('title', '系统安装向导');
                $this->render();
                break;
        }
    }

    private function step3($installError, $installRecover) {
        if (IS_POST) {
            $irecover = G('post.install_recover');
            $config = array(
                'database' => array(
                    // 数据库类型
                    'type' => 'mysql',
                    // 服务器地址
                    'hostname' => G('post.db_host'),
                    // 数据库名
                    'database' => G('post.db_name'),
                    // 数据库用户名
                    'username' => G('post.db_user'),
                    // 数据库密码
                    'password' => G('post.db_pwd'),
                    // 数据库连接端口
                    'hostport' => G('post.db_port'),
                    // 数据库编码默认采用utf8
                    'charset' => 'utf8',
                    // 数据库表前缀
                    'prefix' => G('post.db_prefix'),
                ),
                'site' => array(
                    'name' => G('post.site_name'),
                    'admin' => G('post.admin'),
                    'password' => G('post.password'),
                ),
            );
            $dbconfig = $config['database'];
            $mysqli = new \mysqli($dbconfig['hostname'], $dbconfig['username'], $dbconfig['password'], '', $dbconfig['hostport']);
            if ($mysqli->connect_error) {
                $installError = '数据库连接失败';
                return;
            }
            if ($mysqli->get_server_info() > '5.0') {
                $mysqli->query("drop database " . $dbconfig['database'] . ";");
                $mysqli->query("create database " . $dbconfig['database'] . ";");
                $mysqli->query("set names " . $dbconfig['charset'] . ";"); //  #设置字符编码cmd窗口默认为gbk
            } else {
                $installError = '数据库必须为MySQL5.0版本以上';
                return;
            }
            if ($mysqli->error) {
                $installError = $mysqli->error;
                return;
            }
            if ($irecover != 'yes' && ($query = $mysqli->query("SHOW TABLES FROM " . $dbconfig['database']))) {
                while ($row = mysqli_fetch_array($query)) {
                    $dbprefix = $dbconfig['prefix'];
                    if (preg_match("/^$dbprefix/", $row[0])) {
                        $installError = '数据表已存在，继续安装将会覆盖已有数据';
                        $installRecover = 'yes';
                        return;
                    }
                }
            }
            $mysqli->close();
            cookie('installconfig', $config, 600);
            redirect('/install/?step=4');
        }//is_post
    }

    private function step4($installError, $installRecover) {
        $config = cookie('installconfig');
        $dbconfig = $config['database'];
        $file = APP_PATH . 'install/data/' . $dbconfig['charset'] . '.sql';
        if (is_file($file)) {
            //判断是否安装测试数据
            $sql = file_get_contents($file);
            if ($_POST['demo_data'] == '1') {
                $sql .= file_get_contents(APP_PATH . 'install/data/' . $dbconfig['charset'] . '_add.sql');
            }
            $sql = str_replace("\r\n", "\n", $sql);
            $this->runquery($sql);
            $this->admin($config['site']);
        }
        redirect('/install/?step=5');
    }

    private function admin($form) {
        $sql = "INSERT INTO `tky_member` (`uid`, `username`, `password`, `email`, `avatarstatus`, `score`, `regip`, `regdate`, `lastloginip`, `lastlogintime`, `adminid`, `timeoffset`, `status`, `dateline`) VALUES"
                . " ('1', '" . $form['admin'] . "', '" . $form['password'] . "', 'admin@qq.com', '0', '0', '120.0.0.1', '1513913320', '127.0.0.1', '1513913320', '0', '', '1', '1513913320');";
        $this->runquery($sql);
    }

    //execute sql
    private function runquery($sql) {
        if (!isset($sql) || empty($sql)) {
            return;
        }
        $sql = str_replace("\r", "\n", str_replace('#__', $db_prefix, $sql));
        $ret = array();
        $num = 0;
        foreach (explode(";\n", trim($sql)) as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            foreach ($queries as $query) {
                $ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0] . $query[1] == '--') ? '' : $query;
            }
            $num++;
        }
        unset($sql);
        //debug($ret);
        foreach ($ret as $query) {
            $query = trim($query);
            if ($query) {
                if (substr($query, 0, 12) == 'CREATE TABLE') {
                    $line = explode('`', $query);
                    $data_name = $line[1];
                    $this->showjsmessage('数据表  ' . $data_name . ' ... 创建成功');
                    $this->mysqlQuery(strtolower($query));
                    unset($line, $data_name);
                } else {
                    $this->mysqlQuery($query);
                }
            }
        }
    }

    private function mysqlQuery($sql) {
        try {
            $config = cookie('installconfig');
            $dbconfig = $config['database'];
            $mysqli = new \mysqli($dbconfig['hostname'], $dbconfig['username'], $dbconfig['password'], '', $dbconfig['hostport']);
            if ($mysqli->connect_error) {
                return false;
            }
            $mysqli->query("use  " . $dbconfig['database'] . ";"); //  #设置字符编码cmd窗口默认为gbk
            $mysqli->query($sql);
            $this->showjsmessage('错误描述:  ' . mysqli_error($mysqli) . ' ... 创建成功');
            $mysqli->close();
            return true;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * environmental check
     */
    private function envCheck(&$envItems) {
        $envItems[] = array('name' => '操作系统', 'min' => '无限制', 'good' => 'linux', 'cur' => PHP_OS, 'status' => 1);
        $envItems[] = array('name' => 'PHP版本', 'min' => '5.3', 'good' => '5.3', 'cur' => PHP_VERSION, 'status' => (PHP_VERSION < 5.3 ? 0 : 1));
        $tmp = function_exists('gd_info') ? gd_info() : array();
        preg_match("/[\d.]+/", $tmp['GD Version'], $match);
        unset($tmp);
        $envItems[] = array('name' => 'GD库', 'min' => '2.0', 'good' => '2.0', 'cur' => $match[0], 'status' => ($match[0] < 2 ? 0 : 1));
        $envItems[] = array('name' => '附件上传', 'min' => '未限制', 'good' => '2M', 'cur' => ini_get('upload_max_filesize'), 'status' => 1);
        $disk_place = function_exists('disk_free_space') ? floor(disk_free_space(ROOT_PATH) / (1024 * 1024)) : 0;
        $envItems[] = array('name' => '磁盘空间', 'min' => '100M', 'good' => '>100M', 'cur' => empty($disk_place) ? '未知' : $disk_place . 'M', 'status' => $disk_place < 100 ? 0 : 1);
    }

    /**
     * file check
     */
    private function dirfileCheck(&$dirfileItems) {
        foreach ($dirfileItems as $key => $item) {
            $item_path = $item['path'];
            if ($item['type'] == 'dir') {
                if (!$this->dirWriteable(APP_PATH . $item_path)) {
                    if (is_dir(APP_PATH . $item_path)) {
                        $dirfileItems[$key]['status'] = 0;
                        $dirfileItems[$key]['current'] = '+r';
                    } else {
                        $dirfileItems[$key]['status'] = -1;
                        $dirfileItems[$key]['current'] = 'nodir';
                    }
                } else {
                    $dirfileItems[$key]['status'] = 1;
                    $dirfileItems[$key]['current'] = '+r+w';
                }
            } else {
                if (file_exists(APP_PATH . $item_path)) {
                    if (is_writable(APP_PATH . $item_path)) {
                        $dirfileItems[$key]['status'] = 1;
                        $dirfileItems[$key]['current'] = '+r+w';
                    } else {
                        $dirfileItems[$key]['status'] = 0;
                        $dirfileItems[$key]['current'] = '+r';
                    }
                } else {
                    if ($fp = @fopen(APP_PATH . $item_path, 'wb+')) {
                        $dirfileItems[$key]['status'] = 1;
                        $dirfileItems[$key]['current'] = '+r+w';
                        fclose($fp);
                        @unlink(APP_PATH . $item_path);
                    } else {
                        $dirfileItems[$key]['status'] = -1;
                        $dirfileItems[$key]['current'] = 'nofile';
                    }
                }
            }
        }
    }

    /**
     * function is exist
     */
    private function functionCheck(&$funcItems) {
        foreach ($funcItems as $key => $item) {
            $funcItems[$key]['status'] = function_exists($item['name']) ? 1 : 0;
        }
    }

    /**
     * dir is writeable
     */
    private function dirWriteable($dir) {
        $writeable = 0;
        if (!is_dir($dir)) {
            @mkdir($dir, 0755);
        } else {
            chmod($dir, 0755);
        }
        if (is_dir($dir)) {
            if ($fp = @fopen("$dir/test.txt", 'w')) {
                fclose($fp);
                @unlink("$dir/test.txt");
                $writeable = 1;
            } else {
                $writeable = 0;
            }
        }
        return $writeable;
    }

    /**
     * drop table
     */
    private function droptable($table_name) {
        return "DROP TABLE IF EXISTS `" . $table_name . "`;";
    }

    /**
     * 抛出JS信息
     */
    private function showjsmessage($message) {
        echo '<script type="text/javascript">showmessage(\'' . addslashes($message) . ' \');</script>' . "\r\n";
        flush();
        ob_flush();
    }

}
