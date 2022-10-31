<?php
include 'sidemenu.php';
?>

<style type="text/css">
	.pagethings{
		position: absolute;
		left: 200px;
		padding: 20px;
	}
	.nshw{
		display: none;
	}

</style>
<?php
/*============================================
here taking all the districts and putting on a array, 
so in below Tahsil loop we don't have to fetch all states again and again...
==============================================*/
$alld=mysql_query('SELECT * FROM `crop` order by cropname');
while ($alldd=mysql_fetch_assoc($alld)) {
	$arr[$alldd['cropid']]=$alldd['cropname'];
}
?>
<div class="pagethings">
	
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<button id="addcrbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addcrtbl').show(500);$(this).hide(500);">Add Variety</button>

	<div id="addcrtbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New Variety</h6>
		<table class=" estable table table-bordered">
			<thead>
			<tr>
			  <th>Variety Name</th>
			  <th>Variety Code</th>
			  <th>Crop</th>
			  <th style="width:100px;">Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<input class="form-control frminp" id="varn" >
				</td>
				<td>
					<input class="form-control frminp" id="varc" >
				<td>
					<select id="varcid" class="form-control frminp" >
						<option  >Select</option>
						<?php
						foreach ($arr as $key => $value) { ?>
						  
						<option value="<?=$key?>"  ><?=$value?></option>
						
						<?php
						}
						?>

					</select>
				</td>
				
				
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addvar()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addcrtbl').hide(500);$('#addcrbtn').show(500);" >Cancel</button>
				</td>
				

			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;height: 500px;width:595px;overflow:scroll;">
	    
	    <span style="width:200px;text-align:right;">
	    <select id="crop" class="form-control frminp" onChange="selcrop(this.value)" style="width:150px;">
					<option value="">Select Crop</option>
					<?php $sc=mysql_query("select * from crop order by cropname asc"); while($rc=mysql_fetch_assoc($sc)){?>	                    <option value="<?=$rc['cropid'];?>"><?=$rc['cropname'];?></option><?php } ?>
		</select>
	    </span>
	    
		<!--<h6 style="font-weight: bold;">All Variety</h6>-->
		
		<h3>
		    
		    
		    
		</h3>
		
		
		
		<table id="varietytable" class="estable table table-bordered">
			<thead>
			<tr>
			  <th>Variety Name</th>
			  <th>Variety Code</th>
			  <th>Crop</th>
			  <th style="width:100px;">Action</th>
			</tr>
			</thead>
			<tbody>
			<?php
			if($_REQUEST['v']!=''){ $subQ="cropid=".$_REQUEST['v']; }
			else{ $subQ="1=1"; }
			$allvar=mysql_query("SELECT * FROM `variety` where ".$subQ." order by varietyname asc");

			while ($allvard=mysql_fetch_assoc($allvar)) {
			?>
			<tr>

				<td>
					<span id="showvarn<?=$allvard['varietyid']?>" style="float: left;"><?=$allvard['varietyname']?></span>
					<input class="form-control frminp nshw" id="varn<?=$allvard['varietyid']?>"  value="<?=$allvard['varietyname']?>">
				</td>
				<td>
					<span id="showvarc<?=$allvard['varietyid']?>" ><?=$allvard['varietycode']?></span>
					<input class="form-control frminp nshw" id="varc<?=$allvard['varietyid']?>"  value="<?=$allvard['varietycode']?>"  style="width:90px;">
				</td>
				<td>
					<span id="showvarcid<?=$allvard['varietyid']?>" ><?=$arr[$allvard['cropid']]?></span>
					<select id="varcid<?=$allvard['varietyid']?>" class="form-control frminp nshw"  style="width:100px;">
						<option>Select</option>
						<?php
						foreach ($arr as $key => $value) { ?>
						  
						<option value="<?=$key?>" <?=($allvard['cropid']==$key)?'selected':'';?>><?=$value?></option>
						
						<?php
						}
						?>

					</select>
				</td>


				
				<td>
					<button id="ebtn<?=$allvard['varietyid']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allvard['varietyid']?>')">Edit</button>
					<button id="sbtn<?=$allvard['varietyid']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allvard['varietyid']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$allvard['varietyid']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allvard['varietyid']?>')" style="display:none;">Cancel</button>

				</td>
				
			</tr>
			
			<?php
			}
			?>	
			</tbody>
		</table>
	</div>
	
	

</div>

<script type="text/javascript">
function selcrop(v)
{  window.location="variety.php?v="+v; }

	function editd(id){

		$('#showvarn'+id).hide();
		$('#showvarc'+id).hide();
		$('#showvarcid'+id).hide();

		$('#varn'+id).show();
		$('#varc'+id).show();
		$('#varcid'+id).show();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){

		$('#showvarn'+id).show();
		$('#showvarc'+id).show();
		$('#showvarcid'+id).show();

		$('#varn'+id).hide();
		$('#varc'+id).hide();
		$('#varcid'+id).hide();

		$('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
	}

	function saved(id){
		var varn  = $('#varn'+id).val();
		var varc = $('#varc'+id).val();
		var varcid = $('#varcid'+id).val();
		
		if(varn==''){ alert("enter variety name"); return false; }
		if(varc==''){ alert("enter variety code"); return false; }
		if(varcid==''){ alert("select crop name"); return false; }
		
		$.post("mastersAjax.php",{ act:'saveVarietyDetails',varn:varn , varc:varc , varcid:varcid ,id:id },function(data) {
                          
			if(data.includes("updated")){

				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = "<?=basename($_SERVER['PHP_SELF'])?>";  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
			$('#ebtn'+id).show();
			$('#sbtn'+id).hide();
			$('#cbtn'+id).hide();
          }
        );

		
	}


	function addvar(){

		var varn  = $('#varn').val();
		var varc = $('#varc').val();
		var varcid = $('#varcid').val();
		
		if(varn==''){ alert("enter variety name"); return false; }
		if(varc==''){ alert("enter variety code"); return false; }
		if(varcid==''){ alert("select crop name"); return false; }

		$.post("mastersAjax.php",{ act:'addVariety',varn:varn,varc:varc,varcid:varcid },function(data) { alert(data);
                                                    
			if(data.includes("added")){
				$('#addvartbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href =  "<?=basename($_SERVER['PHP_SELF'])?>";  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}

			
          }
        );
		
	}
	
	
	function editp(th,id){
		$(th).hide();
		$('#spbtn'+id).show();
		$('#pertr'+id).show();

	}
	

	$(document).ready(function() {
	    $('#varietytable').DataTable();
	} );
	
	
	
	
</script>


