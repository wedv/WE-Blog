<div id="mainmenu">
    <style>
        .mMenu{
            z-index: 99999;
            text-align: center;
            height:26px;
            position:fixed;
            top:-12px;
            cursor:pointer;
            padding: 21px 5px 0px;
        }
    </style>
    <?php
	$qqUserImg = '';
	if (!Yii::app()->user->isGuest && isset(Yii::app()->user->qqUserInfo)) {
		$qqUserImg = '<img src="' . Yii::app()->user->qqUserInfo['figureurl'] .'" style="border:2.5px solid grey;margin:0 4px;vertical-align: middle;" />';
	}
    $this->widget('zii.widgets.CMenu', array(
        'itemCssClass' => 'mMenu',
        'encodeLabel'=>FALSE,   //下面有个图片，所以此处需要设置为false
        'items' => array(
            array('label' => '时间轴', 'url' => array('site/index'), 'itemOptions' => array('style' => 'left:210px;')),
            array('label' => '博文', 'url' => array('post/index'), 'itemOptions' => array('style' => 'left:272px;')),
            array('label' => '#字游戏', 'url' => array('games/games'), 'itemOptions' => array('style' => 'left:322px;'), 'linkOptions' => array('target' => '_blank')),
            array('label' => '想听歌', 'url' => '/mp3.html', 'itemOptions' => array('style' => 'left:392px;'), 'linkOptions' => array('target' => '_blank')),
            array('label' => '修改密码', 'url' => array('user/changePwd'), 'visible' => !Yii::app()->user->isGuest, 'itemOptions' => array('style' => 'left:446px;')),
            array('label' => '添加文章', 'url' => array('post/create'), 'visible' => !Yii::app()->user->isGuest, 'itemOptions' => array('style' => 'left:520px;')),
            array('label' => '管理文章', 'url' => array('post/admin'), 'visible' => Yii::app()->user->name == 'admin', 'itemOptions' => array('style' => 'right:211px;')),
            array('label' => '更新时间轴', 'url' => array('user/reTimeLine'), 'visible' => Yii::app()->user->name == 'admin', 'itemOptions' => array('style' => 'right:111px;')),
            array('label' => '登陆', 'url' => array('site/login'), 'visible' => Yii::app()->user->isGuest, 'itemOptions' => array('style' => 'right:5px;')),
            array('label' => '<img alt="QQ登录" src="http://qzonestyle.gtimg.cn/qzone/vas/opensns/res/img/Connect_logo_7.png" />', 'url' => array('site/qqLogin'), 'visible' => Yii::app()->user->isGuest, 'itemOptions' => array('id'=>'qqlogin','style' => 'right:55px;z-index:9991;')),
          array('label' => '退出 (' . $qqUserImg . Yii::app()->user->name . ')', 'url' => array('site/logout'), 'visible' => !Yii::app()->user->isGuest, 'itemOptions' => array('style' => 'right:5px;')),
        ),
    ));
    ?>
</div><!-- mainmenu -->
<script>
    $(".mMenu").hover(function(){
        $(this).stop(true, true).animate({"top":"0px"},350);

    },function(){
        $(this).stop(true, true).animate({"top":"-12px"},250);
    });
</script>