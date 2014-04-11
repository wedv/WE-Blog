<div class="form">

    <?php $form = $this->beginWidget('CActiveForm',array('id'=>'eform')); ?>

    <p class="note">带有 <span class="required">*</span> 的是必填项.</p>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 80, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php echo CHtml::activeTextArea($model, 'content', array('rows' => 10, 'cols' => 70, 'id'=>'editor_id')); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>
    <script src='<?php echo Yii::app()->baseUrl; ?>/js/kindeditor/kindeditor.js'></script>
    <script charset="utf-8" src="<?php echo Yii::app()->baseUrl; ?>/js/kindeditor/lang/zh_CN.js"></script>
    <script>
        KindEditor.ready(function(K) {
            var editor1 = K.create('#editor_id', {
		resizeType : 2,
		urlType: 'domain',
		shadowMode : false,
                height : '600px',
                cssPath : '<?php echo Yii::app()->baseUrl; ?>/css/main.css',
                uploadJson : '<?php echo Yii::app()->createUrl("editorupload/uploadJson"); ?>',
                fileManagerJson : '<?php echo Yii::app()->createUrl("editorupload/fileManageJson"); ?>',
                allowFileManager : true,
                afterCreate : function() {
                    var self = this;
                    K.ctrl(document, 13, function() {
                        self.sync();
                        K('#eform')[0].submit();
                    });
                    K.ctrl(self.edit.doc, 13, function() {
                        self.sync();
                        K('#eform')[0].submit();
                    });
                },
		afterChange : function() {
			this.sync();
		}
            });
        });
    </script>

    <div class="row">
        <?php echo $form->labelEx($model, 'tags'); ?>
        <?php
        $this->widget('CAutoComplete', array(
            'model' => $model,
            'attribute' => 'tags',
            'url' => array('suggestTags'),
            'multiple' => true,
            'htmlOptions' => array('size' => 50),
        ));
        ?>
        <p class="hint">请用逗号分隔不同的标签。</p>
        <?php echo $form->error($model, 'tags'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', Lookup::items('PostStatus')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '修改'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->