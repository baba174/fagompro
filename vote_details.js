var quesid1 = 0;
var userid1 = 0;

/*$('#comments').click(function(){
		console.log('commentssec'+quesid1.toString());
	document.getElementById('commentssec'+quesid1.toString()).style.visibility = "visible";
});*/
function quesid(ques){
	quesid1 = ques;
	console.log(quesid1);
	
}
function ques_dtl_page(requestqid){
	window.location.href = "quesdetail.php?qid=" + requestqid;
}
function quesid2(ques){
	quesid1 = ques;
	console.log(quesid1);
	console.log('commentssec'+quesid1.toString());
	document.getElementById('commentssec'+quesid1.toString()).style.display = "block";
	data = {};
	data['quesid'] = quesid1;
	$.ajax({
			url : "fetchcomments.php",
			type :  "POST",
			data : data,
			success : function(response){
				$('#commentlist'+quesid1.toString()).html(response);
				//console.log(response);
			}
		});
	
}
function quesid3(quesid){
	quesid1 = quesid;

	var commentval = document.getElementById('cmntinp'+quesid1.toString()).value ;
	console.log(commentval);

	$.ajax({
			url : "insertcomment.php",
			type :  "POST",
			data : {inptxt : commentval,quesid : quesid1},
			success : function(response){
				$('#commentlist'+quesid1.toString()).html(response);
				//console.log(response);
			}
		});

}
$('.votedetails').on('submit',function(){
	var doc = $(this),
		url = doc.attr('action'),
		method = doc.attr('method'),
		data = {};
		//var hv = $('#ques_id').val();

		var hv = quesid1;
		//alert(hv);
		
		doc.find('[name]').each(function(index,value){
			var doc_dtl = $(this),
				name = doc_dtl.attr('name'),
				radio_button_value = $('input:radio[name='+name+']:checked').val();
				//val = doc_dtl.val();
				data[name] = radio_button_value;
				//data[name] = val;
				//console.log(value);	
				$('input[name='+name+']').attr('checked',false);
		});
		data['ques_id'] = hv;
		console.log(data);

		$.ajax({
			url : url,
			type :  "POST",
			data : data,
			success : function(response){
				//$('#vote_submit').html(response);
				$('.vote_submit'+quesid1).val(response);
				//$('#postdetails'+quesid1).load(location.href + ('#postdetails'+quesid1));
				 $('#opt_query'+quesid1).fadeOut(800, function(){
                            $('#opt_query'+quesid1).load(location.href + (' #opt_query'+quesid1)).fadeIn().delay(500);
                        });
				//$("#morelink").load(location.href + " #morelink");
				//console.log(response);
			}
		});

			var ele = document.getElementsByName("vote_radio");
   			for(var i=0;i<ele.length;i++)
      		ele[i].checked = false;

	return false;
});

$('#cmntbtn'+quesid1.toString()).click(function(){
	console.log("sfsd");	
});


/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

function divert(key,userid){
	window.location.href = "quesdetail.php?qid=" + key + "&uid=" + userid;
}
$('#morelink').click(function() {
    var p = $('a').prev('p')
    var lineheight = parseInt(p.css('line-height'))
    if (parseInt(p.css('height')) == lineheight*3) {
       p.css('height','auto');
       $(this).text('...Less')
    } else {
       p.css('height',lineheight*3+'px');
       $(this).text('More...')
    }
});


