<ul>
    <li><?php echo CHtml::link('添加文章', array('post/create')); ?></li>
    <li><?php echo CHtml::link('管理文章', array('post/admin')); ?></li>
    <li><?php echo CHtml::link('待审核评论', array('comment/index')) . ' (' . Comment::model()->pendingCommentCount . ')'; ?></li>
    <li><?php echo CHtml::link('登出', array('site/logout')); ?></li>
</ul>