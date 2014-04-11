<?php

class SiteController extends Controller {

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * 时间轴
     */
    public function actionIndex() {
        $this->pageTitle = 'WE Blog -' . $this->pageDescription;
      $criteria = new CDbCriteria();
      $criteria->compare('type',Tmp::WWW_INDEX);
      $criteria->order = 'id desc';
      $tmp = Tmp::model()->find($criteria);
      if (!$tmp || $tmp->ctime + 3600*24*7 < time()) {
        if (Post::model()->updateTimeLine()) {
          
        $tmp = Tmp::model()->find($criteria);
          //echo '刷新后显示';
        } else {
          echo '更新出错了';
          Yii::app()->end();
        }
      }
      $content = $tmp->content;
      $this->renderText($content);
      /**
        $f = Yii::app()->cache;
        if (!isset($f['timeLine'])) {
            $f['timeLine'] = '';
            Post::model()->updateTimeLine();
        }
        $this->renderText($f['timeLine']);
*/
        /**
         * 默认的页面，后修改为读取缓存（Post::model()->updateTimeLine()更新缓存）
        $this->pageTitle = 'WE Blog' . $this->pageTitle;
        $criteria = new CDbCriteria(array(
                    'condition' => 'status=' . Post::STATUS_PUBLISHED,
                    'order' => 'update_time DESC',
                    'with' => 'commentCount',
                ));
        if (isset($_GET['tag']))
            $criteria->addSearchCondition('tags', $_GET['tag']);
        
        $dataProvider = Post::model()->findAll($criteria);

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
         */
    }

    /**
     * 宠物dog挂件
     */
    public function actiondog() {
        $this->layout = FALSE;
        $aaa = '<div style="width:40px;height:40px;position:fixed;top:0px;left:0px;z-index:9999;"></div><object type="application/x-shockwave-flash" style="outline:none;" data="http://hosting.gmodules.com/ig/gadgets/file/102399522366632716596/dog.swf?" width="300" height="225"><param name="movie" value="http://hosting.gmodules.com/ig/gadgets/file/102399522366632716596/dog.swf?"></param><param name="AllowScriptAccess" value="always"></param><param name="wmode" value="opaque"></param><param name="bgcolor" value="FFFFFF"/></object>';
        echo $aaa;
    }

    public function actionContact() {
        $this->pageTitle = '联系我们' . $this->pageTitle;
        $this->breadcrumbs = array(
            '联系我们',
        );
        $model = new ContactForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'form-validate') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    public function actionqqLogin() {
        Yii::app()->user->returnUrl = Yii::app()->request->urlReferrer;
        $this->layout = FALSE;
        $qc = new QC();
        $qc->qq_login();
    }

    public function actionqqLoginOk() {
        $this->layout = FALSE;
        $qc = new QC();
        $q = $qc->qq_callback();
        $qId = $qc->get_openid();
        $identity = new QUserIdentity($qId,$q);
        $identity->authenticate();
        if ($identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = 3600 * 24 * 30; // 30 days
            Yii::app()->user->login($identity, $duration);
        }
        $this->redirect(Yii::app()->user->returnUrl);
        Yii::app()->end();
    }

    public function actionLogin() {
        $this->pageTitle = '登陆' . $this->pageTitle;
        $this->breadcrumbs = array(
            '登陆',
        );
//        if (!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
//            throw new CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new LoginForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
    
    public function actionA() {
    	$a = We::judgeInServiceByIp('1.1.12.1');
    	echo $a;die;
	$file = fopen ("http://www.baidu.com/", "r");
	if (!$file) {
	    echo "<p>Unable to open remote file.\n";
	    exit;
	}
	while (!feof ($file)) {
	    $line = fgets ($file, 1024);
	    /* This only works if the title and its tags are on one line */
	    if (eregi ("<title>(.*)</title>", $line, $out)) {
	        $title = $out[1];
	        break;
	    }
	}
	fclose($file);
    }

}