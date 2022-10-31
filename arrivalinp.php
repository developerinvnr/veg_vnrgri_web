<?php
include 'sidemenu.php';

// date("t",strtotime($_POST['Year'].'-'.$_POST['Month'].'-01'))

?>

<style type="text/css">
	.pagethings{
		position:absolute;
		left:200px;
		padding:20px;
	}
	.nshw{
		display: none;
	}


	.ftable thead th,.ftable tbody th,.ftable tbody td{
	  font-size: 12px !important;
	  padding: 1px 2px !important;
	  text-align: center;
	  font-weight: 500;
	  border:2px solid #ccc;
	  margin:0px;
	}
	.ftable thead th{
	  background-color:#e3f1f7;
	  color: #000;
	  font-size: 13px;
	  font-weight: bold;
	  padding: 7px 3px !important;
	}

	.ftable tbody td{
	  background-color: #fff !important;
	}

	.dtinp{
		padding: 4px;
		border-radius: 5px;
		border:1px solid #c1c1c1;
		width: 90px;
		text-align: center;

	}
</style>
<script type="text/javascript">
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 //if (charCode > 31 && (charCode < 48 || charCode > 57))
 if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))  /* For floating*/
	return false;

 return true;
}
</script>

<?php
//$allo=mysql_query("SELECT * FROM `organiser` o inner join user_location l on l.state_id=o.state_id where l.uid=".$_SESSION['uId']." AND l.sts='A'");
$allo=mysql_query("SELECT * FROM `organiser` order by oname asc");
while($allod=mysql_fetch_assoc($allo)){
	$oarr[$allod['oid']]=strtoupper($allod['oname']);
}

$allc=mysql_query("SELECT c.* FROM crop c, user_crop uc where c.cropid=uc.cropid and uc.uid='".$_SESSION['uId']."' order by c.cropname");
while ($allcd=mysql_fetch_assoc($allc)) {
	$crarr[$allcd['cropid']]=strtoupper($allcd['cropname']);
}

$allf=mysql_query("SELECT f.* FROM farmers f, user_location ul WHERE f.state_id=ul.state_id and ul.uid='".$_SESSION['uId']."' and ul.sts='A'");
while ($allfd=mysql_fetch_assoc($allf)) {
	$farr[$allfd['fid']]=strtoupper($allfd['fname']);
}

function gethierarchy($uid){

	$id=array($uid);
	if($_SESSION['uType']=='S'){
		$sel=mysql_query("select uId from users where uStatus='A'");
		while($seld = mysql_fetch_assoc($sel)){
			$idc = array($seld['uId']);
			$id = array_merge($id,$idc);
		}
	}else{
		$sel=mysql_query("select uId from users where uStatus='A' AND uReporting='".$uid."'");
		if(mysql_num_rows($sel) > 0){
			while($seld = mysql_fetch_assoc($sel)){
				$idc = array($seld['uId']);
				$id = array_merge($id,$idc,gethierarchy($seld['uId']));
			}
		}
	}
	return $id;	
}

$qryu='AND uId!=1 AND uId!=12 AND uId!=14 AND uId!=134 AND uId!=195 AND uId!=196 AND uId!=197 AND uId!=198 AND uId!=199 AND uId!=200';

$allu=mysql_query("SELECT * FROM `users` where uStatus='A' AND uPost!=4 ".$qryu." order by uName asc");
while ($allud=mysql_fetch_assoc($allu)) {
	$uarr[$allud['uId']]=strtoupper($allud['uName']);
}

?>

<div class="pagethings" style="width:87%;">
		<div id="editAgrDiv" style="display: none;margin-bottom:10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;" id="actiontext"></h6>
		<iframe id="editAgrIframe" src="" style="width:100%;height:465px;border:0px;"></iframe>
	</div>

	<div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;">
		<h6 style="font-weight: bold;">Input Arrival</h6>

		<table class="ftable" style="margin-bottom:2px;">
			<thead>
				<tr>
				    <th>&nbsp;Dispatch<br>Date</th><?php //echo date("d-m-Y");?>
				    <th>&nbsp;From: <input type="" class="dtinp" id="from" autocomplete="off" value="<?php echo date("d-m-Y");?>">
					<br /><br />
					    &nbsp;To:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="" class="dtinp" id="to" autocomplete="off" value="<?php echo date("d-m-Y");?>"><?php //echo date("d-m-Y");?>
					</th>
				
					<!--<th>&nbsp;To: <br /><input type="" class="dtinp" id="to" autocomplete="off">&nbsp;</th>-->
					<th>&nbsp;Crop: &nbsp;&nbsp;&nbsp;<select id="crop" onchange="SelCrop(this.value)" style="width:110px;"><option value="">Select</option>
							        <?php foreach ($crarr as $key => $value) { ?>
							        <option value="<?=$key?>" ><?=$value?></option>
							        <?php } ?></select><br /><br />
						&nbsp;Prod<sup>n</sup> Code: <select id="prodcode" style="width:80px;"></select>
					
					<script>
					 function SelCrop(crop)
					 { $.post("agrlotreport_act.php",{ action:'get_prodcode',crop:crop},function(data){
				       $('#prodcode').html(data); }); }
					</script>
					</th>
					<!-- 
						==========================================================================================
						here farmer filter and organiser filter displayed because user asked to removed 
						===========================================================================================
					-->
					
					<th>&nbsp;Organiser: <select id="orgr" style="width:190px;"><option value="">All</option>
							  <?php foreach ($oarr as $key => $value) { ?>
							  <option value="<?=$key?>" ><?=ucfirst(strtolower($value))?></option>
							  <?php } ?></select>&nbsp;<br /><br />
						&nbsp;Driver No: &nbsp;<select id="driv" style="width:190px;"><option value="">All</option>
<?php $qryDr=""; $datey=date("Y"); for($i=2019; $i <= $datey; $i++) { 
		$qryDr.=" SELECT driver_no FROM agreementlot_".$i."";
		if($i!=$datey){
			$qryDr.=' UNION';
		}	
	}
	$qryDr.=' group by driver_no order by driver_no desc';    

	// exit;
	$rDr=mysql_query($qryDr);
	while($resDr=mysql_fetch_assoc($rDr)){
?>							          
							         <option value="<?=$resDr['driver_no']?>"><?=$resDr['driver_no']?></option>
							         <?php } ?>
						             </select>
					<script>
					 function SelCrop(crop)
					 { $.post("agrlotreport_act.php",{ action:'get_prodcode',crop:crop},function(data){
				       $('#prodcode').html(data); }); }
					</script>
					</th>
					
<?php $qrypp=""; $j=2021; $m=2021; ?>					 
				    <th>
&nbsp;Prod<sup>n</sup> Person: &nbsp;&nbsp;<select id="pperson" style="width:190px;"><option value="">All</option>
<?php for($i=2019; $i<=$j; $i++){ $qrypp.=" SELECT uId,uName from agreement_".$i." agr inner join users u on agr.prod_person=u.uId group by u.uId"; if($i!=$j){$qrypp.=' UNION ';} if($i==$j){$qrypp.=' order by uName asc ';} } $run_qrypp=mysql_query($qrypp); while($respp=mysql_fetch_assoc($run_qrypp)){echo '<option value='.$respp['uId'].'>'.ucfirst(strtolower($respp['uName'])).'</option>';}?></select>						&nbsp;<br /><br />
&nbsp;Prod<sup>n</sup> Exe.: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select id="pexecutive" style="width:190px;"><option value="">All</option>
<?php for($k=2019; $k<=$m; $k++){ $qrype.=" SELECT uId,uName from agreement_".$k." agr inner join users u on agr.prod_executive=u.uId group by u.uId"; if($k!=$m){$qrype.=' UNION ';} if($k==$m){$qrype.=' order by uName asc ';} } $run_qrype=mysql_query($qrype); while($respe=mysql_fetch_assoc($run_qrype)){echo '<option value='.$respe['uId'].'>'.ucfirst(strtolower($respe['uName'])).'</option>';}?></select>					
					</th>

                    <th style="width:100px;">
						<a href="javascript:void(0)" onclick="importarri()" style="font-size: 11px;"><u>Import In CSV</u></a>
						<br><br><b><font style="color:#FF0000;">Use this for <br />Import Arrival</font></b>
						<script type="text/javascript">
							function importarri(){
								myWindow = window.open('arrivalimport.php', '_blank', 'location=yes,height=350,width=700,scrollbars=yes,status=yes');
								/*setTimeout(function(){ 
									// myWindow.close();
								},1000); */
							}
						</script>
					</th>



					<th>
					
					<div id="divsearch" style="display:none;width:50px;">
					 <a href="javascript:void(0)" onclick="exportagrixls()" style="font-size: 11px;">Export<br>In XLS</a> 
					</div>
					
					<script type="text/javascript">
					 function exportagrixls(){
								
								var from = $('#from').val();
								var to = $('#to').val();
								var crop = $('#crop').val();
								var prodcode = $('#prodcode').val();
								var secondparty = $('#secondparty').val(); 	
								var orgr = $('#orgr').val();
								var pperson = $('#pperson').val();
		                        var pexe = $('#pexecutive').val();
								var users = 0; 
								var sii = $('#sii').val();
		                        var dii = $('#dii').val();
		                        var tii = $('#tii').val();
		                        var vii = $('#vii').val();
								var driv = $('#driv').val();
								var keywordSearch = $('#keywordSearch').val(); 
								myWindow = window.open('arrivalinp_exp.php?from='+from+'&to='+to+'&crop='+crop+'&secondparty='+secondparty+'&orgr='+orgr+'&users='+users+'&keywordSearch='+keywordSearch+'&prodcode='+prodcode+'&pperson='+pperson+'&pexe='+pexe+'&sii='+sii+'&dii='+dii+'&tii='+tii+'&vii='+vii+'&driv'+driv, '_blank', 'location=yes,height=300,width=300,scrollbars=yes,status=yes');
								//setTimeout(function(){ myWindow.close(); },1000);
							}
					 </script>				
						
					</th>

				</tr>
<?php
$sarr=$_SESSION['sarr'];
$darr=$_SESSION['darr'];
$tarr=$_SESSION['tarr'];
$varr=$_SESSION['varr'];
?>				
				<tr>
				 <td colspan="10">
<link rel="stylesheet" href="search/select2.min.css" />
<style>.select2-dropdown { position:absolute;top: 175px !important; left: 0px !important; height:150px !important; font-size:12px;padding-top:0px;}</style>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->			  
				  <table style="width:100%;">
				   <tr>
				     <th style="width:200px;">Search By State<br />
					  <select name="sii" id="sii" style="width:95%;" onchange="SelState(this.value)">
						<option value="" selected="selected" style="font-size:12px;">All</option>
						 <?php foreach ($sarr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=$value?></option>
						 <?php } ?>
					  </select>
					  <script>
					   function SelState(si)
					   { $.post("agrlotreport_act.php",{ action:'get_di',si:si},function(data){
				         $('#dii').html(data); }); }
					  </script>
					 </th>
					 <th style="width:200px;">Search By District<br />
					  <select name="dii" id="dii" style="width:95%;" onchange="SelDistrict(this.value)">
						<option value="">All</option>
						 <?php foreach ($darr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=$value?></option>
						 <?php } ?>
					  </select>
					  <script>
					   function SelDistrict(di)
					   { $.post("agrlotreport_act.php",{ action:'get_ti',di:di},function(data){
				         $('#tii').html(data); }); }
					  </script>
					 </th>
					 <th style="width:200px;">Search By Tahsil<br />
					  <select name="tii" id="tii" style="width:95%;" onchange="SelTahsil(this.value)">
						<option value="">All</option>
						 <?php foreach ($tarr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=$value?></option>
						 <?php } ?>
					  </select>
					  <script>
					   function SelTahsil(ti)
					   { $.post("agrlotreport_act.php",{ action:'get_vi',ti:ti},function(data){
				         $('#vii').html(data); }); }
					  </script>
					 </th>
					 <th style="width:200px;">Search By Village<br />
					  <select name="vii" id="vii" style="width:95%;">
						<option value="">All</option>
						 <?php foreach ($varr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=$value?></option>
						 <?php } ?>
					  </select>
					 </th>
					 <th style="width:80px;text-align:center;">
					  <input type="hidden" name="" id="keywordSearch" placeholder="Search By Any Keyword"><!--<br/><br/>-->
					  <button class="btn btn-sm btn-primary frmbtn" onclick="agreeSearch()">&emsp;Search&emsp;</button>
					 </th>
				   </tr>
				  </table>
				 </td>
				 
				</tr>
				
				
				<tr>
				
				<th style="display: none;">&nbsp;
						Farmer: <br />
						<select id="secondparty" style="width:200px;">
							<option  value="">All</option>
							<?php foreach ($farr as $key => $value) { ?>
							<option value="<?=$key?>"  ><?=$value?></option>
							<?php } ?>
						</select>&nbsp;
					</th>
					<?php /*?><th style="display: none;">&nbsp;
						Organiser: <br />
						<select id="orgr">
							<option value="">All</option>
							<?php foreach ($oarr as $key => $value) { ?>
							<option value="<?=$key?>" ><?=$value?></option>
							<?php } ?>
						</select>&nbsp;
					</th>
					
					<th style="display:<?php if($_SESSION['uType']=='U'){echo "none";}?>;" >&nbsp;
						<?php
						$usr = array_unique(gethierarchy($_SESSION['uId']));
						// print_r($usr);
						?>

						Users: <br />
						<select id="users">
							<option value="">All</option>
							<?php foreach ($uarr as $key => $value) { ?>
							<option value="<?=$key?>"><?=$value?></option>
							<?php /*?><option value="<?=$value?>" ><?=$uarr[$value]?></option><?php */?>
							<?php /* } ?>
						</select>&nbsp;
					</th><?php */ ?>

					<?php /*?><th  >&nbsp;
						

						<input type="" name="" id="keywordSearch" placeholder="Search By Keyword">

						
					</th>
					<th>
					<button class="btn btn-sm btn-primary frmbtn" onclick="agreeSearch()">&emsp;Search&emsp;</button>
					</th><?php */?>
					
					
				
				</tr>

			</thead>
		</table>

		
			<div id="reportBody" style="width:100%;">
			
			
			</div>
		
	</div>
	

</div>
<script src="search/select2.min.js"></script>
<script type="text/javascript">
 $("#sii").select2( { placeholder:"", allowClear:true } );
 $("#dii").select2( { placeholder:"", allowClear:true } );
 $("#tii").select2( { placeholder:"", allowClear:true } );
 $("#vii").select2( { placeholder:"", allowClear:true } );
</script>

<script>

	$('#from').datepicker({format:'dd-mm-yyyy',});
	$('#to').datepicker({format:'dd-mm-yyyy',});
	 
	function agreeSearch(page){
        if(page==''){ var page=1; } else{ var page=page; }
		var crop = $('#crop').val();
		var prodcode = $('#prodcode').val(); 
		if(crop==''){ alert("Please select crop!"); return false; }
		var secondparty = $('#secondparty').val(); 	
		var orgr = $('#orgr').val();
		var pperson = $('#pperson').val();
		var pexe = $('#pexecutive').val();
		var from = $('#from').val();
		var to = $('#to').val();
		var sii = $('#sii').val();
		var dii = $('#dii').val();
		var tii = $('#tii').val();
		var vii = $('#vii').val();
		var users = 0;
		var driv = $('#driv').val();
		var keywordSearch = $('#keywordSearch').val();
		$.post("arrivalinp_act.php",{ act:'get_agr_report_Arrlist',page:page,crop:crop,orgr:orgr,from:from,to:to,secondparty:secondparty,users:users,keywordSearch:keywordSearch,prodcode:prodcode,pperson:pperson,pexe:pexe,sii:sii,dii:dii,tii:tii,vii:vii,driv:driv},function(data) {
			$('#reportBody').html(data);
			// console.log(data);
			var tt=$('#countval').val(); //alert(tt);
			if(tt>0)
			{ 
			 document.getElementById("divsearch").style.display='block'; 
			}
	    });

	}

	function FunEdit(no)
	{
	  $("#Edit"+no).hide(); //document.getElementById("Edit"+no).style.display='none'; 
	  $("#Save"+no).show(); //document.getElementById("Save"+no).style.display='block'; 
	  document.getElementById("arrDt"+no).readOnly=false; document.getElementById("arrDt"+no).style.background='#FFF'; 
	  document.getElementById("arrQty"+no).readOnly=false; document.getElementById("arrQty"+no).style.background='#FFF';
	  document.getElementById("arrRmk"+no).readOnly=false; document.getElementById("arrRmk"+no).style.background='#FFF';
	  //for(var i=1; i<=11; i++){ document.getElementById("TR"+i+no).style.background='#C1FFC1'; }
	}
	
	
	function FunSave(no,id,agid)
	{
	 var Dt = $("#arrDt"+no).val();
	 var Qty = $("#arrQty"+no).val();
	 var Rmk = $("#arrRmk"+no).val(); 
	 
	 if(Dt=='' || Dt=='0000-00-00'){ alert("please enter arrival date"); return false; }
	 if(Qty==''){ alert("please enter arrival qty"); return false; }
	 
	 $.post("arrivalinp_act.php",{ act:'savearrival',id:id,agid:agid,Dt:Dt,Qty:Qty,Rmk:Rmk},function(data) {
	  //alert(data);
	  if(data.includes("updated"))
	  {
		alert('Arrival data updated\n');
		$("#Edit"+no).show(); $("#Save"+no).hide(); 
		document.getElementById("arrDt"+no).readOnly=true; document.getElementById("arrDt"+no).style.background='#FFFF9D'; 
	    document.getElementById("arrQty"+no).readOnly=true; document.getElementById("arrQty"+no).style.background='#FFFF9D';
	    document.getElementById("arrRmk"+no).readOnly=true; document.getElementById("arrRmk"+no).style.background='#FFFF9D';		
	  }
	  else
	  {
	   alert('Error!\n');
	  }
			
	 });
	 
	}
	
	
	

		

</script>




