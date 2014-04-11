<?php
class GamesController extends GamesmoduleController {
        
    public function actionIndex(){
        $jsonp_callback = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : '';
        $error = '';
        $time = time();
        $homeIdSession = Jing::model()->getCurentHomeId();
        $sid = Yii::app()->session->sessionId;
        $jingData = '';
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //如果传入房间id，则进入该房间
            $homeId = isset($_GET['homeId']) ? (int)$_GET['homeId'] : FALSE;
            if($homeId){
                $comeIn = Jing::model()->inHome($homeId, $sid);
                if($comeIn['errorNo'] != Jing::ERROR_IN_HOME_SUCCESS){
                    throw Jing::model()->getErrorInHome($comeIn['errorNo']);
                }else{
                    $jingData = $comeIn['jingData'];
                }
            }
            //如果传入newHome，则新建房间
            $newHome = isset($_GET['newHome']) ? (int)$_GET['newHome'] : FALSE;
            if($newHome){
                $create = Jing::model()->createHome($sid);
                if($create['errorNo'] != Jing::ERROR_CREATE_HOME_SUCCESS){
                    throw Jing::model()->getErrorCreateHome($create['errorNo']);
                }else{
                    $jingData = $create['jingData'];
                }
            }
            //获取当前用户所在房间
            $curentHome = Jing::model()->getCurentHome($sid);
            if($curentHome['errorNo'] == Jing::ERROR_CURENT_HOME_SUCCESS){
                $jingData = $curentHome['jingData'];
            }
            //如果没有归属的房间，则新建房间
            if(!$jingData){
                $create = Jing::model()->createHome($sid);
                if($create['errorNo'] != Jing::ERROR_CREATE_HOME_SUCCESS){
                    throw Jing::model()->getErrorCreateHome($create['errorNo']);
                }else{
                    $jingData = $create['jingData'];
                }
            }
            //这个时候$jingData肯定不为空，即在一个房间里
            //获取curTime客户端时间，如果此后数据没有改动则返回空
            if(isset($_GET['curTime'])){
                $curTime = $_GET['curTime'];
                if(!Jing::model()->hasChange($jingData, $curTime)){
                    $sub = 0;
                }else{
                    $sub = 1;
                }
                echo $jsonp_callback ? $jsonp_callback.'('.json_encode(array('sub'=>$sub)).');' : json_encode(array('sub'=>$sub));
                Yii::app()->end();
            }

            $currentData = $jingData && $jingData->data ? json_decode($jingData->data, true) : '';
            //判断当前用户是红方/绿方
            if($jingData->sid1 == $sid){
                $user = 1;
            }else if($jingData->sid2 == $sid){
                $user = 2;
            }else{
                $error .= 'status error';
            }
    //        $currentData = Yii::app()->session;
            //游戏初始化状态
            $restart = 0;
            if (isset($_POST['restart']) && $_POST['restart'] > 0)
                $restart = 1;
            if($restart > 0){
                $game = self::model()->getInitGame();
                $currentData['game'] = $game;
                //保存到数据库
                $jingData->data = json_encode($currentData);
                $saveOk = $jingData->save();
            }else{
                $pos = '';
                if(isset($_POST['pos']) && $_POST['pos'])
                    $pos = $_POST['pos'];
                //接收提交数据，处理游戏数据
                if($pos){
                    if($currentData['game']['user'] != $user){
                        $error .= 'user error';
                    }
                    $currentData['game'] = $this->subGameData($currentData['game'], $pos, $_POST['mpos']);
                    //保存到数据库
                    $jingData->data = json_encode($currentData);
                    $saveOk = $jingData->save();
                }
            }
            //判断游戏结果
            $game = $currentData['game'];
            $won = $game['won'];

            if($won != 0){
                $setWon = $jingData->setWon($currentData['game']['won']);
                if($time - $jingData->update_time < 6){
                    Yii::app()->user->setFlash('won', $won > 0 ? ($won == 1 ? '红方胜利' : '绿方胜利') : '和棋');
                }
            }
            //刚才走的哪个位置
            if($time - $jingData->update_time < 6 && $currentData['game']['lastWay']){
                Yii::app()->user->setFlash('lastWay', $currentData['game']['lastWay']);
            }

            if($error){
                throw new CHttpException('400', $error);
            }
            $transaction->commit();
        }catch (Exception $e){
            Jing::model()->setCurentHomeId($homeIdSession);
//            var_dump($e);
            $transaction->rollback();
        }
        //新建房间
        if(isset($newHome) && $newHome){
            $this->redirect(array('games/index'));
        }
        //提交数据后跳转，防止重复提交
        if(isset($_POST['pos'])){
            $this->redirect(array('games/index'));
        }
        if($homeId){
            $this->redirect(array('games/index'));
        }
        $showHomeList = isset($_GET['showHomeList']) ? 1 : 0;
        $homeList = array();
        if($jingData->sid1 == '' || $jingData->sid2 == '' || $showHomeList){
            $homeList = Jing::model()->getHomeList();
            if(!$homeList){
                Yii::app()->user->setFlash('homeList', '没有等待中的游戏，可以新建游戏！');
            }
        }
        $sitDown = 0;
        if($jingData->sid1 != ''){
            $sitDown += 1;
        }
        if($jingData->sid2 != ''){
            $sitDown += 2;
        }
        $renderData = array('curTime'=>$time,'stats'=>$game, 'won'=>$won, 'onWay'=>$game['onWay'], 'user'=>$user, 'homeId'=>$jingData->id, 'homeList'=>$homeList, 'sitDown'=>$sitDown);
        if(Yii::app()->request->isAjaxRequest){
            $viewData = $this->renderPartial('index_content', $renderData, TRUE);
            $json = json_encode(array('error_no'=>0,'data'=>$viewData,'curTime'=>$time));
            echo $jsonp_callback ? $jsonp_callback.'('.$json.');' : $json;
            Yii::app()->end();
        }
        $this->render('index', array('renderData'=>$renderData));
    }
    
    //处理提交的数据
    public function subGameData($gameData, $pos, $mpos){
        $pos = explode(',', $pos);
        $mpos = explode(',', $mpos);
        //当前用户
        $user = $gameData['user'];
        //如果提交的位置是已经被占用/当前#字已有胜利的一方/或已经有一方获得全局的胜利，将游戏元数据返回
        if($gameData['map'][$mpos[0]][$mpos[1]][$pos[0]][$pos[1]] > 0 || $gameData['wonMap'][$mpos[0]][$mpos[1]] != 0 || $gameData['won'] != 0)
            return $gameData;
        //匹配可以提交的井字位置
        $can = $gameData['onWay'][$mpos[0]][$mpos[1]] > 0;
        //如果可以提交
        if($can){
            //当前用户占用此位置
            $gameData['map'][$mpos[0]][$mpos[1]][$pos[0]][$pos[1]] = $user;
            //更新当前井字的状态
            $wonner = $this->isOver($gameData['map'][$mpos[0]][$mpos[1]]);
            $gameData['wonMap'][$mpos[0]][$mpos[1]] = $wonner;
            //初始化可以走的井字（全部不能走）
            $onWay = Jing::$wonMap;
            //获取下个回合指定的井字位置的状态
            $posWay = $gameData['wonMap'][$pos[0]][$pos[1]];
            //可以走
            if ($posWay == 0) {
                $onWay[$pos[0]][$pos[1]] = 1;
            } else {
                //和棋/或已经有一方在此井字中胜利，则下个回合中可以在任意一个井字中下棋（除了和棋的和已经有一方胜利的井字）
                foreach ($gameData['wonMap'] as $okey => $ons) {
                    foreach ($ons as $ok => $on) {
                        //可以走的，设置onWay
                        if ($on == 0) 
                            $onWay[$okey][$ok] = 1;
                    }
                }
            }
            //赋值给要返回的数据
            $gameData['onWay'] = $onWay;        
            $gameData['user'] = $user == 1 ? 2 : 1;
            $gameData['lastWay'] = "$mpos[0],$mpos[1],$pos[0],$pos[1]";
        }
        $won = $this->isOver($gameData['wonMap']);
        if($won != 0){
            $gameData['won'] = $won;
            return $gameData;
        }
        return $gameData;
    }
    
    //判断一个井号的状态，大于0：胜利的一方；等于0：还没法判断输赢；小于0：和棋；
    public function isOver($gameData){
        foreach ($gameData as $key => $value) {
            if($gameData[$key][0] == $gameData[$key][1] && $gameData[$key][1] == $gameData[$key][2] && $gameData[$key][1] > 0){
                return $gameData[$key][1];
            }
            if($gameData[0][$key] == $gameData[1][$key] && $gameData[1][$key] == $gameData[2][$key] && $gameData[1][$key] > 0){
                return $gameData[1][$key];
            }
        }
        if(($gameData[0][0] == $gameData[1][1] && $gameData[2][2] == $gameData[1][1] && $gameData[2][2] > 0)
                || ($gameData[0][2] == $gameData[1][1] && $gameData[1][1] == $gameData[2][0] && $gameData[1][1] > 0)){
            return $gameData[1][1];
        }
        $hasEmpty = 0;
        foreach ($gameData as $key => $value) {
            if($gameData[$key][0] == 0 || $gameData[$key][1] == 0 || $gameData[$key][2] == 0){
                $hasEmpty += 1;
            }
        }
        if(!$hasEmpty)
            return -1;
        return 0;
    }
}