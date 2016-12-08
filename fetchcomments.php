<?php
$servername = "localhost";
$dbuser = "statuser";
$dbpass = "statuser";
$database = "qlikstatdb";
$conn = mysql_connect($servername,$dbuser,$dbpass);
$dbconn = mysql_select_db($database);

$quesid = $_POST['quesid'];
$query = mysql_query("SELECT comment_id,comment_desc,ques_id,A".".user_id,user_name FROM comments_dtl A
						JOIN qlik_user_info B ON A."."user_id = B.user_id where ques_id = {$quesid}");

//$row = mysql_fetch_array($userid_query,MYSQL_ASSOC);
$res = " ";
while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
	$res = $res."<div id='comment'>";
	$res = $res.'<div id="user_details">
				<div id="profile_pic"><img src="../images/background_img.jpg"id="pic_profile"></div>
				<div id="username">'.$row['user_name'].'</div>
					<div id="postedtime">8 hrs</div>
			</div>';
	$res = $res.'<div id="commentdtl">'.$row['comment_desc']."</div>";
	$res = $res."</div>";
}
echo $res;

?>