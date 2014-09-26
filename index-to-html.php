<?php
ini_set("display_errors", "off");
date_default_timezone_set('prc');
function curlGet($url, $second = 10){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_TIMEOUT, $second);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);

    curl_close($ch);
    return $data;
}
$params = array();
$pstr = '';
if(isset($_GET['r'])){
    foreach($_GET as $gk => $gv){
        $params[] = $gk . '=' . $gv;
    }
    $pstr = '/index.php?' . implode('&', $params);
}
define('DS', DIRECTORY_SEPARATOR);
define('GET_R', isset($_GET['r']) ? true : false);
$baseUrl = 'liuxos3.duapp.com';
$host = $_SERVER['HTTP_HOST'];
$uri = $pstr ? $pstr : $_SERVER['REQUEST_URI'];
if(strpos($uri, 'games/games') !== false){
    header('Location:http://'.$baseUrl.$uri);
    die;
}
$uri = str_replace('/index.php', '', $uri);
if($uri == '' || $uri == '/'){
    $uri = '/site/index.html';
}
if(!$pstr){
    $uri = rawurlencode(mb_convert_encoding($uri, 'utf-8', 'gb2312'));
}
define('GET_URI', $uri);
$uri = str_replace('%2Findex.php', '', $uri);
$uri = str_replace('%2F', '/', $uri);
$uri = str_replace('%3F', '?', $uri);
$uri = str_replace('%3D', '=', $uri);
$eWord = array('<', '>', ':', '*', '"', '?', '\\', '%');
$euri = str_replace($eWord, '_', $uri);
$zHtml = dirname(__FILE__).DS.'z_html';
$zFile = $zHtml.DS.md5($euri);
$zDir = dirname($zFile);
if(isset($_GET['delhtml']) && $_GET['delhtml']==liuxos){
    !file_get_contents($zHtml.DS.md5('')) || unlink($zHtml.DS.md5(''));
    !file_get_contents($zHtml.DS.md5('/site/index.html')) || unlink($zHtml.DS.md5('/site/index.html'));
    !file_get_contents($zHtml.DS.md5('/post/index.html')) || unlink($zHtml.DS.md5('/post/index.html'));
    !file_get_contents($zHtml.DS.md5('/post/index.html_Post_page=2')) || unlink($zHtml.DS.md5('/post/index.html_Post_page=2'));
    !file_get_contents($zHtml.DS.md5('/post/index.html_Post_page=3')) || unlink($zHtml.DS.md5('/post/index.html_Post_page=3'));
    !file_get_contents($zHtml.DS.md5('/post/index.html_Post_page=4')) || unlink($zHtml.DS.md5('/post/index.html_Post_page=4'));
    !file_get_contents($zHtml.DS.md5('/post/index.html_Post_page=5')) || unlink($zHtml.DS.md5('/post/index.html_Post_page=5'));
    !file_get_contents($zHtml.DS.md5('/post/index.html_Post_page=6')) || unlink($zHtml.DS.md5('/post/index.html_Post_page=6'));
//    foreach(glob($zDir.'/*') as $file){
//        !is_file($file) || unlink($file);
//    }
    header('Location:http://'.$host);
    die;
}
$rand = (rand(1, 30) === 1);
if($rand || !is_file($zFile) || !file_get_contents($zFile)){
    if($baseUrl != $host){
        //echo("<script>console.log('".'http://'.$baseUrl.$uri."');</script>");
    }
    $url = 'http://'.$baseUrl.$uri;
    if(strpos($url, '.html')){
        //echo("<script>console.log('".'http://'.$baseUrl.$uri."');</script>");
    }
    $content = curlGet('http://'.$baseUrl.$uri);
    if(isset($_GET['debug'])){
        var_dump('http://'.$baseUrl.$uri);
        var_dump($content);
    }
    if(!$content && !isset($_GET['debug'])){
        header('Location:http://'.$host);
    }
//var_dump($url);
    $content = str_replace($baseUrl, $host, $content);

    $content = str_replace('src="/framework', 'src="http://'.$baseUrl.'/framework', $content);
    $content = str_replace('href="/framework', 'href="http://'.$baseUrl.'/framework', $content);
    $content = str_replace('action="/index.php', 'action="http://'.$baseUrl.'/index.php', $content);

    $content = str_replace('href="/css', 'href="http://'.$baseUrl.'/css', $content);
    $content = str_replace('href="/js', 'href="http://'.$baseUrl.'/js', $content);
    $content = str_replace('src="/js', 'src="http://'.$baseUrl.'/js', $content);
    $content = str_replace('src="/assets', 'src="http://'.$baseUrl.'/assets', $content);
    $content = str_replace('src="/images', 'src="http://'.$baseUrl.'/images', $content);
    $content = str_replace('url("/images', 'url("http://'.$baseUrl.'/images', $content);
    $content = str_replace('url(\'/images', 'url(\'http://'.$baseUrl.'/images', $content);
    $content = str_replace('http://'.$host.'/js/', 'http://'.$baseUrl.'/js/', $content);
    if(!is_dir($zDir)){
        mkdir($zDir, 0777, TRUE);
    }
    if(strpos($uri, 'post') !== false  || strpos($uri, 'site') !== false || strpos($uri, 'index') === 1 || $uri == ''){
        file_put_contents($zFile, $content);
    }
    $content = str_replace('service by we', 'service by duapp'.$uri.' on '.date('Y-m-d H:i:s',filemtime($zFile)).' size '.filesize($zFile), $content);
    die($content);
}else{
    $content = file_get_contents($zFile);
    $content = str_replace('service by we', 'service by liuxos'.$uri.' on '.date('Y-m-d H:i:s',filemtime($zFile)).' size '.filesize($zFile), $content);
    die($content);
}


date_default_timezone_set('PRC');
// change the following paths if necessary
ini_set("display_errors", "on"); error_reporting(E_ALL);

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();