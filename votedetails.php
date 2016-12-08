<?php
session_start();
$_SESSION['user_email'] = 'pradhan.subhasis174@gmail.com';
$servername = "localhost";
	$dbuser = "statuser";
	$dbpass = "statuser";
	$database = "qlikstatdb";
	$conn = mysql_connect($servername,$dbuser,$dbpass);
	$dbconn = mysql_select_db($database);
	$ques_id = $_POST['ques_id'];
	$useremail = $_SESSION['user_email'];
if (isset($_POST["vote_radio"])) {
	# code...
	$option_value = $_POST['vote_radio'];
	if($option_value){


	$query = mysql_query("SELECT user_email FROM user_vote_list WHERE ques_id = '{$ques_id}' AND user_email = '{$_SESSION['user_email']}'");

	//$count = mysql_num_rows($query);
	$count = 0;
	if($query)
	{
		/*while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
		$count = $count +1;
		}*/
		$count = mysql_num_rows($query);
	}
	else{
		$count = -1;
	}

	if($count <=0){
		$insert_query = "INSERT INTO user_vote_list(user_email,opt_id,ques_id,user_vote_created_date,user_vote_created_by,
													user_vote_modified_date,user_vote_modified_by)
		VALUES('$useremail','$option_value','$ques_id',now(),'$useremail',now(),'$useremail')";
		$retval = mysql_query($insert_query,$conn);

		$update_query = "UPDATE options_dtl
						 SET opt_value = opt_value + 1
						 WHERE opt_no = $option_value
						 AND ques_id_opt = $ques_id
						";
		$retval = mysql_query($update_query,$conn);

	}
	else{
		$update_red_query = "UPDATE options_dtl A,user_vote_list B
							 SET opt_value = opt_value - 1
							 WHERE ques_id_opt = ques_id
							 AND opt_no = opt_id
							 AND ques_id_opt = '$ques_id'
							 AND user_email = '$useremail'
							 ";

		$retval = mysql_query($update_red_query,$conn);


		$update_query = "UPDATE user_vote_list
						 SET opt_id = '$option_value',
						 	 user_vote_modified_date = now(),
						 	 user_vote_modified_by = '$useremail'
						 WHERE user_email = '$useremail'
						 AND ques_id		= '$ques_id'
						";
		$retval = mysql_query($update_query,$conn);

		$update_red_query = "UPDATE options_dtl A,user_vote_list B
							 SET opt_value = opt_value + 1
							 WHERE ques_id_opt = ques_id
							 AND opt_no = opt_id
							 AND ques_id_opt = '$ques_id'
							 AND user_email = '$useremail'
							 ";

		$retval = mysql_query($update_red_query,$conn);
		
	}

	$query_total_votes = mysql_query("SELECT SUM(opt_value) AS 'opt_value' FROM options_dtl WHERE ques_id_opt = {$ques_id}");

	$value = mysql_fetch_array($query_total_votes,MYSQL_ASSOC);

	$total_votes = $value['opt_value'];

	

	echo "Vote | ".$total_votes;

	

	}

}
else
{
	$query_total_votes = mysql_query("SELECT SUM(opt_value) AS 'opt_value' FROM options_dtl WHERE ques_id_opt = {$ques_id}");

	$value = mysql_fetch_array($query_total_votes,MYSQL_ASSOC);

	$total_votes = $value['opt_value'];

	echo "Vote | ".$total_votes;
}

mysql_close($conn);

?>