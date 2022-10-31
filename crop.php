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

<div class="pagethings">
	
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<button id="addcrbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addcrtbl').show(500);$(this).hide(500);">Add Crop</button>

	<div id="addcrtbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New Crop</h6>
		<table class=" estable table table-bordered">
			<thead>
			<tr>
				<th>Crop Name</th>
				<th>Crop Code</th>
				<th>Group</th>
				<th style="width:100px;">Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<input class="form-control frminp" id="crn" >
				</td>
				<td>
					<input class="form-control frminp" id="crc" >
				<td>
					<select id="cgid" class="form-control frminp" >
						<option value="1" >Vegetable</option>
						<option value="2" >Field</option>
					</select>
				</td>
				
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addcr()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addcrtbl').hide(500);$('#addcrbtn').show(500);" >Cancel</button>
				</td>
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;height: 500px;width:595px;overflow:scroll;">
		<h6 style="font-weight: bold;">All Crops</h6>
		<table id="croptable" class=" estable table table-bordered">
			<thead>
			<tr>
				<th>Crop Name</th>
				<th>Crop Code</th>
				<th>Group</th>
				<th style="width:100px;">Action</th>

			</tr>
			</thead>
			<tbody>
			<?php
			$allcr=mysql_query('SELECT * FROM `crop` order by cropname asc');

			while ($allcrd=mysql_fetch_assoc($allcr)) {
			?>
			<tr>
				<td>
					<span id="showcrn<?=$allcrd['cropid']?>" style="float: left;"><?=$allcrd['cropname']?></span>
					<input class="form-control frminp nshw" id="crn<?=$allcrd['cropid']?>"  value="<?=$allcrd['cropname']?>" >
				</td>
				<td>
					<span id="showcrc<?=$allcrd['cropid']?>" ><?=$allcrd['cropcode']?></span>
					<input class="form-control frminp nshw" id="crc<?=$allcrd['cropid']?>"  value="<?=$allcrd['cropcode']?>" >
				<td>
					<span id="showcgid<?=$allcrd['cropid']?>"><?=($allcrd['group']==1)?'Vegetable':'Field';?></span>
					<select id="cgid<?=$allcrd['cropid']?>" class="form-control frminp nshw" >
						<option value="1" <?=($allcrd['group']==1)?'selected':'';?> >Vegetable</option>
						<option value="2" <?=($allcrd['group']==2)?'selected':'';?> >Field</option>
					</select>
				</td>
				<td>
					<button id="ebtn<?=$allcrd['cropid']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allcrd['cropid']?>')">Edit</button>
					<button id="sbtn<?=$allcrd['cropid']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allcrd['cropid']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$allcrd['cropid']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allcrd['cropid']?>')" style="display:none;">Cancel</button>
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
		$('#showcrn'+id).hide();
		$('#showcrc'+id).hide();
		$('#showcgid'+id).hide();

		$('#crn'+id).show();
		$('#crc'+id).show();
		$('#cgid'+id).show();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){
		$('#showcrn'+id).show();
		$('#showcrc'+id).show();
		$('#showcgid'+id).show();

		$('#crn'+id).hide();
		$('#crc'+id).hide();
		$('#cgid'+id).hide();

		$('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
	}

	function saved(id){
		var crn  = $('#crn'+id).val();
		var crc  = $('#crc'+id).val();
		var cgid = $('#cgid'+id).val();
		
		if(crn==''){ alert("enter crop name"); return false; }
		if(crc==''){ alert("enter crop code"); return false; }
		if(cgid==''){ alert("select group name"); return false; }		

		$.post("mastersAjax.php",{ act:'saveCropDetails',crn:crn , crc:crc , cgid:cgid ,id:id },function(data) {
                          
			if(data.includes("updated")){
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = "<?=basename($_SERVER['PHP_SELF'])?>";  }, 800);
			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
			$('#ebtn'+id).show();
			$('#sbtn'+id).hide();
			$('#cbtn'+id).hide();
        });		
	}


	function addcr(){
		var crn  = $('#crn').val();
		var crc = $('#crc').val();
		var cgid  = $('#cgid').val();

        if(crn==''){ alert("enter crop name"); return false; }
		if(crc==''){ alert("enter crop code"); return false; }
		if(cgid==''){ alert("select group name"); return false; }	
		
		$.post("mastersAjax.php",{ act:'addCrop',crn:crn,crc:crc,cgid:cgid },function(data) {
                                                    
			if(data.includes("added")){
				$('#addcrtbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = '<?=basename($_SERVER['PHP_SELF'])?>';  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
        });
	}


	function editp(th,id){
		$(th).hide();
		$('#spbtn'+id).show();
		$('#pertr'+id).show();

	}

	$(document).ready(function() {
	    $('#croptable').DataTable();
	} );
</script>


