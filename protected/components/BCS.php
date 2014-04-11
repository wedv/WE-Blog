<?php

require_once(dirname(__FILE__) . "/Baidu-BCS/bcs.class.php");

/**
 * 百度云存储组件
 */
class BCS extends BaiduBCS {

    const BUCKET_ATTACHED = 'liuxos';
    const DIR_ATTACHED = '/attached';

    private static $_app = null;

    public static function app() {
        if (!self::$_app) {
            self::$_app = new BCS(BCS_AK, BCS_SK, 'bcs.duapp.com');
        }
        return self::$_app;
    }

    /**
     * attached上传前过滤
     * @param type $bucket
     * @param type $object
     * @param type $file
     * @param type $tmp_opt
     * @return boolean
     */
    public static function preFilterAttached($bucket, $object, $file, $tmp_opt) {
        if (BCS::app()->is_object_exist($bucket, $object)) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * attached上传
     * @param type $dir
     */
    public function upload_attached($dir) {
        $opt = array(
            'prefix'=>  substr($dir, strpos($dir,BCS::DIR_ATTACHED)),
            'acl'=>'public-read',
            BaiduBCS::IMPORT_BCS_PRE_FILTER => "BCS::preFilterAttached",
        );
        $dir = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . $dir;
        BCS::app()->upload_directory(BCS::BUCKET_ATTACHED, $dir, $opt);
    }

    /**
     * 重写log方法
     * @param type $log
     * @param type $opt
     */
    public function log($log, $opt) {
        if (isset($opt [self::IMPORT_BCS_LOG_METHOD]) && function_exists($opt [self::IMPORT_BCS_LOG_METHOD])) {
            $opt [self::IMPORT_BCS_LOG_METHOD]($log);
        } else {
//            trigger_error($log);
        }
    }

}
