<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
    </div>
    <div class="author">
        作者：<?php echo $data->author->username . ' ----- 时间：' . date('Y-m-d H:i:s', $data->create_time); ?>
    </div>
    <div class="content">
        <?php
//        $this->beginWidget('CMarkdown', array('purifyOutput' => true));
        echo $data->content;
//        $this->endWidget();
        ?>
    </div>
    <div class="nav">
        <b>标签:</b>
        <?php echo implode(', ', $data->tagLinks); ?>
        <br/>
        <?php echo CHtml::link('固定链接', $data->url); ?> |
        <?php echo CHtml::link("评论 ({$data->commentCount})", $data->url . '#comments'); ?> |
        最后更新于 <?php echo date('Y-m-d H:i:s', $data->update_time); ?>
    </div>
</div>
