<html>
<?php
$servername = "localhost";
$dbuser = "statuser";
$dbpass = "statuser";
$database = "qlikstatdb";
$conn = mysql_connect($servername,$dbuser,$dbpass);
$dbconn = mysql_select_db($database);
?>

<head>
	<style>
	#itemlist{
		position: absolute;
		background-color: red;
	}
	#con{
		z-index: -3;
		position: absolute;

	}
	</style>
<script src="jquery-3.1.0.min.js"></script>
</head>

<body>
	<form action="searchquery.php" method="GET" name="searchquery">
	<input type="text" name="q" id="q" class="form-control"><br/>
	<div id="itemlist"></div>
	<div id="con">sadad</div>



	
	</form>
</body>

</html>
<script>
$(document).ready(function(){
	$('#q').keyup(function(){
		var query = $(this).val();
		console.log(query);

		if(query != ''){
			$.ajax({
				url : "search.php",
				method : "POST",
				data : {query : query},
				success : function(data){
						$('#itemlist').html(data);
				}
			});
		}
	});
	$('#q').keydown(function(){
		$('#itemlist').html('');
	});

	$("#itemlist").focusout(function() {
		console.log("not visible");
        document.getElementById('itemlist').visibility="none";
    });

});
</script>
