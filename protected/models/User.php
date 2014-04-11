<?php

class User extends CActiveRecord {

    public $password_new; //新密码
    public $password_repeat; //确认密码
    public $password_current; //当前密码

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{user}}';
    }

    public function rules() {
        return array(
            array('username', 'unique'),
            array('email', 'email'),
            array('username, password, email', 'required'),
            array('username, password, email', 'length', 'max' => 128),
            array('profile', 'safe'),
            array('password_current, password_repeat, password_new', 'required', 'on' => array('resetPwd')),
            array('password_current', 'rulePasswordCurrent', 'on' => array('resetPwd')),
            array('password_repeat', 'compare', 'compareAttribute' => 'password_new', 'message' => '两次密码不一致', 'on' => array('resetPwd')),
            array('password,password_new,password_repeat', 'length', 'min' => 6, 'max' => 20, 'on' => array('resetPwd','add')),
            array('password_new', 'ruleNewPwd', 'on' => 'resetPwd'),
            array('password', 'ruleRegPwd', 'on' => array('add', 'resetPwd')),
            array('id,username, email, password, password_current, password_new, salt, profile', 'safe', 'on' => 'search'),
        );
    }

    protected function beforeSave() {

        if (parent::beforeSave()) {
            if ($this->isNewRecord || $this->getScenario() == 'add') {
                $this->password = $this->hashPassword($this->password);
            }
            return true;
        } else {
            return false;
        }
    }
    public function relations() {
        return array(
            'posts' => array(self::HAS_MANY, 'Post', 'author_id'),
        );
    }

    public function ruleNewPwd() {
        if ($this->validatePassword($this->password_new)) {
            $this->addError('password_new', '新密码不能跟当前密码一样');
        }
    }

    public function rulePasswordCurrent() {
        if (!$this->validatePassword($this->password_current)) {
            $this->addError('password_current', '当前密码不正确');
        }
    }

    public function ruleRegPwd() {
        $pLevel = $this->pwdLevel($this->password);
        if ($pLevel < 2)
            $this->addError('password', '密码太弱，请更换');
    }

    public function pwdLevel($value) {
        $pattern_1 = "/^.*([\W_])+.*$/i";
        $pattern_2 = "/^.*([a-zA-Z])+.*$/i";
        $pattern_3 = "/^.*([0-9])+.*$/i";
        $level = 0;
        if (isset($value[9])) {
            $level++;
        }
        if (preg_match($pattern_1, $value)) {
            $level++;
        }
        if (preg_match($pattern_2, $value)) {
            $level++;
        }
        if (preg_match($pattern_3, $value)) {
            $level++;
        }
        if ($level > 3) {
            $level = 3;
        }
        return $level;
    }

    public function attributeLabels() {
        return array(
            'id' => 'Id',
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
            'profile' => '信息',
            'password_new' => '新密码',
            'password_repeat' => '确认密码',
            'password_current' => '当前密码',
        );
    }

    public function validatePassword($password) {
        return $this->hashPassword($password) === $this->password;
    }

    public function hashPassword($password) {
        return md5($password);
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, TRUE);
        $criteria->compare('username', $this->username, TRUE);
        $criteria->compare('password', $this->password);
        $criteria->compare('password_current', $this->password_current);
        $criteria->compare('password_repeat', $this->password_repeat);
        $criteria->compare('password_new', $this->password_new);
        $criteria->compare('salt', $this->salt);
        $criteria->compare('email', $this->email, TRUE);
        $criteria->compare('profile', $this->profile, TRUE);

        return new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                ));
    }

}