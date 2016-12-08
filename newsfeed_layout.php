<html>
<?php
session_start();
/*if(!isset($_SESSION['user_email']))
{
	header('Location: index.php');
}*/
$servername = "localhost";
$dbuser = "statuser";
$dbpass = "statuser";
$database = "qlikstatdb";
$conn = mysql_connect($servername,$dbuser,$dbpass);
$dbconn = mysql_select_db($database);
$_SESSION['user_email'] = 'pradhan.subhasis174@gmail.com';

//$userid_query = mysql_query("SELECT user_id,user_name FROM qlik_user_info WHERE user_email = '{$_SESSION['user_email']}'");
$userid_query = mysql_query("SELECT user_id,user_name FROM qlik_user_info WHERE user_email = 'pradhan.subhasis174@gmail.com'");
$userid_row = mysql_fetch_array($userid_query,MYSQL_ASSOC);
$user_id = $userid_row['user_id'];
$user_name = $userid_row['user_name'];

?>
<title>Newsfeed</title>

<head>
<link rel="stylesheet" type="text/css" href="header.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
</head>

<body>

	<div id="hdrrow">
	<table class="header">
		<tr>
			<td id="quotalink"><a href="#"><div id="leftname">Click</div><div id="rightname">Stats</div></a></td>
			<td id="search_btn"><input type="text" id="search_text" placeholder="Search Question..."></td>
			<td id="postques">POST</td>
			<td id="notification_link">Notifications</td>
			<td id="overflow_btn"><img src="../images/drop1x.png"></td>
		</tr>
	</table>
	</div>
	<div id="hdrrow_mob">
	<table class="header_mob">
		<tr>
			<td id="quotalink"><a href="#"><div id="leftname">C</div><div id="rightname">S</div></a></td>
			<td id="search_btn"><input type="text" id="search_text" placeholder="Search Question..."></td>
		</tr>
	</table>
	</div>
	
	<div id="hdrrow_mob"><table  class="header_mob"><tr>
			<td id="postques">POST</td>
			<td id="notification_link">Notifications</td>
			<td id="overflow_btn"><img src="../images/drop1x.png"></td>
		</tr>
	</table>
	</div>




	<div id="newsfeed">

		<?php
			$query = mysql_query("SELECT DISTINCT ques_id,user_id,ques_tagline,ques_desc,ques_created_date,ques_created_by FROM question_list
											JOIN options_dtl on ques_id = ques_id_opt ORDER BY ques_created_date DESC");


			while($row = mysql_fetch_array($query, MYSQL_ASSOC)){

				$tick_query = mysql_query("SELECT user_email FROM user_vote_list WHERE user_email = '{$_SESSION['user_email']}' 
													AND ques_id = '{$row['ques_id']}'");

						$retval = mysql_fetch_array($tick_query,MYSQL_ASSOC);
						$tick_visibility = '';
						if($retval>0){
							$tick_visibility = 'visible';
						}
						else{
							$tick_visibility = 'hidden';
						}

						$userid_query = mysql_query("SELECT user_id,user_name FROM qlik_user_info WHERE user_id = '{$row['ques_created_by']}'");
						$userid_row = mysql_fetch_array($userid_query,MYSQL_ASSOC);
						$user_id = $userid_row['user_id'];
						if($user_id == 0)
							$user_name = "*Sponsored*";
						else
							$user_name = $userid_row['user_name'];


		echo '<form action="votedetails.php" method="POST" class="votedetails" id="votedetails'.$row['ques_id'].'">';
		echo '<div id="post_detail">
			<div id="tick_img"><img src="../images/vote_tick.jpg" id="img_tick" style="visibility: '.$tick_visibility.'"></div>
			<div id="ques_tagline">'.$row['ques_tagline'].'
			</div>
			<div id="ques_desc">'.$row['ques_desc'].'
			</div><br/>
			<div id="user_details">
				<div id="profile_pic"><img src="../images/background_img.jpg"id="pic_profile"></div>
				<div id="username">'.$user_name.'</div>
					<div id="postedtime">8 hrs</div>
			</div>';
		echo '<div id="opt_query'.$row['ques_id'].'">';
				

			$query_total_votes = mysql_query("SELECT SUM(opt_value) AS 'opt_value' FROM options_dtl WHERE ques_id_opt = {$row['ques_id']}");

						$value = mysql_fetch_array($query_total_votes,MYSQL_ASSOC);

						$total_votes = $value['opt_value'];
						$total_votes1 = $value['opt_value'];

						if($total_votes == 0)
						{
							$total_votes = 1;
						}

						$query_opt = mysql_query("SELECT DISTINCT opt_dtl,opt_value,opt_no FROM question_list
											JOIN options_dtl on ques_id = ques_id_opt WHERE ques_id_opt = {$row['ques_id']}");
						$opt_count = 1;

				while($row_opt = mysql_fetch_array($query_opt, MYSQL_ASSOC)){
							$fraction1 = floatval($row_opt['opt_value'])/$total_votes;
							$fraction2 = round($fraction1*100,2);
							$fraction = round($fraction1,2)*400;

							$width_properties = 'style = "width : '.($fraction).'px;"';
							$opt_desc = '';
							if(strlen($row_opt['opt_dtl']) > 30){
								//$opt_desc = substr($row_opt['opt_dtl'], 0,30)."...";
								$opt_desc = $row_opt['opt_dtl'];
							}
							else{
								$opt_desc = $row_opt['opt_dtl'];
							}
				echo "<input type='radio' name='vote_radio' id='vote_options' value='{$row_opt['opt_no']}' class='vote_options' />"."{$opt_desc}"."<br/>".
				'<div id="votevalue"'.$width_properties.'></div><div id="vote_number">'.$row_opt["opt_value"].'</div><br/>';
			}
			echo "<input type='submit' value='Vote | {$total_votes1}' id='vote_submit' onclick='quesid({$row['ques_id']})'
															 name='submit' class='vote_submit{$row['ques_id']}'>
				
			</div></form>
		</div>";
		}
		
		?>

<!--		<div id="post_detail">
			<div id="tick_img"><img src="../images/vote_tick.jpg" id="img_tick"></div>
			<div id="ques_tagline">Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here
				Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here
			</div>
			<div id="ques_desc">Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here
				Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here
				Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here Question tagline goes here
			</div><br/>
			<div id="user_details">
				<div id="profile_pic"><img src="../images/background_img.jpg"id="pic_profile"></div>
				<div>Subhashis Pradhan</div>
					<div>8 hrs</div>
			</div>
			<div>
				<form action='' method='POST' class='votedetails'>
				<input type="radio" name="vote_radio"/>Option 1<br/>
				<div id="votevalue"></div><div id="vote_number">213</div><br/>
				<input type="radio" name="vote_radio"/>Option 2<br/>
				<div id="votevalue"></div><div id="vote_number">234</div><br/>
				<input type="submit" id="vote_submit" value="Vote | 0">
				</form>
			</div>
		</div>-->


	
	<div id="topfeed">
			<div id="toptrend_hdr">Top trending</div>

			<?php
					//top view code goes here
					include("toptrengingpolls.php");
					$i=0;
					foreach ($quesdata as $key => $value) {
						if($i == 6)
							break;

						$topquery = mysql_query("SELECT ques_tagline FROM question_list WHERE ques_id = {$key}");

						$row = mysql_fetch_array($topquery, MYSQL_ASSOC);

						//echo "<div class='topqueries' onclick='divert({$key},{$user_id})'>{$row['ques_tagline']}</div><br/>";

						echo '<div id="topqueslist">
							<div id="topvotevalue">'.$value.'</div>
							<div id="topvoteques">'.$row['ques_tagline'].'</div>
						</div>';
						$i = $i + 1;
					}
					mysql_close($conn);
				?>


	<!--		<div id="topqueslist">
				<div id="topvotevalue">214</div>
				<div id="topvoteques">Top vote ques to be added here</div>
			</div>-->


		</div>

	<script src="jquery-3.1.0.min.js"></script>
<script src="vote_details.js"></script>
</body>

</html>