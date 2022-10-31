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

<div class="pagethings" style="width:85%;">
		<div id="editAgrDiv" style="display: none;margin-bottom:10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;" id="actiontext"></h6>
		<iframe id="editAgrIframe" src="" style="width:100%;height:465px;border:0px;"></iframe>
	</div>

	<div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;">
		<h6 style="font-weight: bold;">Report</h6>

		<table class="ftable" style="margin-bottom:2px;">
			<thead>
				
<?php
$sarr=$_SESSION['sarr'];
$darr=$_SESSION['darr'];
$tarr=$_SESSION['tarr'];
$varr=$_SESSION['varr'];
?>				
				<tr>
				 <td colspan="10">
<!--<link rel="stylesheet" href="search/select2.min.css" />
<style>.select2-dropdown { position:absolute;top: 175px !important; left: 0px !important; font-size:12px;padding-top:0px;}</style>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->			  
				  <table style="width:100%;">
				   <tr>
				     <th style="width:180px;">Search By Organiser<br />
					  <select name="orgr" id="orgr" style="width:95%;height:20px;">
						<option value="">All</option>
						  <?php foreach ($oarr as $key => $value) { ?>
						    <option value="<?=$key?>" ><?=strtoupper($value)?></option>
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
					   { $.post("exportimportAjax.php",{ action:'get_di',si:si},function(data){
				         $('#dii').html(data); }); }
					  </script>
					 </th>
					 <th style="width:180px;">Search By District<br />
					  <select name="dii" id="dii" style="width:95%;height:20px;" onchange="SelDistrict(this.value)">
						<option value="">All</option>
						 <?php foreach ($darr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=strtoupper($value)?></option>
						 <?php } ?>
					  </select>
					  <script>
					   function SelDistrict(di)
					   { $.post("exportimportAjax.php",{ action:'get_ti',di:di},function(data){
				         $('#tii').html(data); }); }
					  </script>
					 </th>
					 <th style="width:180px;">Search By Tahsil<br />
					  <select name="tii" id="tii" style="width:95%;height:20px;" onchange="SelTahsil(this.value)">
						<option value="">All</option>
						 <?php foreach ($tarr as $key => $value) { ?>
						 <option value="<?=$key?>"><?=strtoupper($value)?></option>
						 <?php } ?>
					  </select>
					  <script>
					   function SelTahsil(ti)
					   { $.post("exportimportAjax.php",{ action:'get_vi',ti:ti},function(data){
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
					  <button class="btn btn-sm btn-primary frmbtn" onclick="agreeSearch()">&emsp;Search&emsp;</button>
					 </th>
					 
					 <th>
					<div id="divsearch" style="display:none;width:70px;">
					 <a href="javascript:void(0)" onclick="exportagrixls()" style="font-size: 11px;">Export</a> 
					 <br><br>
					 <a href="javascript:void(0)" onclick="printcp()" style="font-size: 11px;">Print_Copy</a>
					</div>
					<script type="text/javascript">
					 function exportagrixls(){
								var orgr = $('#orgr').val();
								var sii = $('#sii').val();
		                        var dii = $('#dii').val();
		                        var tii = $('#tii').val();
		                        var vii = $('#vii').val();
								myWindow = window.open('farmerexp.php?orgr='+orgr+'&sii='+sii+'&dii='+dii+'&tii='+tii+'&vii='+vii, '_blank', 'location=yes,height=300,width=300,scrollbars=yes,status=yes');
								
							}	
							
					  function printcp(){
								var orgr = $('#orgr').val();
								var sii = $('#sii').val();
		                        var dii = $('#dii').val();
		                        var tii = $('#tii').val();
		                        var vii = $('#vii').val();
								myWindow = window.open('farmercp.php?orgr='+orgr+'&sii='+sii+'&dii='+dii+'&tii='+tii+'&vii='+vii, '_blank', 'location=yes,height=650,width=1200,scrollbars=yes,menubar=yes,status=yes');
								
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
				 <th rowspan="2" style="width:40px;">Sn</th>
				 <th rowspan="2" style="width:140px;">Farmer-ID</th>
				 <th rowspan="2" style="width:180px;">Farmer Name</th>
				 <th rowspan="2" style="width:80px;">Contact</th>
				 <th rowspan="2" style="width:180px;">Father Name</th>
				 <th rowspan="2" style="width:180px;">Organiser</th>
				 <th rowspan="2" style="width:100px;">Village</th>
				 <th rowspan="2" style="width:100px;">Tahsil</th>
				 <th rowspan="2" style="width:100px;">District</th>
				 <th rowspan="2" style="width:100px;">State</th>
				</tr> 
			</thead>
			<tbody id="reportBody">
				
			</tbody>
		</table>
	</div>
	

</div>
<script src="search/select2.min.js"></script>
<script type="text/javascript">
 //$("#orgr").select2( { placeholder:"", allowClear:true } );
 //$("#sii").select2( { placeholder:"", allowClear:true } );
 //$("#dii").select2( { placeholder:"", allowClear:true } );
 //$("#tii").select2( { placeholder:"", allowClear:true } );
 //$("#vii").select2( { placeholder:"", allowClear:true } );
</script>

<script>

	function agreeSearch(page){

		var orgr = $('#orgr').val();
		var sii = $('#sii').val();
		var dii = $('#dii').val();
		var tii = $('#tii').val();
		var vii = $('#vii').val();

		$.post("farmerAjax.php",{ act:'get_farmer_report_list',page:page,orgr:orgr,sii:sii,dii:dii,tii:tii,vii:vii},function(data) {
			$('#reportBody').html(data);
			// console.log(data);
			var tt=$('#countval').val(); //alert(tt);
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




