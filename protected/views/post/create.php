<?php
$this->breadcrumbs = array(
    '添加文章',
);
?>
<h1>添加文章</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>