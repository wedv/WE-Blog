<h1>联系我们</h1>

<?php if (Yii::app()->user->hasFlash('contact')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('contact'); ?>
    </div>

<?php else: ?>

    <p>
        如果你有业务查询或其他问题,请填写以下表格与我们联系。 Thank you！
    </p>

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

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name'); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email'); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'subject'); ?>
            <?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128)); ?>
            <?php echo $form->error($model, 'subject'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'body'); ?>
            <?php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'body'); ?>
        </div>

        <?php if (CCaptcha::checkRequirements()): ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'verifyCode'); ?>
                <div>
                    <?php $this->widget('CCaptcha', array('showRefreshButton' => FALSE, 'clickableImage' => TRUE, 'imageOptions' => array('title' => '点击刷新'))); ?>
                    <?php echo $form->textField($model, 'verifyCode', array('title' => '请输入验证码')); ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="row submit">
            <?php echo CHtml::submitButton('提交'); ?>
        </div>

        <?php
        $this->endWidget();
        ?>

    </div><!-- form -->

<?php endif; ?>