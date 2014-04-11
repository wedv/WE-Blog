<?php
$deleteJS = <<<DEL
$('.container').on('click','.time a.delete',function() {
	var th=$(this),
		container=th.closest('div.comment'),
		id=container.attr('id').slice(1);
	if(confirm('Are you sure you want to delete comment #'+id+'?')) {
		$.ajax({
			url:th.attr('href'),
			type:'POST'
		}).done(function(){container.slideUp()});
	}
	return false;
});
DEL;
Yii::app()->getClientScript()->registerScript('delete', $deleteJS);
?>
<div class="comment" id="c<?php echo $data->id; ?>">

    <?php
    echo CHtml::link("#{$data->id}", $data->getUrl($data->post), array(
        'class' => 'cid',
        'title' => 'Permalink to this comment',
    ));
    ?>

    <div class="author">
        <?php echo $data->authorLink; ?> 评论了
        <?php echo CHtml::link(CHtml::encode($data->post->title), $data->post->url); ?>
    </div>

    <div class="time">
        <?php if ($data->status == Comment::STATUS_PENDING): ?>
            <span class="pending">未批准</span> |
            <?php
            echo CHtml::linkButton('批准', array(
                'submit' => array('comment/approve', 'id' => $data->id),
            ));
            ?> |
        <?php endif; ?>
        <?php echo CHtml::link('修改', array('comment/update', 'id' => $data->id)); ?> |
        <?php echo CHtml::link('删除', array('comment/delete', 'id' => $data->id), array('class' => 'delete')); ?> |
        <?php echo date('Y-m-d H:i:s', $data->create_time); ?>
    </div>

    <div class="content">
        <?php echo nl2br(CHtml::encode($data->content)); ?>
    </div>

</div><!-- comment -->