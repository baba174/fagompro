<?php
$query = $_POST['query'];

if(isset($_POST['query']))
{
	$servername = "localhost";
$dbuser = "statuser";
$dbpass = "statuser";
$database = "qlikstatdb";
$conn = mysql_connect($servername,$dbuser,$dbpass);
$dbconn = mysql_select_db($database);




$search_q = mysql_query("select * from question_list where ques_tagline like '%{$query}%'");
$res = '';
while($row = mysql_fetch_array($search_q,MYSQL_ASSOC)){
	$redirect = "window.location.href='quesdetail.php'";
	$res = $res."<div id='ques_search_list' onclick=".$redirect.">".$row['ques_tagline']."</div>";
}
echo $res;
}
else{
	echo '';
}




?>