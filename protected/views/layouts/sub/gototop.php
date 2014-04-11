<style>
    #gototop{width:80px;height:60px;background:url('<?php echo Yii::app()->baseUrl; ?>/images/top.png') 0px 0px no-repeat;position:fixed;right:5px;bottom:5px;cursor:pointer;}
    #gototop:hover{background:url('<?php echo Yii::app()->baseUrl; ?>/images/top.png') 0px -61px no-repeat;}
</style>
<div style='display:none;' id="gototop" title="回到顶部" onclick="$('html, body').animate({scrollTop: '0px'},600);"></div>
<script>
    $("#gototop").click(function(){
        $("html, body").animate({scrollTop: "0px"},600);
    })
    window.onscroll=function(){ 
 		var a=getPageScroll()
 		if(a>600){
          	$("#gototop").show()
 		}else{
          	$("#gototop").hide()
 		}
	}
    function getPageScroll(){ 
		var yScroll; 
		if (self.pageYOffset) { 
			yScroll = self.pageYOffset; 
        //xScroll = self.pageXOffset; 
		} else if (document.documentElement && document.documentElement.scrollTop){ 
			yScroll = document.documentElement.scrollTop; 
		} else if (document.body) { 
			yScroll = document.body.scrollTop; 
		} 
		//arrayPageScroll = new Array('',yScroll)
		return yScroll; 
	}
</script>