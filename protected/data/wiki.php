<?php
/**
 * 本文件旨在说明一些调用到的插件的详细信息，
 * 包括{源文件位置/功能/以何种形式整合进yii中/相关文件目录/使用案例}
 */

/**
 * kindeditor
 * 源文件       :   www/js/kindeditor/
 * 功能         :   富文本编辑器，优于ckeditor，支持多种显示插入代码的样式。
 * 形式         :   现以components的方式整合到yii中(修改自其自带的php demo)
 * 目录         :   www/protected/componts/editor/          (整合进yii后的基础目录)
 *                  www/protected/componts/editor.php       (接口文件)
 *                  www/js/kindeditor/                      (源文件路径)
 *                  www/protected/controllers/EditoruploadController.php    (处理文件的调用地址)
 * 案例         :   www/protected/views/post/_form.php
 */
