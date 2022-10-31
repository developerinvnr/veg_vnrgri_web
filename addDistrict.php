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
$alls=mysql_query('SELECT * FROM `state`');
while ($allsd=mysql_fetch_assoc($alls)) {
	$arr[$allsd['StateId']]=$allsd['StateName'];
}
?>

<table class=" estable table table-bordered" style="width:100%;">
	<thead>
	<tr>
		<th style="width: 120px;">District Name <font color="#FF0000">*</font></th>
		<td style="width: 250px;">
			<input class="form-control frminp" id="dina" >
		</td>
	</tr>
	
	<tr>
		<th>State <font color="#FF0000">*</font></th>
		<td>
			<select id="dista" class="form-control frminp" >
				<option  >Select</option>
				<?php foreach ($arr as $key => $value) { ?>
				<option value="<?=$key?>" <?=($key==$_REQUEST['sid'])?'selected':'';?> ><?=$value?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>Action</th>
		<td>
			<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="adddist()">Save</button>
			<button class="frmbtn btn btn-sm btn-danger" onclick="window.close();" >Cancel</button>
		</td>
	</tr>
	</thead>
	
	
</table>

<script type="text/javascript">

	function adddist(){
		var dina  = $('#dina').val();
		var dista = $('#dista').val();
		
		if(dina==''){ alert("enter district name"); return false; }
		if(dista==''){ alert("select state name"); return false; }

		$.post("mastersAjax.php",{ act:'addDistrict',from:'addFarmerPage',dina:dina,dista:dista},function(data) {
                                                    
			if(data.includes("added")){
				alert(' District Added Successfully! \n\n\n');
				window.close();
			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
        });
	}
</script>