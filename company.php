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

<div class="pagethings" style="width:82%;">

	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<button id="addstbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addsttbl').show(500);$(this).hide(500);">Add Company</button>

	<div id="addsttbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New Company</h6>
		<table class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th style="width:200px !important;">Company Name <font color="#FF0000">*</font></th>
				<th style="width:50px !important;">Code <font color="#FF0000">*</font></th>
				<th style="width:100px !important;">Contact</th>
				<th style="width:150px !important;">Mail</th>
				<th>Address</th>
				<th style="width:60px !important;">Status</th>
				<th style="width:100px !important;">Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td><input class="form-control frminp" style="float: left;" id="comn" ></td>
				<td><input class="form-control frminp" id="comc" ></td>
		        <td><input class="form-control frminp" id="comcont" ></td>
				<td><input class="form-control frminp" style="float: left;" id="commail" ></td>
				<td><input class="form-control frminp" style="float: left;" id="comadd" ></td>
				<td>
					<select id="coms" class="form-control frminp">
						<option disabled >Select</option>
						<option value="A">Active</option>
						<option value="D">Deactive</option>
					</select>
				</td>
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addst()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addsttbl').hide(500);$('#addstbtn').show(500);">Cancel</button>
				</td>
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addsttbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;">
		<h6 style="font-weight: bold;">Company</h6>
		<table id="comtable" class="estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th style="width:200px !important;">Company Name <font color="#FF0000">*</font></th>
				<th style="width:50px !important;">Code <font color="#FF0000">*</font></th>
				<th style="width:100px !important;">Contact</th>
				<th style="width:150px !important;">Mail</th>
				<th>Address</th>
				<th style="width:60px !important;">Status</th>
				<th style="width:120px !important;">Action</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$alls=mysql_query('SELECT * FROM `company`');

			while ($allsd=mysql_fetch_assoc($alls)) {
			?>
			<tr>
				<td>
					<span id="showcomn<?=$allsd['comid']?>" style="float: left;"><?=$allsd['com_name']?></span>
					<input class="form-control frminp nshw" id="comn<?=$allsd['comid']?>" value="<?=$allsd['com_name']?>" >
				</td>
				<td   style="width: 50px !important;">
					<span id="showcomc<?=$allsd['comid']?>"><?=$allsd['com_code']?></span>
					<input class="form-control frminp nshw" id="comc<?=$allsd['comid']?>" value="<?=$allsd['com_code']?>" >
				</td>
				<td>
					<span id="showcomcont<?=$allsd['comid']?>"><?=$allsd['com_contact']?></span>
			<input class="form-control frminp nshw" id="comcont<?=$allsd['comid']?>" value="<?=$allsd['com_contact']?>" >
				</td>
				<td>
					<span id="showcommail<?=$allsd['comid']?>" style="float: left;"><?=$allsd['com_mail']?></span>
			<input class="form-control frminp nshw" id="commail<?=$allsd['comid']?>" value="<?=$allsd['com_mail']?>" >
				</td>
				<td>
					<span id="showcomadd<?=$allsd['comid']?>" style="float: left;"><?=$allsd['address']?></span>
			<input class="form-control frminp nshw" id="comadd<?=$allsd['comid']?>" value="<?=$allsd['address']?>" >
				</td>
				<td>
				    <span id="showcoms<?=$allsd['comid']?>"><?=$allsd['com_sts']?></span>
					<select id="coms<?=$allsd['comid']?>" class="form-control frminp nshw">
						<option disabled >Select</option>
						<option value="A" <?=($allsd['com_sts']=='A')?'selected':'';?> >Active</option>
						<option value="D" <?=($allsd['com_sts']=='D')?'selected':'';?> >Deactive</option>
					</select>
				</td>
				
				<td>
					<button id="ebtn<?=$allsd['comid']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allsd['comid']?>')">Edit</button>
					<button id="sbtn<?=$allsd['comid']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allsd['comid']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$allsd['comid']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allsd['comid']?>')" style="display:none;">Cancel</button>
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
		$('#showcomn'+id).hide();
		$('#showcomc'+id).hide();
		$('#showcomcont'+id).hide();
		$('#showcommail'+id).hide();
		$('#showcomadd'+id).hide();
		$('#showcoms'+id).hide();
		

		$('#comn'+id).show();
		$('#comc'+id).show();
		$('#comcont'+id).show();
		$('#commail'+id).show();
		$('#comadd'+id).show();
		$('#coms'+id).show();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){
		$('#showcomn'+id).show();
		$('#showcomc'+id).show();
		$('#showcomcont'+id).show();
		$('#showcommail'+id).show();
		$('#showcomadd'+id).show();
		$('#showcoms'+id).show();

			$('#comn'+id).hide();
		$('#comc'+id).hide();
		$('#comcont'+id).hide();
		$('#commail'+id).hide();
		$('#comadd'+id).hide();
		$('#coms'+id).hide();

			$('#ebtn'+id).show();
			$('#sbtn'+id).hide();
			$('#cbtn'+id).hide();
		
	}

	function saved(id){  
		var comn  = $('#comn'+id).val();
		var comc = $('#comc'+id).val();
		var comcont  = $('#comcont'+id).val();
		var commail  = $('#commail'+id).val();
		var comadd  = $('#comadd'+id).val();
		var coms  = $('#coms'+id).val();
		
		if(comn==''){ alert("enter company name"); return false; }
		if(comc==''){ alert("enter company code"); return false; }

		$.post("mastersAjaxx.php",{ act:'saveCompanyDetails',comn:comn, comc:comc , comcont:comcont , coms:coms , commail:commail , comadd:comadd ,id:id },function(data) { 
                          
			if(data.includes("updated")){

				$("#savmsg").show(300);
				setTimeout(function(){ $("#savmsg").hide(300); }, 5000);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
			$('#showcomn'+id).show();
		$('#showcomc'+id).show();
		$('#showcomcont'+id).show();
		$('#showcommail'+id).show();
		$('#showcomadd'+id).show();
		$('#showcoms'+id).show();

		$('#comn'+id).hide();
		$('#comc'+id).hide();
		$('#comcont'+id).hide();
		$('#commail'+id).hide();
		$('#comadd'+id).hide();
		$('#coms'+id).hide();

			$('#ebtn'+id).show();
			$('#sbtn'+id).hide();
			$('#cbtn'+id).hide();
          }
        );

		
	}


	function addst(){ 
		var comn  = $('#comn').val();
		var comc = $('#comc').val();
		var comcont  = $('#comcont').val();
		var commail  = $('#commail').val();
		var comadd  = $('#comadd').val();
		var coms  = $('#coms').val(); 

        //alert(comn+"-"+comc+"-"+comcont+"-"+commail+"-"+comadd);
		if(comn==''){ alert("enter company name"); return false; }
		if(comc==''){ alert("enter company code"); return false; }

		$.post("mastersAjaxx.php",{ act:'addCompany',comn:comn, comc:comc , comcont:comcont , coms:coms , commail:commail , comadd:comadd },function(data) { //alert(data);
		
                                                    
			if(data.includes("added")){
				$('#addsttbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = 'company.php';  }, 800);

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
	    $('#comtable').DataTable();
	} );
</script>


