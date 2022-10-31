<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script src="http://malsup.github.com/jquery.form.js"></script> 


<form id="farmertable" method="post" enctype="multipart/form-data" action="afajax.php">
	<input type="" name="farmer">
	<input type="" name="act" value="addfarmer">
	<input type="file" name="idoc">
	<button type="button" onclick="savef()">save</button>
</form>


<script type="text/javascript">
	function savef(){
		// $.post("afajax.php", $('#farmertable').serialize() ,function(data) { console.log(data); });
		$('#farmertable').ajaxForm(function(data) { 
			console.log(data);
                alert("Thank you for your comment!"); 
            });
	}
	
</script>