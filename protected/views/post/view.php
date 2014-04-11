<?php
$this->breadcrumbs = array(
    $model->title,
);
$this->pageTitle = $model->title . $this->pageTitle;
?>

<?php
$this->renderPartial('_view', array(
    'data' => $model,
));
?>

<div id="comments">
    <?php if ($model->commentCount >= 1): ?>
        <h3>
            <?php echo $model->commentCount . ' 条评论'; ?>
        </h3>

        <?php
        $this->renderPartial('_comments', array(
            'post' => $model,
            'comments' => $model->comments,
        ));
        ?>
    <?php endif; ?>

    <h3>留下您的评论</h3>

    <?php if (Yii::app()->user->hasFlash('commentSubmitted')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
        </div>
    <?php else: ?>
        <?php
        $this->renderPartial('/comment/_form', array(
            'model' => $comment,
        ));
        ?>
    <?php endif; ?>

</div><!-- comments -->
