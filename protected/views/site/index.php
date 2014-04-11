<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/history.css");
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js',CClientScript::POS_END);
?>
<div class="head-warp">
  <div class="head">
    <div class="nav-box">
      <ul>
        <li class="cur" style="text-align:center; font-size:62px; font-family:'微软雅黑', '宋体';"></li>
      </ul>
    </div>
  </div>
</div>
<div class="main">
    <div class="history">
        <?php
            $year = '';
            if (!empty($dataProvider)) {
            $count = count($dataProvider);
            foreach($dataProvider as $key => $data) {
        ?>
        
            <?php
                $i = 0; //是否是新的一年
                $last = (($key+1) == $count);
                if ($year != date('Y-m',$data->update_time)) {
                    $i++;
                    $year = date('Y-m',$data->update_time);
                    //如果是新的一年，而且这不是第一条数据
                    if ($i && $key) {
                        echo '</ul></div>';
                    }
            ?>
                        <div class="history-date">
                            <ul>
                                <h2 class="first" style="position: relative;">
                                    <a href="javascript:;"><?php echo $year; ?></a>
                                </h2>
            <?php
                }
            ?>
                
                              <li class="green bounceInDown" style="margin-top: 0px; -webkit-animation: 2s ease 0ms both; display: <?php echo $i > 1 ? 'none' : 'list-item';//只显示当前这一年的数据 ?>">
                    <h3 style="display: block;"><?php echo date('Y-m-d H:i:s', $data->update_time); ?></h3>
                    <dl style="display: block;">
                        <dt>
                            <a href="<?php echo $data->url; ?>" title="<?php echo $data->title; ?>" target="_blank" class="f20"><?php echo We::wsubstr($data->title, 0, 41); ?></a>
                            <span><?php echo $data->author->username.(($data->update_time != $data->create_time)?'修改':'创建').'了此文章'; ?></span>
                            <span style="width: 488px;">
                            <?php
                                echo We::wsubstr(strip_tags($data->content),0,599);
                            ?>
                            </span>
                        </dt>
                    </dl>
                </li>
        <?php
            $i = 0;
            }
            }
            if (($key+1) == $count) {
                echo '</ul></div>';
            }
        ?>
    </div>
</div>

<!--<a href="'.$row['CODE'].'" target="_blank"><div id="weibo_tencent" class="weibo" title="腾讯微博" style="left: -112px;"></div></a>
<a href="'.$row['CODE'].'" target="_blank"><div id="weibo_sina" class="weibo" title="新浪微博" style="left: -112px;"></div></a>-->
