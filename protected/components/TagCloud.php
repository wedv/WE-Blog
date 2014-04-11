<?php

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CPortlet {

    public $title = '标签';
    public $maxTags = 100;

    protected function renderContent() {
        $tags = Tag::model()->findTagWeights($this->maxTags);

        foreach ($tags as $tag => $weight) {
            $link = CHtml::link(CHtml::encode($tag), array('post/index', 'tag' => urlencode($tag)));
            echo CHtml::tag('span', array(
                'class' => 'tag',
                'style' => "font-size:{$weight}pt",
            ), $link) . "\n";
        }
    }

}