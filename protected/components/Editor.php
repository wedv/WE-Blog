<?php
/**
 * kindeditor处理文件类
 * author 刘晓波
 */
require_once 'editor/JSON.php';
require_once 'editor/file_manager_json.php';
require_once 'editor/upload_json.php';

class Editor {
    
    public static function fileManageJson() {
        $php_path = Yii::app()->basePath;
        $php_url = Yii::app()->baseUrl;
        $fileManager = new fileManagerjson($php_path, $php_url);
        $fileManager->fileManager();
    }

    public static function uploadJson() {
        $php_path = Yii::app()->basePath;
        $php_url = Yii::app()->baseUrl;
        $fileManager = new uploadJson($php_path, $php_url);
        $fileManager->upJson();
    }

}

?>
