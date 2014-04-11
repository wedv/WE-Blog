<?php
class Jing extends CActiveRecord
{
    public static $wonMap = array(
        0=>array(0=>'',1=>'',2=>''),
        1=>array(0=>'',1=>'',2=>''),
        2=>array(0=>'',1=>'',2=>''),
    );
    public static $onWay = array(
        0=>array(0=>'1',1=>'1',2=>'1'),
        1=>array(0=>'1',1=>'1',2=>'1'),
        2=>array(0=>'1',1=>'1',2=>'1'),
    );
    public static $amp = array(
        array(
            array(
                0=>array(0=>'',1=>'',2=>''),
                1=>array(0=>'',1=>'',2=>''),
                2=>array(0=>'',1=>'',2=>''),
            ),
            array(
                0=>array(0=>'',1=>'',2=>''),
                1=>array(0=>'',1=>'',2=>''),
                2=>array(0=>'',1=>'',2=>''),
            ),
            array(
                0=>array(0=>'',1=>'',2=>''),
                1=>array(0=>'',1=>'',2=>''),
                2=>array(0=>'',1=>'',2=>''),
            )
        ),
        array(
            array(
                0=>array(0=>'',1=>'',2=>''),
                1=>array(0=>'',1=>'',2=>''),
                2=>array(0=>'',1=>'',2=>''),
            ),
            array(
                0=>array(0=>'',1=>'',2=>''),
                1=>array(0=>'',1=>'',2=>''),
                2=>array(0=>'',1=>'',2=>''),
            ),
            array(
                0=>array(0=>'',1=>'',2=>''),
                1=>array(0=>'',1=>'',2=>''),
                2=>array(0=>'',1=>'',2=>''),
            )
        ),
        array(
            array(
                0=>array(0=>'',1=>'',2=>''),
                1=>array(0=>'',1=>'',2=>''),
                2=>array(0=>'',1=>'',2=>''),
            ),
            array(
                0=>array(0=>'',1=>'',2=>''),
                1=>array(0=>'',1=>'',2=>''),
                2=>array(0=>'',1=>'',2=>''),
            ),
            array(
                0=>array(0=>'',1=>'',2=>''),
                1=>array(0=>'',1=>'',2=>''),
                2=>array(0=>'',1=>'',2=>''),
            )
        )
    );
    public function getInitGame(){
        return array('map'=>self::$amp, 'user'=>1, 'won'=>0, 'wonMap'=>self::$wonMap, 'onWay'=>self::$onWay, 'lastWay'=>'0');
    }
    const ERROR_IN_HOME_SUCCESS = 0;
    const ERROR_IN_HOME_FULL = 1;
    const ERROR_IN_HOME_NULL = 2;
    public $errorInHome = array(
        self::ERROR_IN_HOME_SUCCESS => '进入房间成功',
        self::ERROR_IN_HOME_FULL => '房间人数已满',
        self::ERROR_IN_HOME_NULL => '房间不存在',
    );
    public function getErrorInHome($errorNo = NULL){
        return $errorNo !== NULL && isset($this->errorInHome[$errorNo]) ? $this->errorInHome[$errorNo] : $this->errorInHome;
    }

    const ERROR_CREATE_HOME_SUCCESS = 0;
    const ERROR_CREATE_HOME_UNKOWN = 1;
    public $errorCreateHome = array(
        self::ERROR_CREATE_HOME_SUCCESS => '进入房间成功',
        self::ERROR_CREATE_HOME_UNKOWN => '创建房间存在未知错误',
    );
    public function getErrorCreateHome($errorNo = NULL){
        return $errorNo !== NULL && isset($this->errorCreateHome[$errorNo]) ? $this->errorCreateHome[$errorNo] : $this->errorCreateHome;
    }

    const ERROR_CURENT_HOME_SUCCESS = 0;
    const ERROR_CURENT_HOME_UNKOWN = 1;
    public $errorCurentHome = array(
        self::ERROR_CURENT_HOME_SUCCESS => '获取当前房间成功',
        self::ERROR_CURENT_HOME_UNKOWN => '获取当前房间存在未知错误',
    );
    public function getErrorCurentHome($errorNo = NULL){
        return $errorNo !== NULL && isset($this->errorCurentHome[$errorNo]) ? $this->errorCurentHome[$errorNo] : $this->errorCurentHome;
    }


    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{jing}}';
	}

	public function rules()
	{
		return array(
			array('data', 'length', 'max'=>2048),
			array('sid1, sid2, update_time, create_time, won', 'length', 'max'=>128),
			array('id, data, sid1, sid2, update_time, create_time, won', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'won' => '获胜方',
			'data' => '游戏数据',
			'sid1' => '玩家一',
			'sid2' => '玩家二',
			'update_time' => 'update_time',
			'create_time' => 'create_time',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('sid1',$this->sid1,true);
		$criteria->compare('sid2',$this->sid2,true);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('won',$this->won);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function beforeSave() {
        if(parent::beforeSave()){
            $time = time();
            if($this->isNewRecord){
                $this->create_time = $time;
            }
            $this->update_time = $time;
            if($this->won == NULL){
                $this->won = 0;
            }
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function getHomeList(){
        $homeList = array();
        $criteria = new CDbCriteria();
        $criteria->addCondition('sid1 = "" OR sid2 = ""');
        $jings = self::model()->findAll($criteria);
        foreach($jings as $jing){
            $jingUrl = Yii::app()->createUrl('games/games/index', array('homeId'=>$jing->id));
            $homeList[$jingUrl] = $jing->id;
        }
        return $homeList;
    }
    
    public function inHome($homeId, $userId){
        $errorNo = self::ERROR_IN_HOME_SUCCESS;
        //消除之前的未完成游戏的该用户记录
        $outHome = $this->outCurentHome($userId, $homeId);
        $jingData = self::model()->findByPk($homeId);
        if($jingData){
            if($jingData->sid1 != $userId && $jingData->sid2 != $userId){
                if(!$jingData->sid1){
                    $jingData->sid1 = $userId;
                }else if(!$jingData->sid2){
                    $jingData->sid2 = $userId;
                }else{
                    //房间人数已满
                    $errorNo = self::ERROR_IN_HOME_FULL;
                }
                $saveOk = $jingData->save();
                if($saveOk){
                    $this->setCurentHomeId($jingData->id);
                }
            }
        }else{
            //房间不存在
            $errorNo = self::ERROR_IN_HOME_NULL;
        }
        
        return array('errorNo'=>$errorNo, 'jingData'=>$jingData);
    }
    
    public function beforeCreate(){
        return $this->deleteLaterHome();
    }

    public function createHome($userId){
        $this->beforeCreate();
        $errorNo = self::ERROR_CREATE_HOME_SUCCESS;
        $jingData = new Jing();
        $game = self::model()->getInitGame();
        $currentData['game'] = $game;
        $jingData->data = json_encode($currentData);
        $jdSave = $jingData->save();
        $inHome = $this->inHome($jingData->id, $userId);
        if(!$jdSave || $inHome['errorNo'] != self::ERROR_IN_HOME_SUCCESS){
            $error = $jingData->getErrors();
            //创建房间存在未知错误
            $errorNo = self::ERROR_CREATE_HOME_UNKOWN;
        }
        $jingData = $inHome['jingData'];
        
        return array('errorNo'=>$errorNo, 'jingData'=>$jingData);
    }
    
    public function getCurentHomeId(){
        $session = Yii::app()->session;
        if(!isset($session['jing_curentHome'])){
            $this->setCurentHomeId(0);
        }
        return $session['jing_curentHome'];
    }
    
    public function setCurentHomeId($homeId){
        $session = Yii::app()->session;
        $session['jing_curentHome'] = $homeId;
    }

    public function initHomeId(){
        $this->setCurentHomeId(0);
    }

    public function getCurentHome($userId){
        $errorNo = self::ERROR_CREATE_HOME_SUCCESS;
        $criteria = new CDbCriteria();
        $criteria->addCondition('sid1 = :sid OR sid2 = :sid');
        $criteria->params[':sid'] = $userId;
        $jingData = Jing::model()->findByPk($this->getCurentHomeId(), $criteria);
        if(!$jingData){
            $this->initHomeId();
            //获取当前房间存在未知错误
            $errorNo = self::ERROR_CURENT_HOME_UNKOWN;
        }
        
        return array('errorNo'=>$errorNo, 'jingData'=>$jingData);
    }
    
    /**
     * 推出当前的游戏
     * $expHomeid  排除的房间id
     * @param type $userId
     */
    public function outCurentHome($userId, $expHomeId){
        $outOk = FALSE;
        $curentHome = $this->getCurentHome($userId);
        if($curentHome['errorNo'] == self::ERROR_CURENT_HOME_SUCCESS){
            $upHome = $curentHome['jingData'];
            if($expHomeId != $upHome->id){
                $outOk = $this->outHome($upHome->id, $userId);
            }
        }
        return $outOk;
    }
    
    public function outHome($homeId, $userId){
        $outOk = FALSE;
        $home = self::model()->findByPk($homeId);
        if($home && $home->won == 0){
            if($home->sid1 == $userId){
                $home->sid1 = '';
                $outOk = $home->save();
            }elseif($home->sid2 == $userId){
                $home->sid2 = '';
                $outOk = $home->save();
            }else{
                //房间里没有当前用户的记录
            }
            //删除无人的房间
            if($outOk){
                $deleteOk = $this->deleteHome($home);
            }
        }
        return $outOk;
    }
    
    public function deleteHome($home){
        $deleteOk = FALSE;
        $s1 = $home->sid1 ? 1 : 0;
        $s2 = $home->sid2 ? 1 : 0;
        if(!$s1 && !$s2 && $home->won == 0){
            $deleteOk = $home->delete();
        }
        return $deleteOk;
    }
    
    public function deleteLaterHome(){
        $deleteCount = 0;
        $homes = $this->getLaterHome();
        foreach($homes as $home){
            if($home->delete()){
                $deleteCount++;
            }
        }
        return $deleteCount;
    }
    
    public function getLaterHome(){
        $time = time() - (3600 * 2);
        $criteria = new CDbCriteria();
        $criteria->addCondition('update_time < :time AND won = "0"', 'OR');
        $criteria->addCondition('sid1 = "" AND sid2 = "" AND won = "0"', 'OR');
        $criteria->params[':time'] = $time;
        $homes = Jing::model()->findAll($criteria);
        return $homes;
    }
    
    public function hasChange($home, $time){
        return $time < $home->update_time;
    }
    
    public function setWon($userId){
        $userId = $this->beforeSetWon($userId);
        $setWon = FALSE;
        if($this->won == 0){
            $this->won = $userId;
            $setWon = $this->save();
        }
        
        return $setWon;
    }
    
    public function beforeSetWon($userId){
        return $this->toRealUser($userId);
    }
    
    public function toRealUser($userId){
        if(in_array($userId, array(1,2))){
            $field = 'sid'.$userId;
            $realUserId = $this->$field;
            $userId = $realUserId ? $realUserId : $userId;
        }
        
        return $userId;
    }
}