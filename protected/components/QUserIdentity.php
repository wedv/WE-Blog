<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class QUserIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $qu = QqUser::model()->findByAttributes(array('openid'=>$this->username));
        if ($qu === null) {
            $qu = new QqUser();
            $qu->openid = $this->username;
            $qu->token = $this->password;
            $qu->save();
        }
        if ($qu === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else {
            $qc = new QC($this->password, $this->username);
            $user = $qc->get_user_info();
            $this->_id = $this->username;
            Yii::app()->user->setState('qqUserInfo',$user);
            $this->username = $user['nickname'];
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

}