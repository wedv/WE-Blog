<h1>管理文章</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'title',
            'header' => '标题',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->title), $data->url)'
        ),
        array(
            'name' => 'status',
            'header' => '状态',
            'value' => 'Lookup::item("PostStatus",$data->status)',
            'filter' => Lookup::items('PostStatus'),
        ),
        array(
            'name' => 'create_time',
            'header' => '创建时间',
            'type' => 'datetime',
            'filter' => false,
        ),
        array(
            'header' => '操作',
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
