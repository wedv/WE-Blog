<style>
    .right {width:321px;height:246px;float: right;position:fixed;right:0px;bottom:0px;}
</style>
<div class="right">
    <iframe id="dog" style="width: 320px;height: 245px;" src=""></iframe>
</div>
<script>
    setTimeout(function() {
        $('#dog').attr('src', '<?php echo Yii::app()->createUrl('site/dog'); ?>');
    },
    5000)
</script>