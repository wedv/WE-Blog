<h1>登陆</h1>

<p>请将你的登录凭证填写到下面的表格：</p>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation' => true,
    ));
    ?>

    <p class="note">带有 <span class="required">*</span> 的是必填项.</p>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username'); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row rememberMe">
        <?php echo $form->checkBox($model, 'rememberMe'); ?>
        <?php echo $form->label($model, 'rememberMe'); ?>
        <?php echo $form->error($model, 'rememberMe'); ?>
    </div>

    <div class="row submit">
    <?php echo CHtml::submitButton('登陆'); ?>
    <?php echo CHtml::link(CHtml::image('http://qzonestyle.gtimg.cn/qzone/vas/opensns/res/img/Connect_logo_7.png','qq登录'),array('site/qqLogin')); ?>
    </div>

<?php $this->endWidget(); ?>
</div><!-- form -->