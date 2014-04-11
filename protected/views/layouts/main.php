<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang='zh-CN' xml:lang='zh-CN' xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <?php $this->renderPartial('../layouts/sub/style') ;?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php $this->renderPartial('../layouts/sub/baiduhm') ;?>
        <?php $this->renderPartial('../layouts/sub/syntaxlh') ;?>
    </head>
    <body style="padding-top:31px;">
        <div id="header" style="color: red;z-index:9990;width:100%;position: fixed;top: -4px;height:50px;background: url('<?php echo Yii::app()->baseUrl; ?>/images/bg_header.png') repeat-x;">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
        </div><!-- header -->
        <?php $this->renderPartial('../layouts/sub/menu') ;?>
        <div class="container" id="page">
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
            ));
            ?><!-- breadcrumbs -->
            
            <?php echo $content; ?>

            <?php $this->renderPartial('../layouts/sub/foot') ;?>
        </div><!-- page -->
        <?php $this->renderPartial('../layouts/sub/gototop') ;?>
      <?php //$this->renderPartial('../layouts/sub/dog') ;?>
        <?php if(Yii::app()->user->isGuest){ //屏蔽免费空间广告--start-- ?>
        <div id='app_end_div'></div>
        <script>
            setInterval(function(){$("#app_end_div").nextAll().html('').hide();}, 200);
        </script>
        <?php } //屏蔽免费空间广告--end-- ?>
    </body>
</html>