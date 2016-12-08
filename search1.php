<html>

<head>
<script src="jquery-3.1.0.min.js"></script> 

<style>
#searchquery{
  position: absolute;
  z-index: 10;
  background-color: white;
}
#newsfeed{
  position: relative;
}
</style>

</head>
<body>
<div>
  <table>
    <tr>
      <td>hello</td>
  <td><input type="text" id="search_text">
    
  </td>
</tr>
</table>
</div>
<div id="searchquery"></div>
<div id="newsfeed">
  <div>
  hello there..how are you doing
</div>
  </div>
</body>


</html>

<script>
$(document).ready(function(){
  $('#search_text').keyup(function(){
    var query = $(this).val();
    console.log(query);

    if(query != ''){
      $.ajax({
        url : "search.php",
        method : "POST",
        data : {query : query},
        success : function(data){
            $('#searchquery').html(data);
        }
      });
    }
  });
  $('#search_text').keydown(function(){
    $('#searchquery').html('');
  });

  $("#search_text").focusout(function() {
    console.log("not visible");
        document.getElementById('itemlist').visibility="none";
    });

});
</script>

<script src="vote_details.js"></script>