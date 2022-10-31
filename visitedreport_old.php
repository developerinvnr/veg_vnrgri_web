<?php
include 'sidemenu.php';
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

<?php
$allc=mysql_query("SELECT c.* FROM crop c, visit_details v where c.cropid=v.VCrop group by v.VCrop order by c.cropname");
while ($allcd=mysql_fetch_assoc($allc)) {
	$crarr[$allcd['cropid']]=strtoupper($allcd['cropname']);
}


$allhy=mysql_query("SELECT VHyb_code FROM visit_details group by VHyb_code order by VHyb_code");
while ($allhyd=mysql_fetch_assoc($allhy)) {
	$hyarr[$allhyd['VHyb_code']]=strtoupper($allhyd['VHyb_code']);
}


$alls=mysql_query("SELECT VState FROM visit_details group by VState order by VState asc");
while($allsd=mysql_fetch_assoc($alls)){
	$sarr[$allsd['VState']]=strtoupper($allsd['VState']);
}


$allv=mysql_query("SELECT VVillage FROM visit_details group by VVillage order by VVillage asc");
while($allvd=mysql_fetch_assoc($allv)){
	$varr[$allvd['VVillage']]=strtoupper($allvd['VVillage']);
}




?>

<div class="pagethings" style="width:85%;">
		<div id="editAgrDiv" style="display: none;margin-bottom:10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;" id="actiontext"></h6>
		<iframe id="editAgrIframe" src="" style="width:100%;height:465px;border:0px;"></iframe>
	</div>

	<div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;">
		<h6 style="font-weight: bold;">Field Visit Report</h6>

		<table class="ftable" style="margin-bottom:2px;">
			<thead>
							
				<tr>
				 <td colspan="10">
<!--<link rel="stylesheet" href="search/select2.min.css" />
<style>.select2-dropdown { position:absolute;top: 175px !important; left: 0px !important; font-size:12px;padding-top:0px;}</style>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->			  
				  
<?php $sSe=mysql_query("select * from view_season where SesId=1"); $rSe=mysql_fetch_assoc($sSe);
$sVd=mysql_query("select * from app_version where VersionId=1"); $rVd=mysql_fetch_assoc($sVd); 
$Kdf=date("d-m-Y",strtotime($rVd['Kharif_From'])); 
$Kdt=date("d-m-Y",strtotime($rVd['Kharif_To']));
$Rdf=date("d-m-Y",strtotime($rVd['Rabi_From']));
$Rdt=date("d-m-Y",strtotime($rVd['Rabi_To'])); 
if($rSe['Kharif']=='Y'){ $Df=$Kdf; $Dt=$Kdt; }
elseif($rSe['Rabi']=='Y'){ $Df=$Rdf; $Dt=$Rdt; }
?>
<input type="hidden" id="Kdf" value="<?=$Kdf?>" />
<input type="hidden" id="Kdt" value="<?=$Kdt?>" />
<input type="hidden" id="Rdf" value="<?=$Rdf?>" />
<input type="hidden" id="Rdt" value="<?=$Rdt?>" />				  
				  
				  <table style="width:100%;">
				   <tr>
				     <th style="width:120px;">Search By Season<br />
					  <select style="padding:4px;border-radius: 4px;cursor:pointer;" onchange="setseason(this.value)"><option value="">Select Season</option>
					<option value="kharif" <?php if($rSe['Kharif']=='Y'){echo 'selected';} ?>>Kharif</option>
					<option value="rabi" <?php if($rSe['Rabi']=='Y'){echo 'selected';} ?>>Rabi</option></select>
					
					    <script type="text/javascript">
				    		function setseason(se){
				    			var curdate = $('#from').val();
				    			var curyear = curdate.split("-");
				    			curyear = curyear[2];
				    			var nextyear = parseInt(curyear)+1;
				    			if(se=='kharif'){
				    				$('#from').val($('#Kdf').val());
				    				$('#to').val($('#Kdt').val());
				    				$('#klabel').css('background-color','green');
				    				$('#klabel').css('color','white');
				    				$('#rlabel').css('background-color','');
				    				$('#rlabel').css('color','');
				    			}else if(se == 'rabi'){
				    				$('#from').val($('#Rdf').val());
				    				$('#to').val($('#Rdt').val());
				    				$('#rlabel').css('background-color','green');
				    				$('#rlabel').css('color','white');
				    				$('#klabel').css('background-color','');
				    				$('#klabel').css('color','');
				    			}
				    		}
				    	</script>	
					
					 </th>
				      <th>
					   &nbsp;From: <input type="" class="dtinp" id="from" value="<?=$Df;?>" autocomplete="off"><br /><br />
					    &nbsp;To:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="" class="dtinp" id="to" value="<?=$Dt;?>" autocomplete="off">
					  </th>
					 
					 <th style="width:160px;">Search By Crop<br />
					  <select name="crop" id="crop" style="width:95%;height:20px;" onchange="SelCrop(this.value)">
						<option value="" selected="selected" style="font-size:12px;">All</option>
						 <?php foreach ($crarr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=strtoupper($value)?></option>
						 <?php } ?>
					  </select>
					  <script>
					   function SelCrop(ci)
					   { $.post("VisitAjax.php",{ action:'get_hy',ci:ci},function(data){ 
				         $('#hy').html(data); }); }
					  </script>
					 </th>
					 <th style="width:120px;">Search By HyCode<br />
					  <select name="hy" id="hy" style="width:95%;height:20px;">
						<option value="" selected="selected" style="font-size:12px;">All</option>
						 <?php foreach ($hyarr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=strtoupper($value)?></option>
						 <?php } ?>
					  </select>
					 </th>
					  
				     <th style="width:160px;">Search By State<br />
					  <select name="sii" id="sii" style="width:95%;height:20px;" onchange="SelState(this.value)">
						<option value="" selected="selected" style="font-size:12px;">All</option>
						 <?php foreach ($sarr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=strtoupper($value)?></option>
						 <?php } ?>
					  </select>
					  <script>
					   function SelState(si)
					   { $.post("VisitAjax.php",{ action:'get_vi',si:si},function(data){ 
				         $('#vii').html(data); }); }
					  </script>
					 </th>
					 <th style="width:180px;">Search By Village<br />
					  <select name="vii" id="vii" style="width:95%;">
						<option value="">All</option>
						 <?php foreach ($varr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=strtoupper($value)?></option>
						 <?php } ?>
					  </select>
					 </th>
					 
					 <th style="width:80px;text-align:center;">
					  <input type="hidden" name="" id="keywordSearch" placeholder="Search By Any Keyword"><!--<br/><br/>-->
					  <button class="btn btn-sm btn-primary frmbtn" onclick="VisitSearch()">&emsp;Search&emsp;</button>
					 
					 <br /><br />
					 <div id="divsearch" style="display:none;width:70px;">
					 <a href="javascript:void(0)" onclick="exportagrixls()" style="font-size: 11px;">Export</a> 
					 </div>
					 <script type="text/javascript">
					 function exportagrixls(){
								var from = $('#from').val();
                                var to = $('#to').val();
                                var crop = $('#crop').val();
                                var hy = $('#hy').val();
                                var sii = $('#sii').val();
                                var vii = $('#vii').val();
								myWindow = window.open('VisitAjax.php?action=exportvisit&from='+from+'&to='+to+'&crop='+crop+'&hy='+hy+'&sii='+sii+'&vii='+vii, '_blank', 'location=yes,height=50,width=100,scrollbars=yes,status=yes');
								
							}			
					 </script>
					 
					 </th>
					  
				   </tr>
				  </table>
				 </td>
				 
				</tr>
				
				<tr>
				
			</thead>
		</table>

		<table class=" estable table table-bordered" style="width:100%;">
			<thead>
				<tr>
				 <th style="width:40px;">Sn</th>
				 <th style="width:120px;">Date-Time</th>
				 <th style="width:150px;">User</th>
				 <th style="width:80px;">Crop</th>
				 <th style="width:80px;">Hybride Code</th>
				 <th style="width:100px;">State</th>
				 <th style="width:120px;">Village</th>
				 <th style="width:50px;">Acreage</th>
				 <th style="width:200px;">Location</th>
				</tr> 
			</thead>
			<tbody id="reportBody">
				
			</tbody>
		</table>
	</div>
	

</div>
<script src="search/select2.min.js"></script>
<script>
$('#from').datepicker({format:'dd-mm-yyyy',});
$('#to').datepicker({format:'dd-mm-yyyy',});

function VisitSearch(page)
{

 var from = $('#from').val();
 var to = $('#to').val();
 var crop = $('#crop').val();
 var hy = $('#hy').val();
 var sii = $('#sii').val();
 var vii = $('#vii').val();

 $.post("VisitAjax.php",{ act:'get_visit_report_list',page:page,from:from,to:to,crop:crop,hy:hy,sii:sii,vii:vii},function(data) { $('#reportBody').html(data); var tt=$('#countval').val(); 
  if(tt>0)
  { 
   document.getElementById("divsearch").style.display='block'; 
   document.getElementById("div2search").style.display='block'; 
  }
 });

}

function pad2(number) {
	return (number < 10 ? '0' : '') + number;
}

</script>




