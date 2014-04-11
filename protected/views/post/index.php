<?php if (!empty($_GET['tag'])): ?>
    <h1>所有带有标签 * <i><?php echo CHtml::encode(urldecode($_GET['tag'])); ?></i> * 的文章</h1>
<?php endif; ?>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'ajaxUpdate'=> false,//这样就不会AJAX翻页(页面中有js:onload函数时，ajax不会触发此函数，所以弃用ajax翻页)
    'template' => "{items}\n{pager}",
));
?>
