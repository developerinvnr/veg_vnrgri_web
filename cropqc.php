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
<script type="text/javascript">
function isNumberFKey(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
   return false;

  return true;
}
</script>

<div class="pagethings" style="width:80%;">
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

<button id="addstbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addsttbl').show();$(this).hide();">Add New</button>

<div id="addsttbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New QC (%)</h6>
		<table class=" estable table table-bordered" style="width:90%;">
			<thead>
			<tr>
				<th style="width: 250px !important;">Crop Name <font style="color:#FF0000;">*</font></th>
				<th style="width: 50px !important;">Type <font style="color:#FF0000;">*</font></th>
				<th>Germination<br>(%)</th>
				<th>Genetic_Purity<br>(%)</th>
				<!-- <th>Physical_Purity<br>(%)</th> -->
				<th>Moisture<br>(%)</th>
				<th style="width: 100px !important;">Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<select id="crop" class="form-control frminp" >
					<?php $sc=mysql_query("select * from crop order by cropname asc"); while($rc=mysql_fetch_assoc($sc)){?>	                    <option value="<?=$rc['cropid'];?>"><?=$rc['cropname'];?></option><?php } ?>
					</select>
				</td>
				<td>
					<select id="type" class="form-control frminp" >
					 <option value="HYB">HYB</option><option value="OP">OP</option>
					</select>
				</td>
				<td><input class="form-control frminp" id="germ" onKeyPress="return isNumberFKey(event)" maxlength="6"></td>
				<td><input class="form-control frminp" id="gene" onKeyPress="return isNumberFKey(event)" maxlength="6"></td>
				<!-- <td><input class="form-control frminp" id="phys" onKeyPress="return isNumberFKey(event)" maxlength="6"></td> -->
				<td><input class="form-control frminp" id="mois" onKeyPress="return isNumberFKey(event)" maxlength="6"></td>
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addst()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addsttbl').hide();$('#addstbtn').show();" >Cancel</button>
				</td>
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addsttbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll; text-align:center;">
		<h6 style="font-weight: bold;">Crop QC</h6>
		<table id="statetable" class="estable table table-bordered" style="width:90%;">
			<thead>
			<tr>
			    <th style="width: 200px !important;">Crop Name <font style="color:#FF0000;">*</font></th>
				<th style="width: 50px !important;">Type <font style="color:#FF0000;">*</font></th>
				<th>Germination<br>(%)</th>
				<th>Genetic_Purity<br>(%)</th>
				<!-- <th>Physical_Purity<br>(%)</th> -->
				<th>Moisture<br>(%)</th>
				<th style="width: 100px !important;">Action</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$alls=mysql_query('SELECT qc.*,cropname FROM `master_crop_qc` qc inner join crop c on qc.cropid=c.cropid order by cropname asc');
			while ($allsd=mysql_fetch_assoc($alls)) {
			?>
			<tr>
				<td>
					<span id="showcrop<?=$allsd['qcid']?>" style="float: left;"><?=$allsd['cropname'];?></span>
					<select id="crop<?=$allsd['qcid']?>" class="form-control frminp nshw">
						<?php $sc=mysql_query("select * from crop order by cropname asc"); while($rc=mysql_fetch_assoc($sc)){?>	                    <option value="<?=$rc['cropid'];?>" <?php if($rc['cropid']==$allsd['cropid']){echo 'selected';} ?>><?=$rc['cropname'];?></option><?php } ?>
					</select>
				</td>
				
				<td style="text-align:center;">
				    <span id="showtype<?=$allsd['qcid']?>"><?=$allsd['type'];?></span>
					<select id="type<?=$allsd['qcid']?>" class="form-control frminp nshw" >
					 <option value="HYB" <?php if($allsd['type']=='HYB'){echo 'selected';} ?>>HYB</option><option value="OP" <?php if($allsd['type']=='OP'){echo 'selected';} ?>>OP</option>
					</select>
				</td>
				<td style="width: 50px !important; text-align:center;">
					<span id="showgerm<?=$allsd['qcid']?>"><?=floatval($allsd['germination']);?></span>
					<input class="form-control frminp nshw" id="germ<?=$allsd['qcid']?>" value="<?=$allsd['germination']?>" onKeyPress="return isNumberFKey(event)" maxlength="6">
				</td>
				<td   style="width: 50px !important;text-align:center;">
					<span id="showgene<?=$allsd['qcid']?>"><?=floatval($allsd['genetic_purity']);?></span>
					<input class="form-control frminp nshw" id="gene<?=$allsd['qcid']?>" value="<?=$allsd['genetic_purity']?>" onKeyPress="return isNumberFKey(event)" maxlength="6">
				</td>
				<!-- <td   style="width: 50px !important;text-align:center;">
					<span id="showphys<?=$allsd['qcid']?>"><?=floatval($allsd['physical_purity']);?></span>
					<input class="form-control frminp nshw" id="phys<?=$allsd['qcid']?>" value="<?=$allsd['physical_purity']?>" onKeyPress="return isNumberFKey(event)" maxlength="6">
				</td> -->
				<td   style="width: 50px !important;text-align:center;">
					<span id="showmois<?=$allsd['qcid']?>"><?=floatval($allsd['moisture']);?></span>
					<input class="form-control frminp nshw" id="mois<?=$allsd['qcid']?>" value="<?=$allsd['moisture']?>" onKeyPress="return isNumberFKey(event)" maxlength="6">
				</td>
				
				
				<td>
					<button id="ebtn<?=$allsd['qcid']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allsd['qcid']?>')">Edit</button>
					<button id="sbtn<?=$allsd['qcid']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allsd['qcid']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$allsd['qcid']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allsd['qcid']?>')" style="display:none;">Cancel</button>
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
	function editd(id){
		$('#showcrop'+id).hide();
		$('#showtype'+id).hide();
		$('#showgerm'+id).hide();
		$('#showgene'+id).hide();
		$('#showphys'+id).hide();
		$('#showmois'+id).hide();

		$('#crop'+id).show();
		$('#type'+id).show();
		$('#germ'+id).show();
		$('#gene'+id).show();
		$('#phys'+id).show();
		$('#mois'+id).show();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){
		$('#showcrop'+id).show();
		$('#showtype'+id).show();
		$('#showgerm'+id).show();
		$('#showgene'+id).show();
		$('#showphys'+id).show();
		$('#showmois'+id).show();

		$('#crop'+id).hide();
		$('#type'+id).hide();
		$('#germ'+id).hide();
		$('#gene'+id).hide();
		$('#phys'+id).hide();
		$('#mois'+id).hide();

		$('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
		
	}

	function saved(id){
		var crop  = $('#crop'+id).val();
		var type  = $('#type'+id).val();
		var germ = $('#germ'+id).val();
		var gene  = $('#gene'+id).val();
		var phys  = $('#phys'+id).val();
		var mois  = $('#mois'+id).val();
		
		if(crop==''){ alert("select crop name"); return false; }
		if(type==''){ alert("select type"); return false; }
		

		$.post("mastersAjaxx.php",{ act:'saveQCDetails',crop:crop,type:type,germ:germ,gene:gene,phys:phys,mois:mois,id:id},function(data) {
		    //console.log(data);
                          
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


	function addst(){ 
		var crop  = $('#crop').val();
		var type  = $('#type').val(); 
		var germ = $('#germ').val();
		var gene  = $('#gene').val(); 
		var phys  = $('#phys').val();
		var mois  = $('#mois').val(); 
		
		if(crop==''){ alert("select crop name"); return false; }
		if(type==''){ alert("select type"); return false; }

		$.post("mastersAjaxx.php",{ act:'addQC',crop:crop,type:type,germ:germ,gene:gene,phys:phys,mois:mois},function(data) {
                                                  
			if(data.includes("added")){
				$('#addsttbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = '<?=basename($_SERVER['PHP_SELF'])?>';  }, 800);

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
	    $('#statetable').DataTable();
	} );
</script>


