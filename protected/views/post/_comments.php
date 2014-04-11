<?php foreach ($comments as $comment): ?>
    <div class="comment" id="c<?php echo $comment->id; ?>">

        <?php
        echo CHtml::link("#{$comment->id}", $comment->getUrl($post), array(
            'class' => 'cid',
            'title' => '这个评论的链接锚点',
        ));
        ?>

        <div class="author">
            <?php echo $comment->authorLink; ?> 说:
        </div>

        <div class="time">
            <?php echo date('Y-m-d H:i:s', $comment->create_time); ?>
        </div>

        <div class="content">
            <?php echo nl2br(CHtml::encode($comment->content)); ?>
        </div>

    </div><!-- comment -->
<?php endforeach; ?>