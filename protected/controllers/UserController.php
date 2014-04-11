<?php

class UserController extends Controller {

  //public $layout='column1';
    /**
     * 权限访问控制过滤
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * 访问控制规则
     * 在filters里面用accessControl来调用
     */
    public function accessRules() {
        return array(
            array('allow', // 注册用户可以访问
                'actions' => array(
                    'changePwd',
                ),
                'users' => array('@'),
            ),
            array('allow', // 只有帐号为 demo 的用户可以访问
                'actions' => array('changePwd','view','admin','index','create','delete','update','reTimeLine'),
                'users' => array('admin'),
            ),
            array('deny', // 禁用其他情况下的所有用户
                'users' => array('*'),
            ),
        );
    }

    /**
     * 修改密码
     */
    public function actionChangePwd() {
        $this->pageTitle = '修改密码' . $this->pageTitle;
        $this->breadcrumbs = array(
            '修改密码',
        );
      //$model = new User();
      //if (isset($_POST['User']['password_new'])) {
            $model = User::model()->findByPk(Yii::app()->user->id);
          if (!$model) {
            $this->redirect(array('site/index'));
            Yii::app()->end();
          }
      //}
        $model->scenario = 'resetPwd';
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'form-validate') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['User']['password_new']) && isset($_POST['User']['password_current'])) {
            $result = '';
            $model->attributes = $_POST['User'];
            if ($model->validate(array('password_new', 'password_current', 'password_repeat'))) {
                $saveOk = $model->saveAttributes(array('password' => md5($_POST['User']['password_new'])));
                if ($saveOk) {
                    $result = "修改密码成功！";
                } else {
                    $result = "修改密码失败！";
                }
            } else {
                $result = "信息输入有误！";
            }
            Yii::app()->user->setFlash('cresult', $result);
        }
        $this->render('changePwd', array('model' => $model));
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new User('add');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->validate()) {
                if ($model->save())
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'add';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->validate()) {
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionReTimeLine(){
        Post::model()->updateTimeLine();
        Yii::app()->user->setFlash('reTimeLine','时间轴更新成功！跳转到时间轴页面。');
        $this->redirect(array('site/index'));
    }

}