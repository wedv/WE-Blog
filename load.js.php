<?php
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    $params = substr($uri, strpos($uri, '?'));
?>
$().ready(function(){
alert('start');
$.ajax({
  type: "GET",
  url: "http://duapp3/post/index.html",
  dataType: "jsonp",
  success: function(data){
    $('#jsonp_div').html(data.output)
  }
});
alert('end');
});