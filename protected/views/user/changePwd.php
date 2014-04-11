<?php
if (Yii::app()->user->hasFlash('cresult')) {
    $result = Yii::app()->user->getFlash('cresult');
    echo '<script>alert("' . $result . '");location.href="' . $this->createUrl('user/changePwd') . '"</script>';
}
?>
<h1>修改密码</h1>

<p>填写并提交下面的表单将修改您的密码:</p>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'form-validate',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <p class="note">带有 <span class="required">*</span> 的是必填项.</p>

    <div class="row">
        <?php echo $form->labelEx($model, 'password_current'); ?>
        <?php echo $form->passwordField($model, 'password_current'); ?>
        <?php echo $form->error($model, 'password_current'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'password_new'); ?>
        <?php echo $form->passwordField($model, 'password_new'); ?>
        <?php echo $form->error($model, 'password_new'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'password_repeat'); ?>
        <?php echo $form->passwordField($model, 'password_repeat'); ?>
        <?php echo $form->error($model, 'password_repeat'); ?>
    </div>
    <div class="row submit">
        <?php echo CHtml::submitButton('确定修改');?>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>