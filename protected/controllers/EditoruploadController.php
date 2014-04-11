<?php

class EditoruploadController extends CController {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // deny all users
                'users' => array('*'),
            ),
            array('allow', // allow authenticated users to access all actions
                'actions' => array(
                    'fileManageJson',
                    'uploadJson',
                ),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionFileManageJson() {
        Editor::fileManageJson();
    }

    public function actionUploadJson() {
        Editor::uploadJson();
    }

}

?>
