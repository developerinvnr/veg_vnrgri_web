<?php 
session_start();
include 'cdns.php'; 
include 'config.php'; 
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
	.lightlabel{
		background-color: #ccc !important;
		padding-left: 5px !important;
		font-size: 12px;
		font-weight: bold;
		padding: 0px;
	}
	.fstable tbody th{
	  color: #000;
	  font-size: 12px;
	  font-weight: bold;
	  padding: 5px !important;
	}

	.fstable tbody td{
	  padding: 1px;
	}
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
	body{
		background-color: #EDEDED;
	}
	.estable thead th,.estable tbody th,.estable tbody td{
	  font-size: 12px !important;
	  padding: 1px 2px !important;
	  text-align: center;
	  font-weight: 500;
	  border:2px solid #ccc;
	  margin:0px;
	}
	.estable thead th{
	  background-color:#b7e0f4;
	  color: #000;
	  font-size: 13px;
	  font-weight: bold;
	  padding: 7px 3px !important;
	}

	.estable tbody td{
	  background-color: #fff !important;
	}

</style>
<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>
<?php
if(isset($_REQUEST['added']) && $_REQUEST['added']=='yes'){
	?>
	<script type="text/javascript">
		$("#savmsg").show(300);
		setTimeout(function(){ $("#savmsg").hide(300);  }, 3000);
	</script>
	<?php
}
?>

<?php
/*============================================
here taking all the data from tables and putting on a array, 
so in below loop we don't have to fetch all data again and again...
==============================================*/
$allf=mysql_query('SELECT * FROM `farmers`');
while ($allfd=mysql_fetch_assoc($allf)) {
	$farr[$allfd['fid']]=$allfd['fname'];
}

$allo=mysql_query('SELECT * FROM `organiser`');
while ($allod=mysql_fetch_assoc($allo)) {
	$oarr[$allod['oid']]=$allod['oname'];
}

$allc=mysql_query('SELECT * FROM `company`');
while ($allcd=mysql_fetch_assoc($allc)) {
	$carr[$allcd['comid']]=$allcd['com_name'];
}

$allu=mysql_query('SELECT * FROM `users`');
while ($allud=mysql_fetch_assoc($allu)) {
	$uarr[$allud['uId']]=$allud['uName'];
}

$allcr=mysql_query('SELECT * FROM `crop` order by cropname');
while ($allcrd=mysql_fetch_assoc($allcr)) {
	$crarr[$allcrd['cropid']]=$allcrd['cropname'];
}




$agr=mysql_query("SELECT * FROM `agreement_".$_SESSION['year']."` where agree_id=".$_REQUEST['agid']);
$agrd=mysql_fetch_assoc($agr);
?>




<form id="agreementtable"  enctype="multipart/form-data" method="post" action="agreementprocess.php">
	
	<table class=" fstable table table-bordered">
		
		<tbody>
		<tr>
			<td colspan="8" class="lightlabel" style="text-align: center;font-size: 20px;">Seed Production Agreement</td>
		</tr>
		<tr>
			<th>First Party</th>
			<td>
				<select class="form-control frminp" name="firstparty" id="firstparty" required>
					
					<?php foreach ($carr as $key => $value) { ?>
					<option value="<?=$key?>" <?=($agrd['first_party']==$key)?'selected':'';?> ><?=$value?></option>
					<?php } ?>
				</select>
				
			</td>
			<th>Second Party</th>
			<td>
				<select class="form-control frminp" name="secondparty" id="secondparty" required>
					<option  >Select</option>
					<?php foreach ($farr as $key => $value) { ?>
					<option value="<?=$key?>" <?=($agrd['second_party']==$key)?'selected':'';?>  ><?=$value?></option>
					<?php } ?>
				</select>
				<script type="text/javascript">
					$('#secondparty').on('change', function() {
						var fid=$('#secondparty').val();
					  	$.post("mastersAjax.php",{ act:'getOrganiser',fid:fid },function(data) {
							$('#organiser').html(data);
				          }
				        );
				        $.post("mastersAjax.php",{ act:'getProdPerson',fid:fid },function(data) {
							$('#pperson').html(data);
				          }
				        );
				        
					});
				</script>
			</td>
			<th>Organiser</th>
			<td style="width: 200px;">
				<select class="form-control frminp" name="organiser" id="organiser" required>
					<option  >Select</option>
					<?php foreach ($oarr as $key => $value) { ?>
					<option value="<?=$key?>" <?=($agrd['org_id']==$key)?'selected':'';?>  ><?=$value?></option>
					<?php } ?>
				</select>
			</td>

			
		</tr>
		<tr>
			<th>Agreement Date</th>
			
			<td>
				<input class="form-control frminp" name="agreedate" id="agreedate" autocomplete="off" value="<?=date('d-m-Y',strtotime($agrd['agree_date']))?>">
			</td>
			<script>
			$('#agreedate').datepicker({format:'dd-mm-yyyy',}).on('change', function(){
				var date = $('#agreedate').val();
				$('#agreefrom').val(date);	
				var agreefrom = new Date(date.split("-").reverse().join("-"));		
				agreefrom.setMonth( agreefrom.getMonth() + 7 );
				var y=agreefrom.getFullYear();
				var m=agreefrom.getMonth();
				var d=agreefrom.getDate();
				if(d.toString().length == 1){ d = '0'+d; }
				if(m.toString().length == 1){ m = '0'+m; }
				$('#agreeto').val(d+'-'+m+'-'+y);				
		    });
			</script>
			
			<th>Period</th>
			<td>
				<input class="form-control frminp" name="agreefrom" id="agreefrom" placeholder="From" style="width: 110px;float: left;" value="<?=date('d-m-Y',strtotime($agrd['start_date']))?>">
				<script>
				$('#agreefrom').datepicker({format:'dd-mm-yyyy',}).on('change', function(){
					var date = $('#agreefrom').val();
					var agreefrom = new Date(date.split("-").reverse().join("-"));
					agreefrom.setMonth( agreefrom.getMonth() + 7 );
					var y=agreefrom.getFullYear();
					var m=agreefrom.getMonth();
					var d=agreefrom.getDate();
					if(d.toString().length == 1){ d = '0'+d; }
					if(m.toString().length == 1){ m = '0'+m; }
					$('#agreeto').val(d+'-'+m+'-'+y);
			    });
				</script>
				<input class="form-control frminp" name="agreeto" id="agreeto" placeholder="To" style="width: 110px;float: left;" value="<?=date('d-m-Y',strtotime($agrd['end_date']))?>">
			</td>
			<th>Production Person</th>
			<td style="width: 200px;">
				
				<select class="form-control frminp" name="pperson" id="pperson" required>
					<option  >Select</option>
					<?php foreach ($uarr as $key => $value) { ?>
					<option value="<?=$key?>" <?=($agrd['prod_person']==$key)?'selected':'';?>  ><?=$value?></option>
					<?php } ?>
				</select>
			</td>
			
		</tr>

		<tr>
			<td colspan="8" >
				
				<table class=" estable table table-bordered">
					<thead>
						<tr>
							<th rowspan="2">Crop</th>
							<th rowspan="2">Type</th>
							<th rowspan="2">Production Code</th>
							<th colspan="4">FS Code</th>
						</tr>
						<tr>
							<th colspan="2">Female</th>
							<th colspan="2">Male</th>
						</tr>
					</thead>
					<tbody id="farLandtbodya">
						<tr>
							<td>
								<select class="form-control frminp" name="ann_crop" id="ann_crop" required onchange="getAllCropDetails()">
									<option  disabled selected >Select</option>
									<?php foreach ($crarr as $key => $value) { ?>
									<option value="<?=$key?>"  ><?=$value?></option>
									<?php } ?>
								</select>
								
							</td>
							<td >
								<select class="form-control frminp" id="ann_ophyb" name="ann_ophyb" required onchange="getAllCropDetails()">
									<option disabled selected>Select</option>
									<option value="OP">OP</option>
									<option value="HYB">HYB</option>
								</select>
								<script type="text/javascript">
									function getAllCropDetails(){
										var cid=$('#ann_crop').val();
										var ctype=$('#ann_ophyb').val();

										if(cid!=null && ctype!=null){

											$('#an2type').html(ctype);
											$('#an4type').html(ctype);

											$('#an1crop').html($( "#ann_crop option:selected" ).text());
											$('#an2crop').html($( "#ann_crop option:selected" ).text());
											$('#an4crop').html($( "#ann_crop option:selected" ).text());
											$('#an4acrop').html($( "#ann_crop option:selected" ).text());
											$('#an5crop').html($( "#ann_crop option:selected" ).text());

										  	$.post("mastersAjax.php",{ act:'get_production_code',cid:cid,ctype:ctype  },function(data) {
												$('#ann_prodcode').val(data);
												$('#an1prodcode').html(data);
												
									          }
									        );
									        $.post("mastersAjax.php",{ act:'get_fs_code_female1',cid:cid,ctype:ctype  },function(data) {
												$('#fsfemale1').val(data);
												$('#an1f1').html(data);
												$('#an2f1').html(data);
												$('#an4f1').html(data);
												$('#an4af1').html(data);
												$('#an5f1').html(data);
									          }
									        );
									        $.post("mastersAjax.php",{ act:'get_fs_code_female2',cid:cid,ctype:ctype  },function(data) {
												$('#fsfemale2').val(data);
												$('#an1f2').html(data);
												$('#an2f2').html(data);
												$('#an4f2').html(data);
												$('#an4af2').html(data);
												$('#an5f2').html(data);
									          }
									        );
									        $.post("mastersAjax.php",{ act:'get_fs_code_male1',cid:cid,ctype:ctype  },function(data) {
												$('#fsmale1').val(data);
												$('#an1m1').html(data);
												$('#an2m1').html(data);
												$('#an4m1').html(data);
												$('#an4am1').html(data);
												$('#an5m1').html(data);
									          }
									        );
									        $.post("mastersAjax.php",{ act:'get_fs_code_male2',cid:cid,ctype:ctype  },function(data) {
												$('#fsmale2').val(data);
												$('#an1m2').html(data);
												$('#an2m2').html(data);
												$('#an4m2').html(data);
												$('#an4am2').html(data);
												$('#an5m2').html(data);
									          }
									        );

											$.post("mastersAjax.php",{ act:'get_germ',cid:cid,ctype:ctype },function(data) {
												$('#ann1_germination_per').val(data);
									          }
									        );
									        $.post("mastersAjax.php",{ act:'get_genpur',cid:cid,ctype:ctype },function(data) {
												$('#ann1_genetic_purity').val(data);
									          }
									        );
									        $.post("mastersAjax.php",{ act:'get_phypur',cid:cid,ctype:ctype },function(data) {
												$('#ann1_physical_purity').val(data);
									          }
									        );
									        $.post("mastersAjax.php",{ act:'get_moisture',cid:cid,ctype:ctype},function(data) { 
												$('#ann1_moisure').val(data);
									          }
									        );
									        $.post("mastersAjax.php",{ act:'get_est_yield',cid:cid,ctype:ctype},function(data) {
												$('#ann4_estiyield_rawqty').val(data);
									          }
									        );
									    }
									}
									
								</script>
								
							</td>
							<td ><input id="ann_prodcode" name="ann_prodcode"></td>
							<td ><input id="fsfemale1" name="fsfemale1"></td>
							<td ><input id="fsfemale2" name="fsfemale2"></td>
							<td ><input id="fsmale1" name="fsmale1"></td>
							<td ><input id="fsmale2" name="fsmale2"></td>
							
						</tr>
					</tbody>
				</table>
				
				<style type="text/css">
					.tabnav{
						cursor: pointer;
					}
					.antable{
					  margin:20 auto;
					}
					.antable thead th{
					  background-color:#ccc;
					  border:2px solid #b3b3b3;
					}
					
				</style>
				
				<table class=" estable table table-bordered">
					<thead >
						<tr>
							<th rowspan="2"  class="tabnav"  onclick="showtr('trSoil',this)" style="background-color: white;">
								<a>Soil Details</a>
							</th>
							<th colspan="9">Annexure</th>
						</tr>
						<tr>
							<th  class="tabnav"  onclick="showtr('trI',this)">
								I
							</th>
							<th class="tabnav" onclick="showtr('trII',this)">
								II
							</th>
							<th class="tabnav" onclick="showtr('trIII',this)">
								III
							</th>
							<th class="tabnav" onclick="showtr('trIV',this)">
								IV
							</th>
							<th class="tabnav" onclick="showtr('trIVA',this)">
								IV(A)
							</th>
							<th class="tabnav" onclick="showtr('trV',this)">
								V
							</th>
							<th class="tabnav" onclick="showtr('trVI',this)">
								VI
							</th>
							<th class="tabnav" onclick="showtr('trVII',this)">
								VII
							</th>
							<th class="tabnav" onclick="showtr('trVIII',this)">
								VIII
							</th>
						</tr>
					</thead>
					<script type="text/javascript">
						$('.tabnav').css('color', 'blue');

						function showtr(id,th){
							$('.tabnav').css('color', 'blue');
							
							$(th).css('color', 'black');
							$('.tabnav').css("cssText", "background-color: #B7E0F4 !important;color:blue;");
							$(th).css("cssText", "background-color: white !important;");

							$('.tabthings').hide();
							$('#'+id).show();
						}
					</script>
					<tbody>
						<tr id="trSoil" class="tabthings" >
							<td colspan="20">
								<h6 style="margin-top:10px;margin-bottom: -15px;">Soil Details</h6>
								<table class="antable">
									<thead style="background-color: #cccccc !important;">
										<tr>
											<th >WATER AVAILABILITYY</th>
											<th >TOPOGRAPHY OF THE LAND</th>
											<th >TYPE OF LAND</th>
											<th >SOIL TYPE</th>
											<th >EXTENT OF CULTIVABILITY</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											
											<td>
												<select name="water_availability">
													<option value="Sufficient" selected="">Sufficient</option>
											        <option value="Suitable">Suitable</option>
											        <option value="Yes">Yes</option>
											        <option value="No">No</option>
											    </select>
											</td>
											<td>
												<select name="topography_land">
													<option value="Sufficient" selected="">Sufficient</option>
											        <option value="Suitable">Suitable</option>
											        <option value="Yes">Yes</option>
											        <option value="No">No</option>
											    </select>
											</td>
											<td>
												<select name="typeof_land">
													<option value="Sufficient" selected="">Sufficient</option>
											        <option value="Suitable">Suitable</option>
											        <option value="Yes">Yes</option>
											        <option value="No">No</option>
											    </select>
											</td>
											<td>
												<select name="soil_type">
													<option value="Sufficient" selected="">Sufficient</option>
											        <option value="Suitable">Suitable</option>
											        <option value="Yes">Yes</option>
											        <option value="No">No</option>
											    </select>
											</td>
											<td>
												<select name="extent_cultivability">
													<option value="Sufficient" selected="">Sufficient</option>
											        <option value="Suitable">Suitable</option>
											        <option value="Yes">Yes</option>
											        <option value="No">No</option>
											    </select>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr id="trI" class="tabthings" style="display: none;" >
							<td colspan="20">
								<h6 style="margin-top:10px;margin-bottom: -15px;">Annexure-I</h6>
								<table class="antable">
									<thead style="background-color: #cccccc !important;">
										<tr>
											<th rowspan="2">Crop</th>
											<th colspan="4">FS Code</th>
											<th rowspan="2">Production Code</th>
											<th rowspan="2">Germination %</th>
											<th rowspan="2">Genetic Purity %</th>
											<th rowspan="2">Physical Purity %</th>
											<th rowspan="2">Moisture %</th>
										</tr>
										<tr>
											<th colspan="2">Female</th>
											<th colspan="2">Male</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td id="an1crop"></td>
											<td id="an1f1"></td>
											<td id="an1f2"></td>
											<td id="an1m1"></td>
											<td id="an1m2"></td>
											<td id="an1prodcode"></td>
											<td>
												<input type="" name="ann1_germination_per" id="ann1_germination_per">
											</td>
											<td>
												<input type="" name="ann1_genetic_purity" id="ann1_genetic_purity">
											</td>
											<td>
												<input type="" name="ann1_physical_purity" id="ann1_physical_purity">
											</td>
											<td>
												<input type="" name="ann1_moisure" id="ann1_moisure">
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr id="trII" class="tabthings" style="display: none;">
							<td colspan="20">
								<h6 style="margin-top:10px;margin-bottom: -15px;">Annexure-II</h6>
								<table class="antable">
									<thead style="background-color: #cccccc !important;">
										<tr>
											<th rowspan="2">Crop</th>
											<th colspan="4">FS Code</th>
											<th rowspan="2">OP/Hyb</th>
											<th rowspan="2">Basic procurement price/kg</th>
											<th rowspan="2">Quality based Incentive price per kg</th>
											<th rowspan="2">Payment within days after delivery</th>
											
										</tr>
										<tr>
											<th colspan="2">Female</th>
											<th colspan="2">Male</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td id="an2crop"></td>
											<td id="an2f1"></td>
											<td id="an2f2"></td>
											<td id="an2m1"></td>
											<td id="an2m2"></td>
											<td id="an2type"></td>
											<td>
												<input type="" name="ann2_procmnt_price">
											</td>
											<td>
												<input type="" name="ann2_qualbased_inc_price">
											</td>
											<td>
												<input type="" name="ann2_payment_within_day">
											</td>
											
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr id="trIII" class="tabthings" style="display: none;">
							<td colspan="20">
								<h6 style="margin-top:10px;margin-bottom: -15px;">Annexure-III</h6>
								<table class="antable">
									<thead style="background-color: #cccccc !important;">
										<tr>
											<th >Type</th>
											<th >Price(Rs)</th>											
										</tr>
									
									</thead>
									<tbody>
										<tr>
											<td>
												Additional Fees in case of male chopping, removal and destruction
											</td>
											<td>
												<input type="" name="ann3_additional_fee">
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr id="trIV" class="tabthings" style="display: none;">
							<td colspan="20">
								<h6 style="margin-top:10px;margin-bottom: -15px;">Annexure-IV</h6>
								<table class="antable">
									<thead style="background-color: #cccccc !important;">
										<tr>
											<th rowspan="2">Crop</th>
											<th colspan="4">FS Code</th>
											<th rowspan="2">OP/Hyb</th>
											<th rowspan="2">Estimated Yield<br>(Raw qty in kg)</th>								
										</tr>
										<tr>
											<th colspan="2">Female</th>
											<th colspan="2">Male</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td id="an4crop"></td>
											<td id="an4f1"></td>
											<td id="an4f2"></td>
											<td id="an4m1"></td>
											<td id="an4m2"></td>
											<td id="an4type"></td>
											<td>
												<input type="" name="ann4_estiyield_rawqty" id="ann4_estiyield_rawqty">
											</td>											
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr id="trIVA" class="tabthings" style="display: none;">
							<td colspan="20">
								<h6 style="margin-top:10px;margin-bottom: -15px;">Annexure-IV(A)</h6>
								<table class="antable">
									<thead style="background-color: #cccccc !important;">
										<tr>
											<th rowspan="2">Crop</th>
											<th colspan="4">FS Code</th>
											<th rowspan="2">Loss of Yield</th>								
										</tr>
										<tr>
											<th colspan="2">Female</th>
											<th colspan="2">Male</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td id="an4acrop"></td>
											<td id="an4af1"></td>
											<td id="an4af2"></td>
											<td id="an4am1"></td>
											<td id="an4am2"></td>
											<td>
												<input type="" name="ann4a_loss_ofyield">
											</td>											
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr id="trV" class="tabthings" style="display: none;">
							<td colspan="20">
								
								<h6 style="margin-top:10px;margin-bottom: -15px;">Cost of FS Seed</h6>
								<table class="antable">
									<thead style="background-color: #cccccc !important;">
										<tr>
											<th rowspan="2">Crop</th>
											<th colspan="4">FS Code</th>						
											<th rowspan="2">Rate</th>								
											<th rowspan="2">Parental Seed<br>Per Acre</th>								
											<th rowspan="2">No of Acres of Plants</th>								
											<th rowspan="2">Plants Material Supply</th>								
											<th rowspan="2">Total Amount</th>								
										</tr>
										<tr>
											<th colspan="2">Female</th>
											<th colspan="2">Male</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td id="an5crop"></td>
											<td id="an5f1"></td>
											<td id="an5f2"></td>
											<td id="an5m1"></td>
											<td id="an5m2"></td>
											<td>
												<input type="" name="ann5_rate" id="ann5_rate" onkeyup="calCostFsSeed()">
											</td>		
											<td>
												<input type="" name="ann5_parental_seed" id="ann5_parental_seed" onkeyup="calCostFsSeed()">
											</td>
											<td>
												<input type="" name="ann5_noofacr_plant" id="ann5_noofacr_plant" onkeyup="calCostFsSeed()">
											</td>
											<td>
												<input type="" name="ann5_plant_matsupply" id="ann5_plant_matsupply" onkeyup="calCostFsSeed()">
											</td>
											<td>
												<input type="" name="totAmtOfFSSeed" id="totAmtOfFSSeed">
											</td>									
										</tr>
									</tbody>
								</table>
								<script type="text/javascript">
									function calCostFsSeed(){
										var rate = $('#ann5_rate').val();
										var parSeedPerAc = $('#ann5_parental_seed').val();
										var noOfAcOfPla = $('#ann5_noofacr_plant').val();
										var plaMatSup = $('#ann5_plant_matsupply').val();

										var tot = rate * (parSeedPerAc + noOfAcOfPla + plaMatSup);

										$('#totAmtOfFSSeed').val(tot);
									}
								</script>
							</td>
						</tr>
						<tr id="trVI" class="tabthings" style="display: none;">
							<td colspan="20">
								<h6 style="margin-top:10px;margin-bottom: -15px;">Health & Safety</h6>
								<br><br><br><br><br>
							</td>
						</tr>
						<tr id="trVII" class="tabthings" style="display: none;">
							<td colspan="20">
								<h6 style="margin-top:10px;margin-bottom: -15px;">Land Details</h6>
								<table class="antable">
									<thead style="background-color: #cccccc !important;">
										<tr>
											<th>Acres</th>
											<th>Survey Number</th>										
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<input type="" name="ann7_areain_acre" id="ann7_areain_acre" >
											</td>
											<td>
												<input type="" name="ann7_surveyno" id="ann7_surveyno">
											</td>									
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr id="trVIII" class="tabthings" style="display: none;">
							<td colspan="20">
								<h6 style="margin-top:10px;margin-bottom: -15px;">Power of Attorney</h6>
								<br><br><br><br><br>
							</td>
						</tr>
					</tbody>
				</table>


				

				<input type="hidden" id="landcount" name="landcount" value="0">
				<!-- <button type="button" class="btn btn-sm btn-primary frmbtn" style="float: right;margin-top: -20px;" onclick="addfarmerland()"><i class="fa fa-plus" aria-hidden="true"></i>Add</button> -->

				<script type="text/javascript">
					function addfarmerland(){
						var lc=parseInt($('#landcount').val());
						lc=lc+1;
						$('#landcount').val(lc);
						$.post("mastersAjax.php",{ act:'addFarmerLand',lc:lc },function(data) {
							$('#farLandtbody').append(data);
				          }
				        );
					}
					$(document).ready(function() {
						var lc=1;
					    while(lc<=1){
					    	addfarmerland();
					    	lc++;
					    }
					});
				</script>
				
			</td>
		</tr>
		<tr>
			<td colspan="10">
				
				<center>
				<button type="submit" name="saveagreement" id="addbtn" class="frmbtn btn btn-success btn-sm" style="width:100px;" onclick="" >Save</button>
				<button type="button" class="frmbtn btn btn-sm btn-danger" style="width:100px;" onclick="$('#addfartbl', window.parent.document).hide(500);window.parent.document.getElementById('addfarbtn').style.display='block';" >Cancel</button>
				</center>
			</td>
			
		</tr>
		
		</tbody>
		
	</table>
</form>
<script type="text/javascript">
	
	$('form input').keydown(function (e) {
	    if (e.keyCode == 13) {
	        var inputs = $(this).parents("form").eq(0).find(":input");
	        if (inputs[inputs.index(this) + 1] != null) {                    
	            inputs[inputs.index(this) + 1].focus();
	        }
	        e.preventDefault();
	        return false;
	    }
	});

	function removethistr(th){
		var whichtr = $(th).closest("tr");
		whichtr.remove();   
	}

	function setInputFilter(textbox, inputFilter) {
	  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
	    textbox.addEventListener(event, function() {
	      if (inputFilter(this.value)) {
	        this.oldValue = this.value;
	        this.oldSelectionStart = this.selectionStart;
	        this.oldSelectionEnd = this.selectionEnd;
	      } else if (this.hasOwnProperty("oldValue")) {
	        this.value = this.oldValue;
	        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
	      }
	    });
	  });
	}

	setInputFilter(document.getElementById("contact_1"), function(value) {
	  return /^\d*$/.test(value) && (value.length <=10); 
	});
	setInputFilter(document.getElementById("contact_2"), function(value) {
	  return /^\d*$/.test(value) && (value.length <=10); 
	});


</script>