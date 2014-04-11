<?php

//线上的debug是关闭的，所以一debug来判断当前是测试环境还是生产环境
//此处是百度统计代码，在测试环境中不输出此段代码
if (!YII_DEBUG) {
    ?>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?75426470f798aa2393b00eb6372c3f95";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <?php

}
?>