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

	<div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;height: 250px;width:850px;overflow:scroll;">

		<h6 style="font-weight: bold;">Apps Version</h6>

		<table id="vtable" class=" estable table table-bordered">
			<thead>
			<tr>
				<!--<th rowspan="2" style="width:50px;">Sn</th>-->
				<th rowspan="2" style="width:80px;">Version</th>
				<th colspan="2">Kharif Date</th>
				<th colspan="2">Rabi Date</th>
				<th colspan="2">Summer Date</th>
				<th rowspan="2" style="width:100px;">Action</th>
			</tr>
			<tr>
				<th style="width:100px;">From</th>
				<th style="width:100px;">To</th>
				<th style="width:100px;">From</th>
				<th style="width:100px;">To</th>
				<th style="width:100px;">From</th>
				<th style="width:100px;">To</th>
			</tr>
			</thead>
			<tbody>

			<?php

			$allcr=mysql_query('SELECT * FROM `app_version`');
            $sn=1;
			while($allcrd=mysql_fetch_assoc($allcr)){
			?>

			<tr>

			    <?php /*?><td><?=$sn;?></td><?php */?>

				<td style="text-align:center;">

				<input id="crn<?=$allcrd['VersionId']?>" style="text-align:center;"  value="<?=$allcrd['VersionD']?>" required>

				</td>

				<td><input id="kdf" name="kdf" style="width:100%;text-align:center;" value="<?=date("d-m-Y",strtotime($allcrd['Kharif_From']));?>"/></td>

				<td><input type="text" id="kdt" name="kdt" style="width:100%;text-align:center;" value="<?=date("d-m-Y",strtotime($allcrd['Kharif_To']));?>"/></td>

				<script language="javascript">

		        $('#kdf').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#kdf').val(); });

		        $('#kdt').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#kdt').val(); });

		        </script>

				<td><input id="rdf" name="rdf" style="width:100%;text-align:center;" value="<?=date("d-m-Y",strtotime($allcrd['Rabi_From']));?>"/></td>

				<td><input type="text" id="rdt" name="rdt" style="width:100%;text-align:center;" value="<?=date("d-m-Y",strtotime($allcrd['Rabi_To']));?>"/></td>

				<script language="javascript">

		        $('#rdf').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#rdf').val(); });

		        $('#rdt').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#rdt').val(); });

		        </script>

				
				
				<td><input id="sdf" name="sdf" style="width:100%;text-align:center;" value="<?=date("d-m-Y",strtotime($allcrd['Summer_From']));?>"/></td>

				<td><input type="text" id="sdt" name="sdt" style="width:100%;text-align:center;" value="<?=date("d-m-Y",strtotime($allcrd['Summer_To']));?>"/></td>

				<script language="javascript">

		        $('#sdf').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#sdf').val(); });

		        $('#sdt').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#sdt').val(); });

		        </script>

				<td>
				

					<button id="ebtn<?=$allcrd['VersionId']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allcrd['VersionId']?>')">Edit</button>

					<button id="sbtn<?=$allcrd['VersionId']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allcrd['VersionId']?>')" style="display:none;" >Save</button>

					<button id="cbtn<?=$allcrd['VersionId']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allcrd['VersionId']?>')" style="display:none;">Cancel</button>

					

			

				</td>

			</tr>

			

			<?php

			$sn++;}

			?>	

			</tbody>

		</table>

		

		

		<br />

		

	</div>

	

	



</div>





<script type="text/javascript">

	function editd(id){

		$('#showcrn'+id).hide();

		//$('#crn'+id).show();

		$('#ebtn'+id).hide();

		$('#sbtn'+id).show();

		$('#cbtn'+id).show();

	}



	function cancd(id){

		$('#showcrn'+id).show();

		//$('#crn'+id).hide();

		$('#ebtn'+id).show();

		$('#sbtn'+id).hide();

		$('#cbtn'+id).hide();

	}



	function saved(id){

		var crn  = $('#crn'+id).val();
		var kdf  = $('#kdf').val();
		var kdt  = $('#kdt').val();
		var rdf  = $('#rdf').val();
		var rdt  = $('#rdt').val(); 
		var sdf  = $('#sdf').val();
		var sdt  = $('#sdt').val();
		
		
		//alert(kdf+"-"+kdt+"-"+rdf+"-"+rdt+"-"+sdf+"-"+sdt);

		if(crn==''){ alert("enter version name"); return false; }

		$.post("appversionAjax.php",{ act:'vdetails',crn:crn,kdf:kdf,kdt:kdt,rdf:rdf,rdt:rdt,id:id,sdf:sdf,sdt:sdt },function(data) { 

                          

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





	function editp(th,id){

		$(th).hide();

		$('#spbtn'+id).show();

		$('#pertr'+id).show();



	}



	$(document).ready(function() {

	    $('#vtable').DataTable();

	} );

</script>





