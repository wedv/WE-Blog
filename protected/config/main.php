<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

//==========================================================
//$dbname = 'duapp';
///*填入数据库连接信息*/
//$host = 'localhost';
//$port = '3306';
//$user = 'root';//用户名(api key)
//$pwd = '';//密码(secret key)


//===========================================================
/*替换为你自己的数据库名  填入数据库连接信息*/
$dbname = 'a0404031134';
$host = 'hosthkjc78dc8d5j.88ming.com';
$port = '3306';
$user = 'a0404031134';//用户名(api key)
$pwd = '77405569';//密码(secret key)
 /*以上信息都可以在数据库详情页查找到*/

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'homeUrl' => 'http://www.liuxos.com',
    'name' => 'WE Blog',
    'language' => 'zh_cn',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'defaultController' => 'site',
    'modules' => array(
        'games',
    ),
    // application components
    'components' => array(
        /*
        'cache' => array(
            'class' => 'CFileCache',
        ),
        */
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        /*
        'db' => array(
            'connectionString' => 'sqlite:protected/data/blog.db',
            'tablePrefix' => 'tbl_',
        ),
         */
        // uncomment the following to use a MySQL database
          'db'=>array(
          'connectionString' => "mysql:host={$host};dbname={$dbname};port={$port}",
          'emulatePrepare' => true,
          'username' => "{$user}",
          'password' => "{$pwd}",
          'charset' => 'utf8',
          'tablePrefix' => 'tbl_',
          ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        /*
        'urlManager' => array(
            'urlFormat' => 'path',
            'urlSuffix' => '.html',
            'showScriptName'=>TRUE,

        ),
        */
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
);