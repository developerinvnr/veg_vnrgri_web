<div id="loaderDiv" style="background-color: rgba(0,0,0,0.8);width: 100%;height: 100%;position: fixed;top:0px;left: 0px;font-size: 12px;">
	
	<center>
	<span style="color:white;top: 40%;left:36%;position: absolute;">Please Wait, Loading data's required for filling form...<img src="image/loader.gif"></span>
	</center>
</div>


<?php 
include 'cdns.php'; 
include 'config.php'; 
session_start();
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
<script type="text/javascript" language="javascript">
function toUpper(txt)
{ document.getElementById(txt).value=document.getElementById(txt).value.toUpperCase(); return true; }
</script>
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
here taking all the districts and putting on a array, 
so in below Tahsil loop we don't have to fetch all states again and again...
==============================================*/
/*
$alls=mysql_query("SELECT * FROM `state` s inner join user_location l on l.state_id=s.StateId where l.uid=".$_SESSION['uId']." AND l.sts='A' order by StateName"); 
while ($allsd=mysql_fetch_assoc($alls)){
	$sarr[$allsd['StateId']]=$allsd['StateName'];
}

$alld=mysql_query("SELECT * FROM `distric` d, user_location ul where ul.district_id=d.DictrictId and ul.sts='A' and ul.uid='".$_SESSION['uId']."' order by DictrictName asc"); 
while ($alldd=mysql_fetch_assoc($alld)){
	$darr[$alldd['DictrictId']]=strtoupper($alldd['DictrictName']);
}

$allt=mysql_query("SELECT TahsilId,TahsilName FROM `tahsil` t inner join distric d on t.DistrictId=d.DictrictId inner join state s on d.StateId=s.StateId inner join user_location l on l.state_id=s.StateId where l.uid=".$_SESSION['uId']." AND l.sts='A' order by TahsilName"); 
while ($alltd=mysql_fetch_assoc($allt)){
	$tarr[$alltd['TahsilId']]=strtoupper($alltd['TahsilName']);
}

$allv=mysql_query("SELECT VillageId,VillageName FROM `village` v inner join tahsil t on v.TahsilId=t.TahsilId inner join distric d on t.DistrictId=d.DictrictId inner join state s on d.StateId=s.StateId inner join user_location l on l.state_id=s.StateId where l.uid=".$_SESSION['uId']." AND l.sts='A' order by VillageName"); 
while ($allvd=mysql_fetch_assoc($allv)){
	$varr[$allvd['VillageId']]=strtoupper($allvd['VillageName']);
}

$allo=mysql_query("SELECT * FROM `organiser` o inner join user_location l on l.state_id=o.state_id where l.uid=".$_SESSION['uId']." AND l.sts='A'");
while($allod=mysql_fetch_assoc($allo))
{
 $oarr[$allod['oid']]=$allod['oname'];
}

*/
?>

<?php
/*============================================
here taking all the districts and putting on a array, 
so in below Tahsil loop we don't have to fetch all states again and again...
==============================================*/
/*
$alls=mysql_query("SELECT * FROM `state` s ,user_location l where l.state_id=s.StateId and l.uid=".$_SESSION['uId']." AND l.sts='A' order by StateName"); 
while ($allsd=mysql_fetch_assoc($alls)){
	$sarr[$allsd['StateId']]=$allsd['StateName'];
}

$alld=mysql_query("SELECT * FROM `distric` d, user_location ul where ul.district_id=d.DictrictId and ul.sts='A' and ul.uid='".$_SESSION['uId']."' order by DictrictName asc"); 
while ($alldd=mysql_fetch_assoc($alld)){
	$darr[$alldd['DictrictId']]=strtoupper($alldd['DictrictName']);
}

$allt=mysql_query("SELECT TahsilId,TahsilName FROM `tahsil` t, distric d,state s,user_location l where  l.uid=".$_SESSION['uId']." AND l.sts='A' and l.state_id=s.StateId and  d.StateId=s.StateId and t.DistrictId=d.DictrictId order by TahsilName"); 

while ($alltd=mysql_fetch_assoc($allt)){
	$tarr[$alltd['TahsilId']]=strtoupper($alltd['TahsilName']);
}

$allv=mysql_query("SELECT VillageId,VillageName FROM `village` v, tahsil t, distric d, state s,user_location l where l.uid=".$_SESSION['uId']." AND l.sts='A' and s.StateId=l.state_id and d.StateId=s.StateId and t.DistrictId=d.DictrictId and v.TahsilId=t.TahsilId  order by VillageName"); 

while ($allvd=mysql_fetch_assoc($allv)){
	$varr[$allvd['VillageId']]=strtoupper($allvd['VillageName']);
}

$allo=mysql_query("SELECT * FROM `organiser` o, user_location l where  l.state_id=o.state_id and  l.uid=".$_SESSION['uId']." AND l.sts='A'");
while($allod=mysql_fetch_assoc($allo))
{
 $oarr[$allod['oid']]=$allod['oname'];
}

*/

$sarr=$_SESSION['sarr'];
$darr=$_SESSION['darr'];
$tarr=$_SESSION['tarr'];
$varr=$_SESSION['varrtarr'];
$oarr=$_SESSION['oarr'];



?>

<form id="farmertable"  enctype="multipart/form-data" method="post" action="mastersAjax.php">
	<input type="hidden" name="act" value="addfarmer">
	<table class=" fstable table table-bordered" border="0">
		
		<tbody>
		
		<!--<tr><td colspan="8" class="lightlabel">General Details</td></tr>-->
		<tr>
		    <th>Organiser <font color="#FF0000">*</font></th>
			<td>
				<select class="form-control frminp" name="oid" id="oid" required>
					<option value="">Select</option>
					<?php foreach ($oarr as $key => $value) { ?>
					<option value="<?=$key?>" ><?=$value?></option>
					<?php } ?>
				</select>
			</td>
			<th>Farmer Name <font color="#FF0000">*</font></th>
			<td>
				<input class="form-control frminp" id="fname" name="fname" onKeyUp="return toUpper(this.id)" required>
			</td>
			<th>Contact 1 <font color="#FF0000">*</font></th>
			<td>
				<input class="form-control frminp" name="contact_1" id="contact_1" required>
				<input type="hidden" class="form-control frminp" name="contact_2" id="contact_2" value="0">
			</td>
			
		</tr>
		<tr>
			<th>DOB <font color="#FF0000">*</font></th>
			<td>
				<input class="form-control frminp" name="dob" id="dob" autocomplete="off" required>
			</td>
			<script>
			$('#dob').datepicker({format:'dd-mm-yyyy',}).on('change', function(){
				var date = $('#dob').val();
				var birth = date.split("-").reverse().join("-");
				var today = new Date();			
				birth = new Date(birth);		
			    var nowyear = today.getFullYear();
			    var birthyear = birth.getFullYear();
			    var age = nowyear - birthyear;
				$("#age").val(age);
		    });
			</script>
			<th>Age</th>
			<td>
				<input class="form-control frminp" name="age" id="age" readonly>
			</td>
			<th>Son of/ Wife of <font color="#FF0000">*</font></th>
			<td>
				<input class="form-control frminp" id="father_name" name="father_name" onKeyUp="return toUpper(this.id)" required>
			</td>
			
		</tr>
		<tr>
			<?php
			/*
			==================================================================================================
				here checking if the users allowed states have aadhar mandotory or not
			==================================================================================================
			*/
			$aadharPermitState=mysql_query("SELECT a.*,s.StateName FROM `aadhar_permission` a, state s, user_location ul where a.state_id=s.StateId and s.StateId=ul.state_id and ul.uid='".$_SESSION['uId']."' and ul.sts='A' and a.permission='A'");
			$aadharPermitStateNum = mysql_num_rows($aadharPermitState);
			?>
			<th>Id Proof <?php if($aadharPermitStateNum>0){ echo "<font color='#FF0000'>*</font>";} ?></th>
			<td>
				<select class="form-control frminp" name="idproof_name"  id="idproof_name" <?php if($aadharPermitStateNum>0){ echo "required";} ?>>
					<option disabled selected value="">Select</option>
					<option value="Aadhar">AADHAR</option>
					<option value="Driving Lic.">DRIVING LIC.</option>
					<option value="Voter ID">VOTER ID</option>
				</select>
				<script type="text/javascript">
					$('#idproof_name').on('change', function() {
					  if( $('#idproof_name').val() == 'Aadhar'){
					  	$("#addproof_name option[value='Aadhar']").hide();
					  }else{
					  	$("#addproof_name option[value='Aadhar']").show();

					  }
					});
				</script>
			</td>
			<th>Id Proof No <?php if($aadharPermitStateNum>0){ echo "<font color='#FF0000'>*</font>";} ?></th>
			<td>
				<input class="form-control frminp" name="idproof_no" <?php if($aadharPermitStateNum>0){ echo "required";} ?> >
			</td>
			<th>Id Proof Doc <?php if($aadharPermitStateNum>0){ echo "<font color='#FF0000'>*</font>";} ?></th>
			<td>
				<input class="form-control frminp" type="file" name="doc_idproof"  <?php if($aadharPermitStateNum>0){ echo "required";} ?> >
			</td>
			
			
		</tr>
		
		
		<tr>
		    <td style="color:#0078F0;font-size:12px; vertical-align:middle;">&nbsp;<b>Bank Details</b></td>
			<td colspan="7"><hr style="width:99%;background-color:#0078F0;margin-top:8px; margin-bottom:0px;"/></td>
		</tr>
		<tr>
			<th>Bank Name <font color="#FF0000">*</font></th>
			<td>
				<input class="form-control frminp" id="bank_name" name="bank_name" onKeyUp="return toUpper(this.id)" required>
			</td>
			<th>Account No <font color="#FF0000">*</font></th>
			<td>
				<input class="form-control frminp" name="account_no" required>
			</td>
			<th>Branch Name</th>
			<td>
				<input class="form-control frminp" id="branch_name" name="branch_name" onKeyUp="return toUpper(this.id)" >
			</td>
			
			 
		</tr>
		<tr>
			<th>IFSC Code <font color="#FF0000">*</font></th>
			<td>
				<input class="form-control frminp" name="ifsc_code" required>
			</td>
			<th>Bank Address</th>
			<td>
				<input class="form-control frminp" id="bank_add" name="bank_add" onKeyUp="return toUpper(this.id)">
			</td>
			<th>Passbook Doc <font color="#FF0000">*</font></th>
			<td>
				<input class="form-control frminp" type="file" name="doc_passbook" required>
			</td>
		</tr>
		

		<tr>
		    <td style="color:#0078F0;font-size:12px; vertical-align:middle;">&nbsp;<b>Address Details</b></td>
			<td colspan="7"><hr style="width:99%;background-color:#0078F0;margin-top:8px; margin-bottom:0px;"/></td>
		</tr>
		<tr>
			<th>Address</th>
			<td>
				<input class="form-control frminp" id="address" name="address" onKeyUp="return toUpper(this.id)" >
			</td>
			<th>
				State
				<button type="button" class="btn btn-sm btn-primary frmbtn" style="float: right;padding: 1px !important;" onclick="addState()"><i class="fa fa-plus" aria-hidden="true"></i></button>
				<script type="text/javascript">
					function addState(){
					
						var myWindow = window.open('addState.php','_blank', 'location=yes,height=250,width=450,scrollbars=yes,status=yes');
						myWindow.onunload = refreshState; // afterChildClose() is the function.
						// myWindow.close(); // afterChildClose() should fire now.
					}
					function refreshState(){
					  	$.post("mastersAjax.php",{ act:'getFState'},function(data){
							$('#state_id').html(data);
				        });
				        
					}
				</script>
			</th>
			<td>
				<select class="form-control frminp" name="state_id" id="state_id" >
					<option value="">Select</option>
					<?php foreach ($sarr as $key => $value) { ?> 
					<option value="<?=$key?>"  ><?=$value?></option>
					<?php }	?>
				</select>
				<script type="text/javascript">
					$('#state_id').on('change', function() {
						var sid=$('#state_id').val();
					  	$.post("mastersAjax.php",{ act:'getdist',sid:sid },function(data) {
							$('#distric_id').html(data);
				        });
					});
				</script>
				
				
			</td>
			<th>
				District
				<button type="button" class="btn btn-sm btn-primary frmbtn" style="float: right;padding: 1px !important;" onclick="addDist()"><i class="fa fa-plus" aria-hidden="true"></i></button>
				<script type="text/javascript">
					function addDist(){
						var sid=$('#state_id').val();
						var myWindow = window.open('addDistrict.php?sid='+sid,'_blank', 'location=yes,height=250,width=450,scrollbars=yes,status=yes');
						myWindow.onunload = refreshDist; // afterChildClose() is the function.
						// myWindow.close(); // afterChildClose() should fire now.
					}
					function refreshDist(){
						var sid=$('#state_id').val();
					  	$.post("mastersAjax.php",{ act:'getdist',sid:sid },function(data){
					  		// console.log(data);
							$('#distric_id').html(data);
				        });
				       
					}
				</script>
			</th>
			<td>
				<select class="form-control frminp" name="distric_id" id="distric_id" >
					<option value="">Select</option>
					<?php foreach ($darr as $key => $value) { ?>
					<option value="<?=$key?>"><?=$value?></option>
					<?php } ?>
				</select>
				<script type="text/javascript">
					$('#distric_id').on('change', function() {
						var did=$('#distric_id').val();
					  	$.post("mastersAjax.php",{ act:'gettahsil',did:did },function(data) {
					  		// console.log(data);
							$('#tahsil_id').html(data);
							FunNxtDis(did);
				        });
					});
					
					function FunNxtDis(did){
						$.post("mastersAjaxx.php",{ act:'get_from_d',did:did },function(data) {
					  		// console.log(data);
							$('#detailspan').html(data);
							$('#state_id').val($('#sti').val());
				        });
					}
					
				</script>
			</td>
			
		</tr>
		<tr>
			<th>
				Tahsil
				<button type="button" class="btn btn-sm btn-primary frmbtn" style="float: right;padding: 1px !important;" onclick="addTahsil()"><i class="fa fa-plus" aria-hidden="true"></i></button>
				<script type="text/javascript">
					function addTahsil(){
						var did=$('#distric_id').val();
						var myWindow = window.open('addTahsil.php?did='+did, '_blank', 'location=yes,height=250,width=450,scrollbars=yes,status=yes');
						myWindow.onunload = refreshTahsil; // afterChildClose() is the function.
						// myWindow.close(); // afterChildClose() should fire now.
					}
					function refreshTahsil(){
						var did=$('#distric_id').val();
					  	$.post("mastersAjax.php",{ act:'gettahsil',did:did },function(data){
					  		// console.log(data);
							$('#tahsil_id').html(data);
				        });
				        
					}
				</script>
			</th>
			<td>
				<select class="form-control frminp" name="tahsil_id" id="tahsil_id" >
				 <option value="">Select</option>
				 <?php foreach ($tarr as $key => $value) { ?>
					<option value="<?=$key?>"><?=$value?></option>
				 <?php } ?>
				</select>
				<script type="text/javascript">
					$('#tahsil_id').on('change', function() {
						var tid=$('#tahsil_id').val();
					  	$.post("mastersAjax.php",{ act:'getvillage',tid:tid },function(data) {
					  		// console.log(data);
							$('#village_id').html(data);
							FunNxtTh(tid);
				        });
					});
					
					function FunNxtTh(tid){
						$.post("mastersAjaxx.php",{ act:'get_from_t',tid:tid },function(data) {
					  		// console.log(data);
							$('#detailspan').html(data);
							$('#state_id').val($('#sti').val());
							$('#distric_id').val($('#dti').val());
				        });
					}
					
				</script>
			</td>
			<th>
				Village
				<button type="button" class="btn btn-sm btn-primary frmbtn" style="float: right;padding: 1px !important;" onclick="addVillage()"><i class="fa fa-plus" aria-hidden="true"></i></button>
				<script type="text/javascript">
					function addVillage(){
						var tid=$('#tahsil_id').val();
						var myWindow = window.open('addVillage.php?tid='+tid, '_blank', 'location=yes,height=250,width=450,scrollbars=yes,status=yes');
						
						myWindow.onunload = refreshVillage; // afterChildClose() is the function.
						// myWindow.close(); // afterChildClose() should fire now.
					}
					function refreshVillage(){
						var tid=$('#tahsil_id').val();
					  	$.post("mastersAjax.php",{ act:'getvillage',tid:tid },function(data){
					  		// console.log(data);
							$('#village_id').html(data);
							FunNxtTh(tid);
				        });
				        
					}
				</script>
			</th>
			<td>
				<select class="form-control frminp" name="village_id" id="village_id" >
				 <option value="">Select</option>
					<?php foreach ($varr as $key => $value) { ?>
					<option value="<?=$key?>"><?=$value?></option>
					<?php } ?>
				</select>
				<script type="text/javascript">
					$('#village_id').on('change', function() {
						var vid=$('#village_id').val();
					  	$.post("mastersAjaxx.php",{ act:'get_from_v',vid:vid },function(data) {
					  		// console.log(data);
							$('#detailspan').html(data);
							$('#state_id').val($('#sti').val());
							$('#distric_id').val($('#dti').val());
							$('#tahsil_id').val($('#tti').val());
				        });
					});
				</script>
				<span id="detailspan"></span>
				
			</td>
			<th>Pincode</th>
			<td>
				<input class="form-control frminp" name="pincode" maxlength="6">
			</td>
		</tr>
		<tr>
			<th>Address Proof</th>
			<td>
				<select class="form-control frminp" name="addproof_name" id="addproof_name">
					<option disabled selected value="">Select</option>
					<option value="Aadhar">Aadhar</option>
					<option value="Pan">Pan</option>
					<option value="Ration Card">Ration Card</option>
				</select>
			</td>
			<th>Address Proof no</th>
			<td>
				<input class="form-control frminp" name="addproof_no" >
			</td>
			<th>Address Proof Doc</th>
			<td>
				<input class="form-control frminp" type="file" name="doc_addproof" >
			</td>
		</tr>



		<tr>
		    <td colspan="8" style="color:#0078F0;font-size:12px;text-align:center;"><b>Land Details</b></td>
		</tr>
		
		<tr>
			<td colspan="8" >
				
				<table class=" estable table table-bordered">
					<thead>
						<tr>
							<th>State</th>
							<th>District</th>
							<th>Tahsil</th>
							<th>Village</th>
							<th>Sowing Area (In Acre)</th>
							<th>Khasra/Service No</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="farLandtbody">

					</tbody>
				</table>

				<input type="hidden" id="landcount" name="landcount" value="0">
				<input type="hidden" id="uid" name="uid" value="<?=$_SESSION['uId'];?>">
				
				<button type="button" class="btn btn-sm btn-primary frmbtn" style="float: right;margin-top: -20px;" onclick="addfarmerland()"><i class="fa fa-plus" aria-hidden="true"></i>Add</button>

				<script type="text/javascript">
					function addfarmerland(){
						var lc=parseInt($('#landcount').val());
						var uid=parseInt($('#uid').val());
						lc=lc+1;
						$('#landcount').val(lc);
						$.post("mastersAjax.php",{ act:'addFarmerLand',lc:lc,uid:uid },function(data) {
							$('#farLandtbody').append(data);
				        });
					}
					function onLoadAddfarmerland(){
						var lc=parseInt($('#landcount').val());
						var uid=parseInt($('#uid').val());
						lc=lc+1;
						$('#landcount').val(lc);
						$.post("mastersAjax.php",{ act:'addFarmerLand',lc:lc,uid:uid },function(data) {
							$('#farLandtbody').append(data);
							$('#loaderDiv').hide();
				        });
					}
					$(document).ready(function(){
						// var lc=1;
					    // while(lc<=1){
					    	onLoadAddfarmerland();
					    	// lc++;
					    // }
					});
				</script>
				
			</td>
		</tr>
		<tr>
			<td colspan="10">
				
				<center>
				<span id="savingdelay" style="display: none;">
					
					<button type="submit" id="addbtn" class="frmbtn btn btn-default btn-sm" style="width:100px;" onclick="" >Saving...</button>
				</span>

				<span id="formactions">
					<button type="submit" id="addbtn" class="frmbtn btn btn-success btn-sm" style="width:100px;" onclick="savingdelay()" >Save</button>
					<button type="button" class="frmbtn btn btn-sm btn-danger" style="width:100px;" onclick="$('#addfartbl', window.parent.document).hide(500);window.parent.document.getElementById('addfarbtn').style.display='block';" >Cancel</button>
				</span>
				</center>
			</td>
			
		</tr>
		
		</tbody>
		
	</table>
</form>
<script type="text/javascript">

function savingdelay(){

	var isValid = true;
	$('input,textarea,select').filter('[required]:visible').each(function() {
	  if ( $(this).val() === '' )
	     isValid = false;
	});

	if( isValid == true){
		
	$('#formactions').hide(500);
	$('#savingdelay').show(500);
	}


}

function FunNxtDis(did,lc)
					{
					  $.post("mastersAjaxx.php",{ act:'get_from_dd',did:did,lc:lc },function(data) {
					  		// console.log(data);
							$('#detailspan'+lc).html(data);
							$('#state_idla'+lc).val($('#sti'+lc).val());
				          }
				        );
					}

function FunNxtTh(tid,lc)
					    {
					     $.post("mastersAjaxx.php",{ act:'get_from_tt',tid:tid,lc:lc },function(data) {
					  		// console.log(data);
							$('#detailspan'+lc).html(data);
							$('#state_idla'+lc).val($('#sti'+lc).val());
							$('#distric_idla'+lc).val($('#dti'+lc).val());
				          }
				         );
					   }

	
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



<script type="text/javascript">
	// $(document).ready(function(){
	// 	$('#loaderDiv').hide();
	// });
</script>