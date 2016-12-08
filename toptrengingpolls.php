<?php

if(!isset($_SESSION['user_email']))
{
	header('Location: index.php');
}
/*&$servername = "localhost";
$dbuser = "statuser";
$dbpass = "statuser";
$database = "qlikstatdb";
$conn = mysql_connect($servername,$dbuser,$dbpass);
$dbconn = mysql_select_db($database);*/

	$quesdata = array();
	
	$query_total_votes = mysql_query("SELECT SUM(opt_value) AS 'opt_value',ques_id_opt FROM options_dtl GROUP BY ques_id_opt");

	WHILE($value = mysql_fetch_array($query_total_votes,MYSQL_ASSOC)){
		$quesdata[$value['ques_id_opt']] = $value['opt_value'];
	}

	//arsort($quesdata);




?>