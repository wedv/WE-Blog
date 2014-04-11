<?php
///*替换为你自己的数据库名*/
$dbname = 'gviMxaHHvsNuKQNUbACN';
/*填入数据库连接信息*/
$host = 'sqld.duapp.com';
$port = 4050;
$user = '4UP1kT04HmMfbUfQR5N3Z9Wl';//用户名(api key)
$pwd = 'ENXBPSvIK04ot5jrdN97SxBHfsNBbyPs';//密码(secret key)
/*以上信息都可以在数据库详情页查找到*/
// 
///*接着调用mysql_connect()连接服务器*/
//$link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
//if(!$link) {
//    die("Connect Server Failed: " . mysql_error());
//}
///*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
//if(!mysql_select_db($dbname,$link)) {
//    die("Select Database Failed: " . mysql_error($link));
//}
// 
///*至此连接已完全建立，就可对当前数据库进行相应的操作了*/
////创建一个数据库表
$sql = "create table if not exists test_mysql(
		id int primary key auto_increment,
		no int, 
		name varchar(1024),
		key idx_no(no))";
//$ret = mysql_query($sql, $link);
//if ($ret === false) {
//	die("Create Table Failed: " . mysql_error($link));
//} else {
//	echo "Create Table Succeed<br />";
//}	
// 
// 
///*显式关闭连接，非必须*/
//mysql_close($link);
//
//die;
$connectionString = "mysql:host={$host};port={$port};dbname={$dbname}";

try {
$dbh = new PDO($connectionString, $user, $pwd, array( PDO::ATTR_PERSISTENT => false));

$stmt = $dbh->prepare("CALL getname()");

// call the stored procedure
$stmt->execute();

echo "<B>outputting...</B><BR>";
$query = 'Select * from `ttt_post`';
$a = $dbh->exec($query);
var_dump($a);
var_dump($dbh);
while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
echo "output: ".$rs->name."<BR>";
}
echo "<BR><B>".date("r")."</B>";

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
