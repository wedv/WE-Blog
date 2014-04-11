<?php
$this->breadcrumbs = array(
    'Comments' => array('index'),
    '修改评论 #' . $model->id,
);
$this->pageTitle = '修改评论' . $this->pageTitle;
?>

<h1>修改评论 #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>