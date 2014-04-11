<ul>
    <?php foreach ($this->getRecentComments() as $comment): ?>
        <li><?php echo $comment->authorLink; ?> 评论了
            <?php echo CHtml::link(CHtml::encode($comment->post->title), $comment->getUrl()); ?>
        </li>
    <?php endforeach; ?>
</ul>