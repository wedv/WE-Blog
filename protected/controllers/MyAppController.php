<?php

class MyAppController extends Controller {
    public function actionIndex(){
        set_time_limit(0);          //执行时间无限长
        ignore_user_abort(true);    //关闭浏览器后继续执行
        $whi = 0;
        while($whi < 20){
            echo '----'.date('Y-m-d H:i:s').'----';
            $whi++;
            sleep(3);
        }
    }
    public function actionSortDomi(){
//        set_time_limit(0);          //执行时间无限长
//        ignore_user_abort(true);    //关闭浏览器后继续执行
//        $whi = 0;
//        while($whi < 10){
            echo '----'.date('Y-m-d H:i:s').'----';
            $url = 'http://pandavip.www.net.cn/check/check_ac1.cgi?domain=';
            $w = $this->getUniqueWord(5);
            $exts = array('com','net','cn');
            foreach($w as $a){
                foreach($exts as $ext){
                    $dom = $a.'.'.$ext;
                    $rurl = $url.$dom;
                    $response = file_get_contents($rurl);
                    $r = $this->lisRes($response);
                    $model = SortDomi::model()->findByAttributes(array('name'=>$a));
                    if(!$model){
                        $model = new SortDomi();
                        $model->name = $a;
                    }
                    $model->$ext = $r;
                    $et = $ext.'_time';
                    $model->$et = time();
                    $model->save();
                    echo $dom.'=>'.$r."\n";
                }
            }
            echo '----'.date('Y-m-d H:i:s').'----';
//            $whi++;
//            sleep(60*10);
//        }
    }

    public function lisRes($response){
        $r1 = substr($response,strpos($response,'|')+1,-1);
        $r2 = substr($r1,strpos($r1,'|')+1,-1);
        $r = substr($r2,0,strpos($r2,'|'));
        return $r;
    }

    public function getWord($len = 3, $count = 1){
        $initStr = 'abcdefghijklmnopqrstuvwxyz';
        $w = array();
        for($k = 0; $k < $count; $k++){
            $word = array();
            for($i = 0; $i < $len; $i++){
                $word[] = $initStr[mt_rand(0,25)];
            }
            $w[] = implode('', $word);
        }

        return $w;
    }

    public function getUniqueWord($count = 100){
        $len = rand(2,6);
        $words = $this->getWord($len,$count);
        sort($words);
        $words = array_unique($words);
        $w = array();
        foreach($words as $word){
            $w[] = $word;
        }

        return $w;
    }
}