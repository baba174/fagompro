<html>
<head>
	<script>
	function sendata(){
		console.log("sdsa");
		$('#form1').on('submit',function(){
			console.log("1");
			return false;
		});
		//return false;
	}
		
	</script>

</head>

<body>
	<form action="prac2.php" method="post" id="form1">
	<input  id="subbtn" type="submit" onclick="sendata()" value =  "clickme">
</form>

<script src="jquery-3.1.0.min.js"></script>
</body>

</html>