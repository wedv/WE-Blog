    <?php if(Yii::app()->user->hasFlash('won')){echo '<script>alert("'.Yii::app()->user->getFlash('won').'");</script>';} ?>
    <div id="jing_title" class="title <?php echo $won ? 'won' : ''; ?>">红方：<?php echo in_array($sitDown, array(1,3)) ? '就位' : '空缺'; ?> | 绿方：<?php echo in_array($sitDown, array(2,3)) ? '就位' : '空缺'; ?>
        <br>
        桌号：<?php echo $homeId; ?> | 我是<?php echo $user == 1 ? '红方' : '绿方'; ?>
        <br>
        <?php $sow = $won == 0 && $sitDown == 3; ?>
        <?php echo $sow ? '当前走棋：' : ''; ?><marquee scrollamount="2" class="shan" direction=left><?php if(in_array($won, array(0,-1))){if($won == -1){echo '和棋';}else{if($sow){echo $stats['user'] == 1 ? '<i class="redf shan">★★★</i>' : '<i class="greenf shan">★★★</i>';}else{echo '<i class="shan">等待开始</i>';}}}else{echo $woner = $won == 1 ? '红方胜利！' : '绿方胜利！';} ?></marquee>
        <span id="dropDown"></span>
    </div>
    <?php if($won){

    } ?>
    <div style="display: none;">
        <form action="" method="post">
        <input type="hidden" name="pos" id="pos" value="">
        <input type="hidden" name="mpos" id="mpos" value="">
        <input type="hidden" name="restart" id="restart" value="">
        <?php
            echo $stats['user'] == $user ? '<input onclick="subClick();return false;" type="submit" name="submit" id="submit" value="">' : '';
        ?>
        </form>
    </div>
    <div class="map">
    <?php $lastWay = '';$showLastWay = 0; ?>
    <?php if(Yii::app()->user->hasFlash('lastWay')){$lastWay = explode(',', Yii::app()->user->getFlash('lastWay'));}?>
    <?php foreach($stats['map'] as $mkey => $maps): ?>
    <?php foreach($maps as $mk => $map): ?>
    <?php $oneWon = $stats['wonMap'][$mkey][$mk] > 0; ?>
    <table class="<?php echo $onWay[$mkey][$mk] > 0 && $won <= 0 ? 'onWay' : ''; ?>">
        <?php foreach ($map as $key => $value) : ?>
        <tr>
            <?php foreach ($value as $k => $v) : ?>
            <?php if($lastWay && $lastWay[0] == $mkey && $lastWay[1] == $mk && $lastWay[2] == $key && $lastWay[3] == $k){$showLastWay = 1;} ?>
            <td class="<?php echo $showLastWay ? 'lastWay' : ''; $showLastWay = 0;?> <?php echo $v || $won || $oneWon ? '' : (($stats['user'] == $user) ? 'empty' : ''); ?> <?php if($v == 1){echo 'red';} if($v==2){echo 'green';}?>" <?php echo $v || $won || $oneWon || $onWay[$mkey][$mk] <= 0 ? "" : 'onclick=action("'.$key.','.$k.'",'.'"'.$mkey.','.$mk.'",$(this),'.$user.')'; ?>>
            </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endforeach; ?>
    <?php endforeach; ?>
        <div class="shuoming"></div>

        <?php if(Yii::app()->user->hasFlash('homeList')){echo '<script>alert("'.Yii::app()->user->getFlash('homeList').'");</script>';} ?>
        <?php if($homeList){ ?>
        <div class="waitting">
            <div class="map_top">
                <div class="center">
                    <?php
                        $close = <<<eof
                    <samp class="close" onclick="$('.waitting').hide()">x</samp>
eof;
                        echo $sitDown == 3 ? $close : '';
                    ?>
                    <?php echo CHtml::link('新建游戏', 'javascript:;', array('class'=>'box','onclick'=>'newJing()')) ?>
                    <br><br><br>
                    <?php echo CHtml::dropDownList('homeList', '', $homeList, array('empty'=>'选择桌号')); ?>
                    <?php echo CHtml::link('进入', 'javascript:;', array('class'=>'box','onclick'=>'inHome()')); ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>