<?php
session_start();
include 'config.php';

if(isset($_POST['act']) && $_POST['act']=='getOrganiser'){

	$o=mysql_query('SELECT o.oid,o.`oname` FROM organiser o inner join `farmers` f on o.oid=f.oid where f.fid='.$_REQUEST['fid']);
 	$od=mysql_fetch_assoc($o); ?><option value="<?=$od['oid']?>"><?=$od['oname']?></option>
	<?php

}elseif(isset($_POST['act']) && $_POST['act']=='getProdPerson'){

  /*
  $u1=mysql_query("SELECT u.* FROM `users` u, `farmers` f,`user_location` ul where f.fid='".$_REQUEST['fid']."' and f.village_id=ul.village_id and  u.uid = ul.uid and  ul.sts='A' and u.uStatus='A' and uType='U' and (uPost=2 OR uPost=5 OR uPost=7)"); //$rowud=mysql_num_rows($u);
  //uPost=2 is the id of Production Person
  while($ud1=mysql_fetch_assoc($u1)){  ?><option value="<?=$ud1['uId']?>"><?=$ud1['uName']?></option><?php } 
  */
  
  /*
  if($_SESSION['uId']==134 OR $_SESSION['uId']==271 OR $_SESSION['uId']==280 OR $_SESSION['uId']==195 OR $_SESSION['uId']==196 OR $_SESSION['uId']==197 OR $_SESSION['uId']==198 OR $_SESSION['uId']==199 OR $_SESSION['uId']==200)
  {
   $u=mysql_query("SELECT u.* FROM `users` u, `user_location` ul where u.uId = ul.uid and ul.sts='A' and u.uStatus='A' and uType='U' and (uPost=2 OR uPost=5 OR uPost=7 OR uPost=3) and (ul.state_id=5 OR ul.state_id=21 OR ul.state_id=23) and u.uId!=134 and u.uId!=195 and u.uId!=196 and u.uId!=197 and u.uId!=198 and u.uId!=199 and u.uId!=200 group by u.uId order by u.uName asc");   
  }
  else
  {
  $u=mysql_query("SELECT u.* FROM `users` u, `farmers` f,`user_location` ul where f.fid='".$_REQUEST['fid']."' and f.state_id=ul.state_id and u.uId = ul.uid and ul.sts='A' and u.uStatus='A' and uType='U' and (uPost=2 OR uPost=5 OR uPost=7 OR uPost=10) and u.uId!=12 order by u.uName asc");
  }
  */
  
  $u=mysql_query("SELECT * FROM `users` where uStatus='A' and uType='U' order by uName");
  while($ud=mysql_fetch_assoc($u)){ ?><option value="<?=$ud['uId']?>"><?=strtoupper($ud['uName'])?></option><?php }
  
  /*
  $u=mysql_query("SELECT u.* FROM `users` u, `farmers` f,`user_location` ul where f.fid='".$_REQUEST['fid']."' and f.state_id=ul.state_id and  u.uid = ul.uid and  ul.sts='A' and u.uStatus='A' and uType='U' and uPost=2"); 
  //uPost=2 is the id of Production Person

  while($ud=mysql_fetch_assoc($u)){ 
  ?>
  	<option value="<?=$ud['uId']?>"><?=$ud['uName']?></option>	
  <?php
  }
  */

}elseif(isset($_POST['act']) && $_POST['act']=='getProdExecutive'){
  
  /*
  $rep=mysql_query("select uReporting from users where uId=".$_POST['pid']); $urep=mysql_fetch_assoc($rep);
  $u1=mysql_query("SELECT * FROM `users` where uId='".$urep['uReporting']."' and uPost=3");  $rwu1=mysql_num_rows($u1);
  if($rwu1>0){ $ud1=mysql_fetch_assoc($u1); ?><option value="<?=$ud1['uId']?>"><?=$ud1['uName']?></option><?php }
  */
  /*
  if($_SESSION['uId']==134 OR $_SESSION['uId']==271 OR $_SESSION['uId']==280 OR $_SESSION['uId']==195 OR $_SESSION['uId']==196 OR $_SESSION['uId']==197 OR $_SESSION['uId']==198 OR $_SESSION['uId']==199 OR $_SESSION['uId']==200)
  {
    $u=mysql_query("SELECT u.* FROM `users` u, `user_location` ul where u.uId = ul.uid and ul.sts='A' and u.uStatus='A' and uType='U' and (uPost=3 OR uPost=4 OR uPost=2 OR uPost=5 OR uPost=7) and (ul.state_id=5 OR ul.state_id=21 OR ul.state_id=23) and u.uId!=134 and u.uId!=195 and u.uId!=196 and u.uId!=197 and u.uId!=198 and u.uId!=199 and u.uId!=200 group by u.uId order by u.uName asc");   
  }
  else
  {
  $u=mysql_query("SELECT u.* FROM `users` u, `farmers` f,`user_location` ul where f.fid='".$_REQUEST['fid']."' and f.state_id=ul.state_id and  u.uId = ul.uid and ul.sts='A' and u.uStatus='A' and uType='U' and uPost=3 and u.uId!=12 order by u.uName asc ");
  }
  //uPost=3 is the id of Production Executive
  */
  
  $u=mysql_query("SELECT * FROM `users` where uStatus='A' and uType='U' order by uName");
  while($ud=mysql_fetch_assoc($u)){ ?><option value="<?=$ud['uId']?>"><?=strtoupper($ud['uName'])?></option><?php }
  
  
  /*
  $u=mysql_query("SELECT u.* FROM `users` u, `farmers` f,`user_location` ul where f.fid='".$_REQUEST['fid']."' and f.state_id=ul.state_id and  u.uid = ul.uid and  ul.sts='A' and u.uStatus='A' and uType='U' and uPost=3");
  //uPost=3 is the id of Production Executive

  while($ud=mysql_fetch_assoc($u)){ 
  ?>
  	<option value="<?=$ud['uId']?>"><?=$ud['uName']?></option>	
  <?php
  }
  */

}elseif(isset($_POST['act']) && $_POST['act']=='get_production_code'){

	$f=mysql_query('SELECT `production_code` FROM `master_fsqc_transaction` where cropid='.$_REQUEST['cid']);
	$rows=mysql_num_rows($f);
	if($rows>0){ echo '<option value="">Select</option>'; }else{echo '<option value=""></option>';}
	while($fd=mysql_fetch_assoc($f))
	{ ?> <option value="<?=$fd['production_code'];?>" <?php if($_REQUEST['prdcd']==$fd['production_code']){echo 'selected';} ?>><?=$fd['production_code'];?></option><?php }


}elseif(isset($_POST['act']) && $_POST['act']=='getLand'){

	$f=mysql_query('SELECT flandid,land_area,TahsilId,VillageId FROM farmers_land where fid='.$_REQUEST['fid']);
	$rows=mysql_num_rows($f);
	if($rows==0){ echo '<option value="0">Select</option>';}
	while($fd=mysql_fetch_assoc($f))
	{ 
	    $sqv=mysql_query('select VillageName from village where VillageId='.$fd['VillageId']); $rev=mysql_fetch_assoc($sqv);
	$sqt=mysql_query('select TahsilName from tahsil where TahsilId='.$fd['TahsilId']); $ret=mysql_fetch_assoc($sqt);
	    echo '<option value='.$fd['flandid'].'>'.$fd['land_area'].' - '.$rev['VillageName'].' - '.$ret['TahsilName'].'</option>'; 
	    
	}

		
}
elseif(isset($_POST['act']) && $_POST['act']=='get_type')
{
  $ft=mysql_query("SELECT * FROM `master_fsqc_transaction` where `production_code`='".$_REQUEST['pid']."'");
  $fdt=mysql_fetch_assoc($ft); 
  echo '<input type="hidden" id="typev" value="'.$fdt['type'].'" />';
  echo '<input type="hidden" id="spcode_f1v" value="'.$fdt['spcode_f1'].'" />';
  echo '<input type="hidden" id="spcode_f2v" value="'.$fdt['spcode_f2'].'" />';
  echo '<input type="hidden" id="spcode_m1v" value="'.$fdt['spcode_m1'].'" />';
  echo '<input type="hidden" id="spcode_m2v" value="'.$fdt['spcode_m2'].'" />';
  
  $f=mysql_query("SELECT `estimated_yield` FROM `master_fsqc_transaction` where `production_code`='".$_REQUEST['pid']."' and type='".$fdt['type']."'"); $fy=mysql_fetch_assoc($f);
  echo '<input type="hidden" id="estimated_yieldv" value="'.$fy['estimated_yield'].'" />';
  
  $fQc=mysql_query("SELECT * FROM `master_crop_qc` where `cropid`='".$fdt['cropid']."' and type='".$fdt['type']."'");
  $frQc=mysql_fetch_assoc($fQc);
  
  echo '<input type="hidden" id="germinationv" value="'.$frQc['germination'].'" />';
  echo '<input type="hidden" id="genetic_purityv" value="'.$frQc['genetic_purity'].'" />';
  echo '<input type="hidden" id="physical_purity" value="'.$frQc['physical_purity'].'" />';
  echo '<input type="hidden" id="moisturev" value="'.$frQc['moisture'].'" />';
 	
}






/*elseif(isset($_POST['act']) && $_POST['act']=='get_type')
{
   $ft=mysql_query("SELECT `type` FROM `master_fsqc_transaction` where `production_code`='".$_REQUEST['pid']."'");
   $fdt=mysql_fetch_assoc($ft); echo $fdt['type']; 			
}
elseif(isset($_POST['act']) && $_POST['act']=='get_fs_code_female1')
{

	$f=mysql_query("SELECT `spcode_f1`,`spcode_f2` FROM `master_fsqc_transaction` where `production_code`='".$_REQUEST['pid']."' and type='".$_REQUEST['ctype']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['spcode_f1'];

}
elseif(isset($_POST['act']) && $_POST['act']=='get_fs_code_female2')
{

	$f=mysql_query("SELECT `spcode_f1`,`spcode_f2` FROM `master_fsqc_transaction` where `production_code`='".$_REQUEST['pid']."' and type='".$_REQUEST['ctype']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['spcode_f2'];

}
elseif(isset($_POST['act']) && $_POST['act']=='get_fs_code_male1')
{

	$f=mysql_query("SELECT `spcode_m1`,`spcode_m2` FROM `master_fsqc_transaction` where `production_code`='".$_REQUEST['pid']."' and type='".$_REQUEST['ctype']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['spcode_m1'];

}
elseif(isset($_POST['act']) && $_POST['act']=='get_fs_code_male2')
{

	$f=mysql_query("SELECT `spcode_m1`,`spcode_m2` FROM `master_fsqc_transaction` where `production_code`='".$_REQUEST['pid']."' and type='".$_REQUEST['ctype']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['spcode_m2'];

}
elseif(isset($_POST['act']) && $_POST['act']=='get_crop_type')
{

	$f=mysql_query("SELECT `type` FROM `master_fsqc_transaction` where `production_code`='".$_REQUEST['pid']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['type'];

}
elseif(isset($_POST['act']) && $_POST['act']=='get_germ')
{

	$f=mysql_query("SELECT `germination` FROM `master_crop_qc` where `cropid`='".$_REQUEST['cid']."' and type='".$_REQUEST['ctype']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['germination'];

}
elseif(isset($_POST['act']) && $_POST['act']=='get_genpur')
{

	$f=mysql_query("SELECT `genetic_purity` FROM `master_crop_qc` where `cropid`='".$_REQUEST['cid']."' and type='".$_REQUEST['ctype']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['genetic_purity'];

}
elseif(isset($_POST['act']) && $_POST['act']=='get_phypur')
{

	$f=mysql_query("SELECT `physical_purity` FROM `master_crop_qc` where `cropid`='".$_REQUEST['cid']."' and type='".$_REQUEST['ctype']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['physical_purity'];

}
elseif(isset($_POST['act']) && $_POST['act']=='get_moisture')
{

	$f=mysql_query("SELECT `moisture` FROM `master_crop_qc` where `cropid`='".$_REQUEST['cid']."' and type='".$_REQUEST['ctype']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['moisture'];

}
elseif(isset($_POST['act']) && $_POST['act']=='get_est_yield')
{

	$f=mysql_query("SELECT `estimated_yield` FROM `master_fsqc_transaction` where `production_code`='".$_REQUEST['pid']."' and type='".$_REQUEST['ctype']."'");
	$fd=mysql_fetch_assoc($f);
	echo $fd['estimated_yield'];

}*/
?>