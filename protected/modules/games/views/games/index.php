<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<style>
    .title {font-size:12px;border:1px rosybrown double;margin: auto;margin-top: 5px; line-height:20px; width: 360px; text-align: center;border:5px rosybrown double;}
    .map {width: 360px; height:410px;margin: auto;border:5px rosybrown double;margin-top: 10px;}
    .shuoming {background: burlywood;height: 35px;width: 324px; padding: 3px; float: left;border:4px rosybrown double;margin-left: 10px;margin-top: 10px; text-align: center;}
    .won {color: hotpink;}
    table {border:1px rosybrown double;margin-left: 10px;margin-top: 10px;float: left;}
    td {border: 1px double solid;width: 30px;height: 30px;background: burlywood;}
    .shan {width:33px; line-height:14px;font-style: normal;padding: 0px;}
    .redf {color: red;}
    .greenf {color: greenyellow;}
    .bomp {width:70px;}
    .red {background: red;}
    .green {background: greenyellow;}
    .onWay .empty:hover {background: aqua; cursor: pointer;}
    .lastWay{background: aqua;}
    .onWay {border-color: cyan;}
    .center {text-align: center;margin: 10px 10px;}
    .box {border:1px solid #009900;padding:3px;text-decoration: none;background-color:red;color:greenyellow;}
    .waitting {padding-top: 115px;background: rgba(0,0,0,0.5);z-index:10;position:absolute;width:360px;height:295px;filter:Alpha(Opacity=80,Style=1);}
    .map_top {position: absolute;padding-top:30px;width: 250px; height:140px;margin-left:49px;border:5px rosybrown double;background: #fff;}
    .jing_content {width:380px;margin: auto;border:2px goldenrod solid;padding-bottom:5px;background: rgba(127,123,57,0.1);}
    .jing_title {position: absolute;height: 74px;}
    .close {position: absolute;right: 3px; top: 3px;background-color: red; cursor: pointer;width:15px;}
    .quickGo {height:14px;}
</style>
<script>window.getServerTime = <?php echo $renderData['curTime']; ?>;</script>
<input type="hidden" name="hasSubmit" id="hasSubmit" value="0">
<div class="jing_content">
    <?php $this->renderPartial('index_content', $renderData); ?>
</div>
<div id="hide_drop" style="display: none;">
    <?php echo CHtml::dropDownList('quickGo', '', array(
                Yii::app()->createUrl('games/games/index') => '刷新数据',
                Yii::app()->createUrl('games/games/index', array('showHomeList'=>1)) => '选择桌号',
                Yii::app()->createUrl('games/games/index',array('newHome'=>1)) => '新建游戏',
            ),array('onchange'=>'if(!confirm("确认" + $(this).find("option:selected").text() + "？")){$(this).val("");return false;};ereload($(this).val());','empty'=>'快捷操作')
        ); ?>
</div>
<div class="hide_shuoming"  style="display: none;">
<em>玩法：任意三个相同颜色的方块连成一条线即获得胜利。</em>
</div>
<script>
    function showDrop(){
        $('#dropDown').html($('#hide_drop').html());
        $('.shuoming').html($('.hide_shuoming').html());
    }
    
    function inHome(){
        if($("#homeList").val()){window.location.href = $("#homeList").val();}else{alert("还没选择桌号哦！");}
    }
    
    function newJing(){
        window.location.href = "<?php echo Yii::app()->createUrl('games/games/index', array('newHome'=>1)); ?>";
    }
    
    function action($pos,$mpos,$this,$user){
        var hasSubmit = $('#hasSubmit').val()
        if(hasSubmit == 0){
            document.getElementById('pos').value=$pos;
            document.getElementById('mpos').value=$mpos;
            if(document.getElementById('submit')){
                var $class = $user == 1 ? 'red' : 'green';
                $this.addClass($class);
                document.getElementById('submit').click();
            }
        }
    }
    
    function subClick(){
        $pos = $('#pos').val();
        $mpos = $('#mpos').val();
        ereload('<?php echo Yii::app()->createUrl('games/games/index'); ?>',{pos:$pos,mpos:$mpos},'post');
        return false;
    }
    
    function toServer(){
        var curTime = getServerTime
        $.ajax({
            url:'<?php echo Yii::app()->request->url; ?>',
            data:{curTime:curTime},
            cache:false,
            dataType:'jsonp',
            success:function(data){
                if(data.sub == '1'){
                    ereload('<?php echo Yii::app()->createUrl('games/games/index'); ?>');
                    return false;
                }
            }
        });
        setTimeout(function(){toServer()},3000)
    }
    
    function ereload(url){
        $('#hasSubmit').val('1');
        var data = arguments[1] ? arguments[1] : '';
        var type = arguments[2] ? arguments[2] : 'get';
        $.ajax({
            url:url,
            data:data,
            type:type,
            cache:false,
            dataType:'jsonp',
            success:function(data){
                if(data.error_no == 0){
                    getServerTime = data.curTime;
                    $('.jing_content').html(data.data);
                    init();
                }
            }
        });
        $('#hasSubmit').val('0');
        return false;
    }
    
    function init(){
        showDrop()
        lastWay()
    }
    
    function lastWay(){
        var lastClass = 'lastWay';
        var lastWay = $('.' + lastClass);
        if(lastWay.length <= 0){
            return false;
        }
        
        var i = 0;
        var lastw = window.setInterval(function(lastWay, lastClass){
            if((i++)%2 == 0){lastWay.toggleClass(lastClass)}else{lastWay.toggleClass(lastClass)}
            if(i>=9){window.clearInterval(lastw)}
        }, 250, lastWay, lastClass);
    }
    
    $().load(init())
    setTimeout(function(){toServer()},3000)
</script>