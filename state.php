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

<div class="pagethings" style="width:60%;">
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<!--<button id="addstbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addsttbl').show(500);$(this).hide(500);">Add State</button>-->

	<div id="addsttbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New State</h6>
		<table class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th>Stat Name <font color="#FF0000">*</font></th>
				<th>State Code <font color="#FF0000">*</font></th>
				<th>Country <font color="#FF0000">*</font></th>
				<th>Status</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<input class="form-control frminp" id="stn" >
				</td>
				<td>
					<input class="form-control frminp" id="stc" >
				<td>
					<select id="cyid" class="form-control frminp" >
						<option value="1" >India</option>
					</select>
				</td>
				
				<td>
					<select id="ssts" class="form-control frminp" >
						<option disabled >Select</option>
						<option value="A"  >Active</option>
						<option value="D"  >Deactive</option>
					</select>
				</td>
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addst()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addsttbl').hide(500);$('#addstbtn').show(500);" >Cancel</button>
				</td>
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addsttbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;width:595px;overflow:scroll;">
		<h6 style="font-weight: bold;">All States</h6>
		<table id="statetable" class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th style="width: 150px !important;">State Name <font color="#FF0000">*</font></th>
				<th style="width: 50px !important;">State Code <font color="#FF0000">*</font></th>
				<th>Country <font color="#FF0000">*</font></th>
				<th>Status</th>
				<th>Action</th>

			</tr>
			</thead>
			<tbody>
			<?php
			$alls=mysql_query('SELECT * FROM `state`');

			while ($allsd=mysql_fetch_assoc($alls)) {
			?>
			<tr>
				<td>
					<span id="showstn<?=$allsd['StateId']?>" style="float: left;"><?=$allsd['StateName']?></span>
					<input class="form-control frminp nshw" id="stn<?=$allsd['StateId']?>" value="<?=$allsd['StateName']?>" >
				</td>
				<td   style="width: 50px !important;">
					<span id="showstc<?=$allsd['StateId']?>"><?=$allsd['StateCode']?></span>
					<input class="form-control frminp nshw" id="stc<?=$allsd['StateId']?>" value="<?=$allsd['StateCode']?>" >
				</td>
				<td>
					<span id="showcyid<?=$allsd['StateId']?>"><?=($allsd['CountryId']==1)?'India':'';?></span>
					<select id="cyid<?=$allsd['StateId']?>" class="form-control frminp nshw">
						<option value="<?=$allsd['CountryId']?>" <?=($allsd['CountryId']==1)?'selected':'';?> >India</option>
					</select>
				</td>
				
				<td>
					<span id="showssts<?=$allsd['StateId']?>"><?=($allsd['StateStatus']=='A')?'Active':'Deactive';?></span>
					<select id="ssts<?=$allsd['StateId']?>" class="form-control frminp nshw" >
						<option disabled >Select</option>
						<option value="A" <?=($allsd['StateStatus']=='A')?'selected':'';?> >Active</option>
						<option value="D" <?=($allsd['StateStatus']=='D')?'selected':'';?> >Deactive</option>
					</select>
				</td>
				<td>
					<button id="ebtn<?=$allsd['StateId']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allsd['StateId']?>')">Edit</button>
					<button id="sbtn<?=$allsd['StateId']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allsd['StateId']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$allsd['StateId']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allsd['StateId']?>')" style="display:none;">Cancel</button>
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
		$('#showstn'+id).hide();
		$('#showstc'+id).hide();
		$('#showcyid'+id).hide();
		$('#showssts'+id).hide();

		$('#stn'+id).show();
		$('#stc'+id).show();
		$('#cyid'+id).show();
		$('#ssts'+id).show();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){
		$('#showstn'+id).show();
		$('#showstc'+id).show();
		$('#showcyid'+id).show();
		$('#showssts'+id).show();

		$('#stn'+id).hide();
		$('#stc'+id).hide();
		$('#cyid'+id).hide();
		$('#ssts'+id).hide();

		$('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
		
	}

	function saved(id){
		var stn  = $('#stn'+id).val();
		var stc = $('#stc'+id).val();
		var cyid  = $('#cyid'+id).val();
		var ssts  = $('#ssts'+id).val();
		
		if(stn==''){ alert("enter state name"); return false; }
		if(stc==''){ alert("enter state code"); return false; }
		if(cyid==''){ alert("select country"); return false; }
		

		$.post("mastersAjax.php",{ act:'saveStateDetails',stn:stn , stc:stc , cyid:cyid , ssts:ssts,id:id },function(data) {
                          
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
		var stn  = $('#stn').val();
		var stc = $('#stc').val();
		var cyid  = $('#cyid').val();
		var ssts  = $('#ssts').val();
		
		if(stn==''){ alert("enter state name"); return false; }
		if(stc==''){ alert("enter state code"); return false; }
		if(cyid==''){ alert("select country"); return false; }

		$.post("mastersAjax.php",{ act:'addState',stn:stn , stc:stc ,cyid:cyid , ssts:ssts },function(data) {
                                                    
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


