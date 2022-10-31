<div id="loaderDiv" style="background-color: rgba(0,0,0,0.8);width: 100%;height: 100%;position: fixed;top:0px;left: 0px;font-size: 12px;z-index:9999999;">
  <span style="color:white;top: 40%;left:42%;position: absolute;">Please Wait, getting all agreement data...<img src="image/loader.gif"></span>
</div>

<?php 
session_start(); 
include 'sidemenu.php'; 

$alls=mysql_query("SELECT * FROM `state` s ,user_location l where l.state_id=s.StateId and l.uid=".$_SESSION['uId']." AND l.sts='A' order by StateName"); 
while ($allsd=mysql_fetch_assoc($alls))
{
  $sarr[$allsd['StateId']]=$allsd['StateName'];
}
$_SESSION['sarr']=$sarr;


$alld=mysql_query("SELECT DictrictId, DictrictName FROM `distric` d, state s, user_location ul where ul.uid=".$_SESSION['uId']." AND ul.sts='A' and ul.state_id=s.StateId and s.StateId=d.StateId order by DictrictName asc"); 
while ($alldd=mysql_fetch_assoc($alld))
{
  $darr[$alldd['DictrictId']]=strtoupper($alldd['DictrictName']);
}
$_SESSION['darr']=$darr;


$allt=mysql_query("SELECT TahsilId,TahsilName FROM `tahsil` t, distric d,state s,user_location l where  l.uid=".$_SESSION['uId']." AND l.sts='A' and l.state_id=s.StateId and  d.StateId=s.StateId and t.DistrictId=d.DictrictId order by TahsilName");
while ($alltd=mysql_fetch_assoc($allt)){
  $tarr[$alltd['TahsilId']]=strtoupper($alltd['TahsilName']);
}
$_SESSION['tarr']=$tarr;


$allv=mysql_query("SELECT VillageId,VillageName FROM `village` v, tahsil t, distric d, state s,user_location l where l.uid=".$_SESSION['uId']." AND l.sts='A' and s.StateId=l.state_id and d.StateId=s.StateId and t.DistrictId=d.DictrictId and v.TahsilId=t.TahsilId  order by VillageName"); 
while ($allvd=mysql_fetch_assoc($allv)){
  $varr[$allvd['VillageId']]=strtoupper($allvd['VillageName']);
}
$_SESSION['varr']=$varr;


$allo=mysql_query("SELECT * FROM `organiser` order by oname asc");
while($allod=mysql_fetch_assoc($allo))
{
 $oarr[$allod['oid']]=strtoupper($allod['oname']);
}
$_SESSION['oarr']=$oarr;

$allv=mysql_query("SELECT VillageId,VillageName,TahsilName FROM `village` v inner join tahsil t on v.TahsilId=t.TahsilId inner join distric d on t.DistrictId=d.DictrictId inner join state s on d.StateId=s.StateId inner join user_location l on l.state_id=s.StateId where l.uid=".$_SESSION['uId']." AND l.sts='A' group by l.state_id, VillageId order by VillageName"); 
while ($allvd=mysql_fetch_assoc($allv)){
  $varrtarr[$allvd['VillageId']]=strtoupper($allvd['VillageName'].'-'.$allvd['TahsilName']);
}
$_SESSION['varrtarr']=$varrtarr;


$sSe=mysql_query("select * from view_season where SesId=1"); $rSe=mysql_fetch_assoc($sSe);
$sVd=mysql_query("select * from app_version where VersionId=1"); $rVd=mysql_fetch_assoc($sVd);  
if($rSe['Kharif']=='Y'){ $Df=$rVd['Kharif_From']; $Dt=$rVd['Kharif_To']; }
elseif($rSe['Rabi']=='Y'){ $Df=$rVd['Rabi_From']; $Dt=$rVd['Rabi_To']; }

?>

<style type="text/css">
.pagethings{ position:absolute; left:200px; padding:20px; }
.card{ margin-top:50px; background-color:#D3E4EF; cursor:pointer; border:1px solid #c1c1c1;
       font-family: font-family: Arial, Helvetica, sans-serif;
       padding: 40px 0px; }
.count{ font-size:35px;font-weight:bold; color:#3F779E; }
</style>

<div class="pagethings" style="width:85%;">
 <div class="card-deck" style="padding-right:50px;padding-left:50px;">

<!-- 1111111111111111111111111111111111111111 Open -->
<!-- 1111111111111111111111111111111111111111 Open --> 
<?php 
$stid= mysql_query("SELECT state_id from user_location where uid=".$_SESSION['uId']." AND sts='A' AND state_id>0");
$rows=mysql_num_rows($stid);
while($rec=mysql_fetch_array($stid)){ $array_s[]=$rec['state_id']; }
if($array_s!=''){ $state = implode(',', $array_s); }else{ $state=0; }

$utid= mysql_query("SELECT uid from user_location where state_id in (".$state.") AND sts='A' AND state_id>0 group by uid");
$rowu=mysql_num_rows($utid);

while($recu=mysql_fetch_array($utid)){ $array_u[]=$recu['uid']; }
if($array_u!=''){ $user = implode(',', $array_u); }else{ $user=0; }
//$user = implode(',', $array_u);
?>

 <div class="card bg" >
  <div class="card-body text-center" onClick="FunDetails('fu','<?=$_SESSION['uType'];?>',<?=$_SESSION['uId'];?>)">
<?php //$sf=mysql_query("select count(*) as totf from farmers where ".$qry." AND (oid IS NULL OR bank_name IS NULL OR account_no IS NULL OR ifsc_code IS NULL OR village_id IS NULL OR father_name IS NULL)"); 
//$sf=mysql_query("SELECT count(*) as totf FROM `farmers` where (state_id in ($state) OR cr_by in ($user)) AND (oid IS NULL OR bank_name IS NULL OR account_no IS NULL OR ifsc_code IS NULL OR village_id IS NULL OR father_name IS NULL) AND cr_date between '".$Df."' AND '".$Dt."'"); 
$sf=mysql_query("SELECT count(*) as totf FROM `farmers` where (oid IS NULL OR bank_name IS NULL OR account_no IS NULL OR ifsc_code IS NULL OR village_id IS NULL OR father_name IS NULL OR state_id='' OR distric_id='' OR tahsil_id='' OR village_id='')");   //AND cr_date between '".$Df."' AND '".$Dt."'  
$rf=mysql_fetch_assoc($sf); ?>
	<p class="card-text"><b style="color:#3f779e;font-size:18px;">Un-Completed New Farmer List</b>
	<br><font class="count"><?=$rf['totf'];?></font>	  
	</p>
  </div>
 </div>

 <div class="card bg">
  <div class="card-body text-center" onClick="FunDetails('fc','<?=$_SESSION['uType'];?>',<?=$_SESSION['uId'];?>)">
  <?php //$sfc=mysql_query("select count(*) as totfc from farmers where ".$qry." AND oid>0 AND bank_name IS NOT NULL AND account_no IS NOT NULL AND ifsc_code IS NOT NULL AND village_id IS NOT NULL AND father_name IS NOT NULL");  
  //$sfc=mysql_query("SELECT count(*) as totfc from farmers where (state_id in ($state) OR cr_by in ($user)) AND oid>0 AND bank_name IS NOT NULL AND account_no IS NOT NULL AND ifsc_code IS NOT NULL AND village_id IS NOT NULL AND father_name IS NOT NULL AND cr_date between '".$Df."' AND '".$Dt."'"); 
  $sfc=mysql_query("SELECT count(*) as totfc from farmers where oid>0 AND bank_name IS NOT NULL AND account_no IS NOT NULL AND ifsc_code IS NOT NULL AND village_id IS NOT NULL AND father_name IS NOT NULL AND state_id!='' AND distric_id!='' AND tahsil_id!='' AND village_id!=''");
  
  //AND cr_date between '".$Df."' AND '".$Dt."'
  
  $rfc=mysql_fetch_assoc($sfc); ?>
  <p class="card-text"><b style="color:#3f779e;font-size:18px;">Completed New Farmer List</b>
  <br><font class="count"><?=$rfc['totfc'];?></font>	  
  </p>
  </div>
 </div>	

<!-- 1111111111111111111111111111111111111111 Close -->
<!-- 1111111111111111111111111111111111111111 Close -->
<?php if($_SESSION['uType']!='U'){ 
$Tsfc=mysql_query("SELECT count(*) as totfc from farmers"); $Trfc=mysql_fetch_assoc($Tsfc);

?>
 <div class="card bg" >
  <div class="card-body text-center"> <!---onClick="window.location='users.php'" -->
	<p class="card-text"><b style="color:#3f779e;font-size:14px;">Total Farmer</b>
	 <br><font class="count"><?=$Trfc['totfc'];?></font>	  
	</p>
  </div>

  <div class="card-body text-center"> <!---onClick="window.location='users.php'" -->
  <?php $su=mysql_query("select count(*) as totu from users where uStatus='A' and uType!='S'"); $ru=mysql_fetch_assoc($su);?>
	<p class="card-text"><b style="color:#3f779e;font-size:14px;">Total User</b>
	 <br><font class="count"><?=$ru['totu'];?></font>	  
	</p>
  </div>
 </div>	
 <?php } ?>
 </div>
</div>

<script type="text/javascript">
function FunDetails(v)
{
 window.location="homelist.php?v="+v;
}
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#loaderDiv').hide();
  });
</script>





