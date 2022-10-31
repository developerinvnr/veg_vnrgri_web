<?php 
include 'sidemenu.php'; 
$act=''; $id='';
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
	input:read-only {
        background-color: white !important;   
    }

</style>
<script type="text/javascript">
function selstate(v)
{ 
 $.post("mastersAjax.php",{ act:'getdist',sid:v },
   function(data)
   { 
    $('#distric').html(data);
   }
  );
}

</script>
<div class="pagethings" style="width:85%;">
	
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>
<?php if($_REQUEST['act']=='' && $_REQUEST['v']==''){ ?>
<button id="addstbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addsttbl').show();$(this).hide();">Add New</button>
<?php } ?>
<div id="addsttbl" style="display:<?php if($_REQUEST['act']!='' && $_REQUEST['v']!=''){echo 'block';}else{echo 'none';}?>;margin-bottom:0px;padding:2px;padding-bottom:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;"><?php if($_REQUEST['act']!='' && $_REQUEST['v']!=''){echo 'Edit';}else{echo 'New';}?> Organiser</h6>
		<table class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th style="width: 25% !important;">Name/ Contact/ Email/ File</th>
				<th style="width: 25% !important;">DOB/ Aadhar/ PAN</th>
				<th style="width: 25% !important;">Address Details</th>
				<th style="width: 25% !important;">Bank Details</th>
			</tr>
			</thead>
<?php 

if($_REQUEST['act']!='' && $_REQUEST['v']!='')
{ $act=base64_decode($_REQUEST['act']); $id=base64_decode($_REQUEST['v']); }

if($act='edit' && $id!='')
{ 
	$sql=mysql_query('SELECT * FROM `organiser` where oid='.$id); $res=mysql_fetch_assoc($sql);
	$ss=mysql_query("select StateName from state where StateId=".$res['state_id']); $rs=mysql_fetch_assoc($ss);
	$sd=mysql_query("select DictrictName from distric where DictrictId=".$res['district_id']); $rd=mysql_fetch_assoc($sd);
	$st=mysql_query("select TahsilName from tahsil where TahsilId=".$res['tahsil_id']); $rt=mysql_fetch_assoc($st);
	$sv=mysql_query("select VillageName from village where VillageId=".$res['village_id']); $rv=mysql_fetch_assoc($sv);
	 
    $btn_n='update'; $btn_v='update'; $btn_clik='saved('.$id.')'; 
}
else{ $btn_n='save'; $btn_v='save'; $btn_clik='addst()';  }
 
?>			
			
			
			<tbody>
			
			<tr>
			  <td>
			    <table style="width:100%;" cellspacing="0">
				 <tr>
				  <td style="width: 100px !important; text-align:left;border:hidden;"><b>Name</b> <font color="#FF0000">*</font></td>
				  <td style="width: 150px !important; border:hidden;"><input class="form-control frminp" id="oname" value="<?=$res['oname'];?>"></td>
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>Mob-01</b> <font color="#FF0000">*</font></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="cont1" value="<?=$res['mobile_1'];?>" maxlength="10"></td>
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>Mob-02</b></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="cont2" value="<?=$res['mobile_2'];?>" maxlength="10"></td>
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>Mail</b></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="mail"  value="<?=$res['email'];?>"></td>
				 </tr>
				 
				 <?php if(trim($res['doc_aadhar'])!=''){ ?>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>Aadhar</b></td>
			      <td style="border-left:hidden;border:hidden;">
				   <a href="org_file/<?=$res['doc_aadhar']?>" target="_blank">Document</a></td>
				 </tr>
				 <?php } if(trim($res['doc_pan'])!=''){ ?>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>Pan</b></td>
			      <td style="border-left:hidden;border:hidden;">
				  <a href="org_file/<?=$res['doc_pan']?>" target="_blank">Document</a></td>
				 </tr>
				 <?php } if(trim($res['doc_passbook'])!=''){ ?>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>Passbook</b></td>
			      <td style="border-left:hidden;border:hidden;">
				  <a href="org_file/<?=$res['doc_passbook']?>" target="_blank">Document</a></td>
				 </tr>
				 <?php } ?>
				 
				</table> 
			  </td> 
			  <td>
			    <table style="width:100%;" cellspacing="0">
				 <tr>
				  <td style="width: 100px !important; text-align:left;border:hidden;"><b>DOB</b> <font color="#FF0000">*</font></td>
				  <td style="width: 150px !important;border-left:hidden;border:hidden;">
				  	<input class="form-control frminp" id="dob" value="<?php if($res['dob']!='' && $res['dob']!='0000-00-00'){ echo date("d-m-Y",strtotime($res['dob'])); }else{ echo ''; }?>">
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
				  
				  </td>
				  
				  
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>PAN</b> <font color="#FF0000">*</font></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="pan" value="<?=$res['pan_no'];?>" maxlength="10"></td>
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>Aadhar</b> <font color="#FF0000">*</font></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="aadhar" value="<?=$res['aadhar_no'];?>" maxlength="12"></td>
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>Father Name</b> <font color="#FF0000">*</font></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="fname" value="<?=$res['fname'];?>"></td>
				 </tr>
				</table> 
			  </td>
			   <td>
			    <table style="width:100%;" cellspacing="0">
				 <tr>
				  <td style="width: 100px !important; text-align:left;border:hidden;"><b>Street</b></td>
				  <td style="width: 150px !important;border:hidden;"><input class="form-control frminp" id="area" value="<?=$res['address'];?>"></td>
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>State</b></td>
			      <td style="border-left:hidden;border:hidden;">
			      	<select id="state" class="form-control frminp" onchange="selstate(this.value)">
			      		<option selected disabled>Select</option>
					<?php $ss2=mysql_query("SELECT * FROM `state` s inner join user_location l on l.state_id=s.StateId where l.uid=".$_SESSION['uId']." AND l.sts='A' order by StateName asc"); while($rs2=mysql_fetch_assoc($ss2)){?>	                 
							<option value="<?=$rs2['StateId'];?>" <?php if($res['state_id']==$rs2['StateId']){echo 'selected';}?> ><?=$rs2['StateName'];?></option>
						<?php } ?>
				   </select>
				</td>
				 </tr>
				 <tr>
				  	<td style="text-align:left;border:hidden;"><b>District</b></td>
			      	<td style="border-left:hidden;border:hidden;">
			      	<select id="distric" class="form-control frminp">
						   <option value="<?=$res['district_id'];?>"><?=strtoupper($rd['DictrictName']);?></option>
					   </select>
					</td>
				 </tr>
				 <tr>
				 <tr>
				  	<td style="text-align:left;border:hidden;"><b>Tahsil</b></td>
			      	<td style="border-left:hidden;border:hidden;">
			      	<select id="tahsil" class="form-control frminp">
						   <option value="<?=$res['tahsil_id'];?>"><?=strtoupper($rt['TahsilName']);?></option>
					   </select>
					</td>
				 </tr>
				 <tr>
				 <tr>
				  	<td style="text-align:left;border:hidden;"><b>Village</b></td>
			      	<td style="border-left:hidden;border:hidden;">
			      	<select id="village" class="form-control frminp">
						   <option value="<?=$res['village_id'];?>"><?=strtoupper($rv['VillageName']);?></option>
					   </select>
					</td>
				 </tr>
				 <!-- <tr>
				  <td style="text-align:left;border:hidden;"><b>City</b></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="city" value="<?=$res['city'];?>"></td>
				 </tr> -->
				 <tr>
				  <td style="text-align:left;border:hidden;"><b>Pin</b></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="pincode" value="<?=$res['pincode'];?>" maxlength="7"></td>
				 </tr>
				</table> 
			  </td> 
			  <td>
			    <table style="width:100%;" cellspacing="0">
				 <tr>
				  <td style="width: 100px !important; text-align:left;border:hidden;vertical-align:middle;"><b>Name</b> <font color="#FF0000">*</font></td>
				  <td style="width: 150px !important;border-left:hidden;border:hidden;"><input class="form-control frminp" id="bname" value="<?=$res['bank_name'];?>"></td>
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;vertical-align:middle;"><b>A/c No</b> <font color="#FF0000">*</font></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="bac" value="<?=$res['account_no'];?>"></td>
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;vertical-align:middle;"><b>IFSC</b> <font color="#FF0000">*</font></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="bifsc" value="<?=$res['ifsc_code'];?>"></td>
				 </tr>
				 <tr>
				  <td style="text-align:left;border:hidden;vertical-align:middle;"><b>Address</b></td>
			      <td style="border-left:hidden;border:hidden;"><input class="form-control frminp" id="badd" value="<?=$res['bank_add'];?>"></td>
				 </tr>
				 <tr>
				  <td colspan="2" style="border:hidden;">
				   <button id="addbtn" class="frmbtn btn btn-primary btn-sm" style="width:80px;" onclick="<?=$btn_clik;?>"><?=$btn_n;?></button>
				   <button class="frmbtn btn btn-sm btn-danger" style="width:80px;" onclick="cancd()" >Cancel</button>
				  </td>
				 </tr>
				</table> 
			  </td> 
			  
			  
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addsttbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll; text-align:center;">
		<h6 style="font-weight: bold;">Organiser List
		&nbsp;&nbsp;
		<a href="javascript:void(0)" onclick="exportorgxls()" style="font-size: 11px;">Export</a>
		<script type="text/javascript">function exportorgxls(){ myWindow = window.open('exportorg.php', 'location=yes,height=300,width=300,scrollbars=yes,status=yes'); }</script>
		</h6>
		<table id="statetable" class="estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th rowspan="2" style="width: 150px !important;">Name</th>
				<th rowspan="2" style="width: 70px !important;">Contact</th>
				<!-- <th rowspan="2" style="width: 100px !important;">Email</th>
				<th rowspan="2" style="width: 60px !important;">DOB</th> -->
				<th rowspan="2" style="width: 90px !important;">Aadhar No.</th>
				<th rowspan="2" style="width: 80px !important;">PAN No</th>
				<th rowspan="2" style="width: 80px !important;">State</th>
				<th rowspan="2" style="width: 80px !important;">District</th>
				
				<th rowspan="2" style="width: 200px !important;">Address</th>
				<th colspan="3">Bank Details</th>
				<th rowspan="2" style="width: 50px !important;">Edit</th>
				<th rowspan="2" style="width: 50px !important;">Upload<br />File</th>
			</tr>
			<tr>
				<th style="width: 100px !important;">Name</th>
				<th style="width: 60px !important;">A/c No.</th>
				<th style="width: 60px !important;">IFSC</th>
				<?php /*?><th style="width: 60px !important;">Branch</th><?php */?>
			</tr>
			</thead>
			<tbody>
			<?php
			//$alls=mysql_query('SELECT o.*,StateName,DictrictName FROM `organiser` o inner join state s on o.state_id=s.StateId inner join distric d on o.district_id=d.DictrictId order by oname asc');
			$alls=mysql_query('SELECT * FROM `organiser` order by oname asc');
			$sn=1; while ($allsd=mysql_fetch_assoc($alls)){ 
			
			if($allsd['state_id']>0){ $sS=mysql_query("select StateName from state where StateId=".$allsd['state_id']); $rS=mysql_fetch_assoc($sS); }
			if($allsd['district_id']>0){ $sD=mysql_query("select DictrictName from distric where DictrictId=".$allsd['district_id']); $rD=mysql_fetch_assoc($sD); }
			
			?>
			<tr>
			
    <td style="text-align:left;"><?=strtoupper($allsd['oname']);?></td> 
    <td><?=$allsd['mobile_1'];?></td>
<!-- 	<td><input class="form-control frminp" value="<?=$allsd['email'];?>"></td>
    <td><input class="form-control frminp" value="<?php if($allsd['dob']!='' && $allsd['dob']!='0000-00-00'){ echo date("d-m-y",strtotime($allsd['dob']));} ?>" ></td> -->
    <td><?=$allsd['aadhar_no'];?></td>
    <td><?=$allsd['pan_no'];?></td>
    <td><?=$rS['StateName'];?></td>
    <td><?=$rD['DictrictName'];?></td>
	<td><input class="form-control frminp" value="<?=strtoupper($allsd['address'].', '.$allsd['StateName'].', '.$allsd['DictrictName'].', '.$allsd['city'].'-'.$allsd['pincode']);?>" ></td>
	
	<td><input class="form-control frminp" value="<?=strtoupper($allsd['bank_name']);?>" ></td>
    <td><input class="form-control frminp" value="<?=strtoupper($allsd['account_no']);?>" ></td>
    <td><input class="form-control frminp" value="<?=strtoupper($allsd['ifsc_code']);?>" ></td>
    <?php /*?><td><input class="form-control frminp" value="<?=strtoupper($allsd['bank_add']);?>"></td><?php */?>
	<td>
<button id="ebtn<?=$allsd['oid']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=base64_encode($allsd['oid']);?>','<?=base64_encode("edit");?>')">Edit</button>
		
	</td>
	<td><span id="spanA<?php echo $sn; ?>" style="cursor:pointer;" onClick="AttachImg(<?php echo $allsd['oid'].','.$sn?>)" ><u><?php if(trim($allsd['doc_aadhar'])!='' || trim($allsd['doc_pan'])!='' || trim($allsd['doc_passbook'])!=''){ echo 'uploaded'; } else{ echo 'click'; } ?></u></span></td>
				
			</tr>
			
			<?php $sn++;
			}
			?>	
			</tbody>
		</table>
	</div>
	
	

</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.js"></script>
<script type="text/javascript"> 
//oname cont1 cont2 mail dob fname, aadhar pan area state distric city pincode bname, bac, bifsc, badd

function AttachImg(oid,sn)
{
   var win = window.open("uporgfile.php?oid="+oid+"&sn="+sn,"upform","width=600,height=400");
   var timer = setInterval( function() { if(win.closed){ clearInterval(timer);   } }, 1000); 
}

function editd(id,act){ window.location="organiser.php?v="+id+"&act="+act; }
function cancd(){ window.location="organiser.php"; }

	function saved(id){
		var oname  = $('#oname').val();
		var cont1  = $('#cont1').val();
		var cont2 = $('#cont2').val();
		var mail  = $('#mail').val();
		var dob  = $('#dob').val();
		var fname  = $('#fname').val();
		var aadhar  = $('#aadhar').val();
		var pan  = $('#pan').val();
		var area  = $('#area').val();
		var state = $('#state').val();
		var distric  = $('#distric').val();
		var tahsil  = $('#tahsil').val();
		var village  = $('#village').val();
		var city  = $('#city').val();
		var pincode  = $('#pincode').val();
		var bname  = $('#bname').val();
		var bac  = $('#bac').val();
		var bifsc = $('#bifsc').val();
		var badd  = $('#badd').val();
		
		
		if(oname==''){ alert("enter organiser name"); return false; }
		if(cont1==''){ alert("enter organiser contact number"); return false; }
		if(dob==''){ alert("enter organiser dob"); return false; }
		if(pan==''){ alert("enter pan number"); return false; }
		if(aadhar==''){ alert("enter aadhar number"); return false; }
		if(fname==''){ alert("enter organiser father name"); return false; }
		if(bname==''){ alert("enter bank name"); return false; }
		if(bac==''){ alert("enter bank a/c name"); return false; }
		if(bifsc==''){ alert("enter bank ifsc code"); return false; }
		
		$.post("mastersAjaxx.php",{ act:'saveOrgDetails',oname:oname, cont1:cont1, cont2:cont2, mail:mail, dob:dob, fname:fname, aadhar:aadhar, pan:pan, area:area, state:state, distric:distric,tahsil:tahsil,village:village, city:city, pincode:pincode, bname:bname, bac:bac, bifsc:bifsc, badd:badd,id:id},function(data) {
                          
			if(data.includes("updated")){
				
				$("#savmsg").show(300);
				setTimeout(function(){ window.location="organiser.php";  }, 800);

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
		var oname  = $('#oname').val();
		var cont1  = $('#cont1').val();
		var cont2 = $('#cont2').val();
		var mail  = $('#mail').val();
		var dob  = $('#dob').val();
		var fname  = $('#fname').val();
		var aadhar  = $('#aadhar').val();
		var pan  = $('#pan').val();
		var area  = $('#area').val();
		var state = $('#state').val();
		var distric  = $('#distric').val();
		var tahsil  = $('#tahsil').val();
		var village  = $('#village').val();
		var city  = $('#city').val();
		var pincode  = $('#pincode').val();
		var bname  = $('#bname').val();
		var bac  = $('#bac').val();
		var bifsc = $('#bifsc').val();
		var badd  = $('#badd').val(); 
		
		if(oname==''){ alert("enter organiser name"); return false; }
		if(cont1==''){ alert("enter organiser contact number"); return false; }
		if(dob==''){ alert("enter organiser dob"); return false; }
		if(pan==''){ alert("enter pan number"); return false; }
		if(aadhar==''){ alert("enter aadhar number"); return false; }
		if(fname==''){ alert("enter organiser father name"); return false; }
		if(bname==''){ alert("enter bank name"); return false; }
		if(bac==''){ alert("enter bank a/c name"); return false; }
		if(bifsc==''){ alert("enter bank ifsc code"); return false; }

		$.post("mastersAjaxx.php",{ act:'addOrg',oname:oname, cont1:cont1, cont2:cont2, mail:mail, dob:dob, fname:fname, aadhar:aadhar, pan:pan, area:area, state:state, distric:distric,tahsil:tahsil,village:village, city:city, pincode:pincode, bname:bname, bac:bac, bifsc:bifsc, badd:badd},function(data) { //alert(data);
                                                  
			if(data.includes("added")){
				$('#addsttbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location="organiser.php";  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}else if(data.includes("duplicate entry")){
				alert(' Something went wrong! \n organiser name & contact number allready available. \n\n\n');
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

	$('#distric').on('change', function() {
		var did=$('#distric').val();
	  	$.post("mastersAjax.php",{ act:'gettahsil',did:did },function(data) {
	  		// console.log(data);
			$('#tahsil').html(data);
	    });
	});
	$('#tahsil').on('change', function() {
		var tid=$('#tahsil').val();
	  	$.post("mastersAjax.php",{ act:'getvillage',tid:tid },function(data) {
	  		// console.log(data);
			$('#village').html(data);
	    });
	});
</script>


