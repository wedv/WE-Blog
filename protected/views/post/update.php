<?php
$this->breadcrumbs = array(
    $model->title => $model->url,
    '修改文章',
);
?>

<h1>修改 <i><?php echo CHtml::encode($model->title); ?></i></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>