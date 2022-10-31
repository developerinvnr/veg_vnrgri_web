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



<?php





/*

$sql=mysql_query("select agree_no from agreementlot_2019 group by agree_no order by agri_lotId");

while($res=mysql_fetch_assoc($sql))

{



 $sql2=mysql_query("select agree_date,si,di,ti,vi,org_id,second_party,prod_person,prod_executive,ann_crop,ann_prodcode from agreement_2019 where agree_no='".$res['agree_no']."'"); $res2=mysql_fetch_assoc($sql2);

 

 $up=mysql_query("update agreementlot_2019 set agree_date='".$res2['agree_date']."',si='".$res2['si']."',di='".$res2['di']."',ti='".$res2['ti']."',vi='".$res2['vi']."',org_id='".$res2['org_id']."',second_party='".$res2['second_party']."',prod_person='".$res2['prod_person']."',prod_executive='".$res2['prod_executive']."',ann_crop='".$res2['ann_crop']."',ann_prodcode='".$res2['ann_prodcode']."' where agree_no='".$res['agree_no']."'");



}

*/















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

		<h6 style="font-weight: bold;">Lot Number Wise Report</h6>



		<table class="ftable" style="margin-bottom:2px;">

			<thead>

				<tr>

				

<?php $sSe=mysql_query("select * from view_season where SesId=1"); $rSe=mysql_fetch_assoc($sSe);

$sVd=mysql_query("select * from app_version where VersionId=1"); $rVd=mysql_fetch_assoc($sVd); 

$Kdf=date("d-m-Y",strtotime($rVd['Kharif_From'])); 
$Kdt=date("d-m-Y",strtotime($rVd['Kharif_To']));

$Rdf=date("d-m-Y",strtotime($rVd['Rabi_From']));
$Rdt=date("d-m-Y",strtotime($rVd['Rabi_To']));

$Sdf=date("d-m-Y",strtotime($rVd['Summer_From']));
$Sdt=date("d-m-Y",strtotime($rVd['Summer_To']));

//if($rSe['Kharif']=='Y'){ $Df=$Kdf; $Dt=$Kdt; }
//elseif($rSe['Rabi']=='Y'){ $Df=$Rdf; $Dt=$Rdt; }
//elseif($rSe['Summer']=='Y'){ $Df=$Sdf; $Dt=$Sdt; }

$cD=date("Y-m-d");

if($cD>=$rVd['Kharif_From'] && $cD<=$rVd['Kharif_To']){ $Df=$Kdf; $Dt=$Kdt; }
elseif($cD>=$rVd['Rabi_From'] && $cD<=$rVd['Rabi_To']){ $Df=$Rdf; $Dt=$Rdt; }
elseif($cD>=$rVd['Summer_From'] && $cD<=$rVd['Summer_To']){ $Df=$Sdf; $Dt=$Sdt; }

?>

<input type="hidden" id="Kdf" value="<?=$Kdf?>" />
<input type="hidden" id="Kdt" value="<?=$Kdt?>" />

<input type="hidden" id="Rdf" value="<?=$Rdf?>" />
<input type="hidden" id="Rdt" value="<?=$Rdt?>" />

<input type="hidden" id="Sdf" value="<?=$Sdf?>" />
<input type="hidden" id="Sdt" value="<?=$Sdt?>" />				

				

				    <th>&nbsp;Season:<br><select style="padding: 4px;border-radius: 4px;cursor:pointer;" onchange="setseason(this.value)"><option value="">Select Season</option>

					<option value="kharif" <?php if($cD>=$rVd['Kharif_From'] && $cD<=$rVd['Kharif_To']){echo 'selected';} ?>>Kharif</option>
					<option value="rabi" <?php if($cD>=$rVd['Rabi_From'] && $cD<=$rVd['Rabi_To']){echo 'selected';} ?>>Rabi</option>
					<option value="summer" <?php if($cD>=$rVd['Summer_From'] && $cD<=$rVd['Summer_To']){echo 'selected';} ?>>Summer</option>

					</select>  



				    	<!--<label id="klabel" for="kharif" style="padding: 4px;border-radius: 4px;cursor:pointer;"><input type="radio" name="season" value="kharif" id="kharif" onclick="setseason('kharif')"> Kharif </label>

				    	&nbsp;&nbsp;

				    	<label id="rlabel" for="rabi"  style="padding: 4px;border-radius: 4px;cursor:pointer;"><input type="radio" name="season" value="rabi" id="rabi" onclick="setseason('rabi')"> Rabi </label>-->

				    	<script type="text/javascript">

				    		function setseason(se){

				    			var curdate = $('#from').val();
				    			var curyear = curdate.split("-");
				    			curyear = curyear[2];

				    			var nextyear = parseInt(curyear)+1;

				    			if(se=='kharif'){
				    				$('#from').val($('#Kdf').val());
				    				$('#to').val($('#Kdt').val());

				    			}else if(se == 'rabi'){
				    				$('#from').val($('#Rdf').val());
				    				$('#to').val($('#Rdt').val());

				    			}else if(se == 'summer'){
				    				$('#from').val($('#Sdf').val());
				    				$('#to').val($('#Sdt').val());
				    			}
				    		}

				    	</script>

				    </th>

				    <th>&nbsp;From: <input type="" class="dtinp" id="from" value="<?=$Df;?>" autocomplete="off"><br /><br />

					    &nbsp;To:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="" class="dtinp" id="to" value="<?=$Dt;?>" autocomplete="off">

					</th>

				

					<!--<th>&nbsp;To: <br /><input type="" class="dtinp" id="to" autocomplete="off">&nbsp;</th>-->

					<th>&nbsp;Crop: &nbsp;&nbsp;&nbsp;<select id="crop" onchange="SelCrop(this.value)" style="width:110px;"><option value="">Select</option>

							        <?php foreach ($crarr as $key => $value) { ?>

							        <option value="<?=$key?>" ><?=$value?></option>

							        <?php } ?></select><br /><br />

						&nbsp;Prod<sup>n</sup> Code: <select id="prodcode" style="width:80px;"></select>

					

					<script>

					 function SelCrop(crop)

					 { 

					     

					     document.getElementById("divsearch").style.display='none'; 

					     

					     $.post("agrlotreport_act.php",{ action:'get_prodcode',crop:crop},function(data){

				       $('#prodcode').html(data); }); 

					     

					   

					     

					 }

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

						&nbsp;Users: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select id="users" style="width:190px;"><option value="">All</option>

							         <?php foreach ($uarr as $key => $value) { ?>

							         <option value="<?=$key?>"><?=ucfirst(strtolower($value))?></option>

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

								var users = $('#users').val(); 

								var sii = $('#sii').val();

		                        var dii = $('#dii').val();

		                        var tii = $('#tii').val();

		                        var vii = $('#vii').val();

								var keywordSearch = $('#keywordSearch').val(); 

								myWindow = window.open('exportagri_all_lot.php?from='+from+'&to='+to+'&crop='+crop+'&secondparty='+secondparty+'&orgr='+orgr+'&users='+users+'&keywordSearch='+keywordSearch+'&prodcode='+prodcode+'&pperson='+pperson+'&pexe='+pexe+'&sii='+sii+'&dii='+dii+'&tii='+tii+'&vii='+vii, '_blank', 'location=yes,height=300,width=300,scrollbars=yes,status=yes');

								/*setTimeout(function(){ 

									myWindow.close();

								},1000);*/

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



		<table class=" estable table table-bordered" style="width:100%;">

			<thead>

				<tr>

					<th style="width:40px;">S.No</th>

					<th style="width:80px;">Agreement<br />ID</th>

					<th style="width:60px;">Agreement<br />Date</th>

					<th style="width:50px;">Crop</th>

					<th style="width:50px;">Hybrid<br />Code</th>

					<th style="width:60px;">FSCode<br />Female/Male</th>

					<th style="width:100px;">Organiser<br />Name</th>

					<th style="width:100px;">Farmer Name</th>

					<th style="width:60px;">Stand_Acre<br/>(GPS Measure)</th>

					

					<th style="width:50px;">LotNo</th>

					<th style="width:60px;">No.Of<br>Bag</th>

					<th style="width:60px;">Qty</th>

					<th style="width:60px;">Quality<br>Grade</th>

					<th style="width:60px;">Moisure</th>	

				</tr> 

			</thead>

			<tbody id="reportBody">

				

			</tbody>

		</table>

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

		var users = $('#users').val();

		var keywordSearch = $('#keywordSearch').val(); 

        

        

		$.post("agrlotreport_act.php",{ act:'get_agr_report_list',page:page,crop:crop,orgr:orgr,from:from,to:to,secondparty:secondparty,users:users,keywordSearch:keywordSearch,prodcode:prodcode,pperson:pperson,pexe:pexe,sii:sii,dii:dii,tii:tii,vii:vii},function(data) { 

			$('#reportBody').html(data);  //alert(data);

			// console.log(data);

			var tt=$('#countval').val(); //alert(tt);

			if(tt>0)

			{ 

			 document.getElementById("divsearch").style.display='block'; 

			}

	    });

	    

	    

	    //document.getElementById("divsearch").style.display='block';



	}



	function pad2(number) {

	    return (number < 10 ? '0' : '') + number;

	}



	$(document).ready(function(){

		/* 

		==========================================================================================================

			below code is for setting and showing "from date" and "to date" to last 7 days to today and showing

			last 7days result by default page load

		=============================================================================================================

		*/

		var from = $('#from').val();

		var to = $('#to').val();

		if(from=='' && to==''){

			var d = new Date();

			var week = new Date();

			week.setDate(d.getDate()-1);



			var dd = d.getDate();

			var dm = d.getMonth()+1;

			var dy = d.getFullYear();

			d = pad2(dd) + '-' + pad2(dm) + '-' + dy;

			$('#to').val(d);



			var wd = week.getDate();

			var wm = week.getMonth()+1;

			var wy = week.getFullYear();

			week = pad2(wd) + '-' + pad2(wm) + '-' + wy;

			$('#from').val(week);



			

		}



		

		

	});



	

	function editagri(agid,agyear){ //alert(agid+"-"+agyear);

		$('#editAgrDiv').show(1500);

		$('#editAgrIframe').attr('src','editAgreement.php?agid='+agid+'&agyear='+agyear);

	}

	



</script>









