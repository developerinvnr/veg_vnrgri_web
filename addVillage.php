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
$alls=mysql_query('SELECT * FROM `tahsil`');
while ($allvid=mysql_fetch_assoc($alls)) {
	$arr[$allvid['TahsilId']]=$allvid['TahsilName'];
}
?>

<table class=" estable table table-bordered" style="width:100%;">
	<thead>
	<tr>
		<th style="width: 120px;">Village Name <font color="#FF0000">*</font></th>
		<td style="width: 250px;">
			<input class="form-control frminp" id="vina" >
		</td>
	</tr>
	<tr>
		<th>Tahsil Name <font color="#FF0000">*</font></th>
		<td>
			<select id="vita" class="form-control frminp" >
				<option  >Select</option>
				<?php foreach ($arr as $key => $value) { ?>
				<option value="<?=$key?>"  <?=($key==$_REQUEST['tid'])?'selected':'';?> ><?=$value?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>Action</th>
		<td>
			<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addvi()">Save</button>
			<button class="frmbtn btn btn-sm btn-danger" onclick="window.close();" >Cancel</button>
		</td>
	</tr>
	</thead>
	
	
</table>

<script type="text/javascript">
	function addvi(){
		var vina  = $('#vina').val();
		var vita = $('#vita').val();
		
		if(vina==''){ alert("enter village name"); return false; }
		if(vita==''){ alert("select tahsil name"); return false; }

		$.post("mastersAjax.php",{ act:'addVillage',vina:vina , vita:vita },function(data) {
                                                    
			if(data.includes("added")){
				alert(' Village Added Successfully! \n\n\n');
				window.close();
			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}

			
          }
        );
		
	}
</script>