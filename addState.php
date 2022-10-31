<head>
	<meta name="google" content="notranslate">
</head>
<?php 
include 'cdns.php'; 
include 'config.php'; 
session_start();
?>
<style type="text/css">
.frminp{
  padding: 4px !important;
  height:25px;
  border-radius: 4px;
  font-size: 11px;
  font-weight:550;
}
.frmbtn{
  padding: 2px 4px !important;
  font-size: 11px;
}
.estable thead th{
  font-size: 13px;
  font-weight: bold;
}
body{
	background-color: #EDEDED;
}
</style>
<?php
/*============================================
here taking all the states and putting on a array, 
so in below district loop we don't have to fetch all states again and again...
==============================================*/

?>

<table class=" estable table table-bordered" style="width:100%;">
	<thead>
	<tr>
		<th style="width: 120px;">State Name <font color="#FF0000">*</font></th>
		<td style="width: 250px;">
			<input class="form-control frminp" id="stn" >
		</td>
	</tr>
	<tr>
		<th style="width: 120px;">State Code</th>
		<td style="width: 250px;">
			<input class="form-control frminp" id="stc" >
		</td>
	</tr>
	<tr>
		<th style="width: 120px;">Country <font color="#FF0000">*</font></th>
		<td>
			<select id="cyid" class="form-control frminp" >
				<option value="1" selected >India</option>
			</select>
		</td>
	</tr>
	
	
	<tr>
		<th>Action</th>
		<td>
			<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addstate()">Save</button>
			<button class="frmbtn btn btn-sm btn-danger" onclick="window.close();" >Cancel</button>
		</td>
	</tr>
	</thead>
	
	
</table>

<script type="text/javascript">

	function addstate(){
		var stn  = $('#stn').val();
		var stc = $('#stc').val();
		var cyid  = $('#cyid').val();
		var ssts  = 'A';
		
		if(stn==''){ alert("enter state name"); return false; }
		if(cyid==''){ alert("select country"); return false; }

		$.post("mastersAjax.php",{ act:'addState',from:'addFarmerPage',stn:stn , stc:stc , cyid:cyid , ssts:ssts},function(data) {
                                                    
			if(data.includes("added")){
				alert(' State Added Successfully! \n\n\n');
				window.close();
			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
        });
	}
</script>