<?php
session_start();
include 'config.php'; 


function gethierarchy($uid){

	$id=array($uid);
	
	if($_SESSION['uType']=='S' OR $_SESSION['uId']==134){
		$sel=mysql_query("select uId from users");
		while($seld = mysql_fetch_assoc($sel)){

			$idc = array($seld['uId']);

			$id = array_merge($id,$idc);

		}

	}else{
		$sel=mysql_query("select uId from users where uReporting='".$uid."'");

		if(mysql_num_rows($sel) > 0){
			while($seld = mysql_fetch_assoc($sel)){

				$idc = array($seld['uId']);

				$id = array_merge($id,$idc,gethierarchy($seld['uId']));

			}

		}
	}

	return $id;	

}



if(isset($_POST['action']) && $_POST['crop']!='' && $_POST['action']=='get_prodcode')
{
 echo '<option value="">Select</option>';
 $spc=mysql_query("select production_code from master_fsqc_transaction where cropid=".$_POST['crop']." group by production_code order by production_code"); while($rpc=mysql_fetch_assoc($spc)){ echo '<option value='.$rpc['production_code'].'>'.$rpc['production_code'].'</option>'; }
}

if(isset($_POST['action']) && $_POST['si']!='' && $_POST['action']=='get_di')
{
 echo '<option value="">Select</option>';
 $spc=mysql_query("select DictrictId,DictrictName from `distric` where StateId=".$_POST['si']." order by DictrictName"); while($rpc=mysql_fetch_assoc($spc)){ echo '<option value='.$rpc['DictrictId'].'>'.$rpc['DictrictName'].'</option>'; }
}

if(isset($_POST['action']) && $_POST['di']!='' && $_POST['action']=='get_ti')
{
 echo '<option value="">Select</option>';
 $spc=mysql_query("select TahsilId,TahsilName FROM `tahsil` where DistrictId=".$_POST['di']." order by TahsilName"); while($rpc=mysql_fetch_assoc($spc)){ echo '<option value='.$rpc['TahsilId'].'>'.$rpc['TahsilName'].'</option>'; }
}

if(isset($_POST['action']) && $_POST['ti']!='' && $_POST['action']=='get_vi')
{
 echo '<option value="">Select</option>';
 $spc=mysql_query("select VillageId,VillageName FROM `village` where TahsilId=".$_POST['ti']." order by VillageName"); while($rpc=mysql_fetch_assoc($spc)){ echo '<option value='.$rpc['VillageId'].'>'.$rpc['VillageName'].'</option>'; }
}




if(isset($_POST['act']) && $_POST['act']=='get_report'){

	$alls=mysql_query('SELECT * FROM `state`');
	while ($allsd=mysql_fetch_assoc($alls)) {
		$sarr[$allsd['StateId']]=$allsd['StateName'];
	}

	$alld=mysql_query('SELECT * FROM `distric`');
	while ($alldd=mysql_fetch_assoc($alld)) {
		$darr[$alldd['DictrictId']]=$alldd['DictrictName'];
	}

	$allt=mysql_query('SELECT * FROM `tahsil`');
	while ($alltd=mysql_fetch_assoc($allt)) {
		$tarr[$alltd['TahsilId']]=$alltd['TahsilName'];
	}

	$allv=mysql_query('SELECT * FROM `village`');
	while ($allvd=mysql_fetch_assoc($allv)) {
		$varr[$allvd['VillageId']]=$allvd['VillageName'];
	}

	$from = date('Y-m-d',strtotime($_POST['from']));
	$agyearf = (int)date('Y',strtotime($_POST['from']));

	$to = date('Y-m-d',strtotime($_POST['to']));
	$agyeart = (int)date('Y',strtotime($_POST['to']));

	//==== query condition for crop filter =======================================================
	if(isset($_POST['crop']) && $_POST['crop']!=''){
		$cropCond="agr.ann_crop=".$_POST['crop'];
	}else{
		$cropCond='1=1';
	}

	//==== query condition for organiser filter ==================================================
	if(isset($_POST['orgr']) && $_POST['orgr']!=''){
		$orgrCond="agr.org_id=".$_POST['orgr'];
	}else{
		$orgrCond='1=1';
	}

	//==== query condition for organiser filter ==================================================
	if(isset($_POST['secondparty']) && $_POST['secondparty']!=''){
		$farmerCond="agr.second_party=".$_POST['secondparty'];
	}else{
		$farmerCond='1=1';
	}

	//==== query condition for user filter ==================================================
	if(isset($_POST['users']) && $_POST['users']!=''){
		$userCond="agr.cr_by=".$_POST['users'];
	}else{
		$userCond='1=1';
	}



	//==== query condition for getting results as per users hierarchy ================= start =====================
   if($_SESSION['uId']!=134){
	$allids = array_unique(gethierarchy($_SESSION['uId']));
	$hierarchyCond = "agr.cr_by IN (".implode(', ', $allids).")";
   }
   else
   {
       $hierarchyCond='1=1';
       
   }
	//==== query condition for getting results as per users hierarchy ================= end =======================




	//==== this query is for only counting number of results for setting limits on actual query ===================

	$qry="";
	for ($i=$agyearf; $i <= $agyeart; $i++) {

		$qry.=" SELECT agr.*, u.uName, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id FROM `agreement_".$i."` agr, users u, farmers f, organiser o where agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond." and ".$farmerCond." and ".$hierarchyCond." and ".$userCond;
		if($i!=$agyeart){
			$qry.=' UNION';
		}

		// echo $i.'<br>';
	}

	$agra=mysql_query($qry);
	$agcou=mysql_num_rows($agra);
	if($agcou>20){
		$pages=ceil($agcou/20);
	}else{
		$pages=1;
	}

	//==== query condition for setting number of pages as per number of results ==================================================
	if(isset($_POST['page']) && $_POST['page']!=''){
		$start=((int)$_POST['page']-1)*20;
		$limitCond=" LIMIT ".$start.", 20";
		$curpage=$_POST['page'];
		$sno=$start+1;
	}else{
		$limitCond=" LIMIT 20";
		$curpage=1;
		$sno=1;
	}

	if($agcou==0){
	?>
	<tr>
		<td colspan="15">No results found as per your applied filters</td>
	</tr>
	<?php
	}

	//===== actual query with limits which returning limiited number of results as per page number =============================
	$agr=mysql_query($qry.$limitCond);
	while ($agrd=mysql_fetch_assoc($agr)) {
	
	
	
	if($agrd['ann_crop']>0)
	{ $cr=mysql_fetch_assoc(mysql_query("select cropname,cropcode from crop where cropid=".$agrd['ann_crop'])); 
	  $cropn=$cr['cropcode']; }else{ $cropn=''; }
	if($agrd['ann7_flandid']>0)
	{
	 
	 /*
	 $fld=mysql_query('SELECT StateId as st,DictrictId as dt,TahsilId as tt,VillageId vt FROM farmers_land where flandid='.$agrd['ann7_flandid']); $rld=mysql_fetch_assoc($fld);
     if($rld['st']>0){ $sr=mysql_fetch_assoc(mysql_query("select StateName from state where StateId=".$rld['st'])); 
	 $staten=$sr['StateName']; }else{ $staten=$sarr[$agrd['state_id']]; }
     if($rld['dt']>0){ $dr=mysql_fetch_assoc(mysql_query("select DictrictName from distric where DictrictId=".$rld['dt'])); 
	 $distn=$dr['DictrictName']; }else{ $distn=$darr[$agrd['distric_id']];  }
     if($rld['tt']>0){ $tr=mysql_fetch_assoc(mysql_query("select TahsilName from tahsil where TahsilId=".$rld['tt']));
	 $tahsiln=$tr['TahsilName']; }else{ $tahsiln=$tarr[$agrd['tahsil_id']]; }
     if($rld['vt']>0){ $vr=mysql_fetch_assoc(mysql_query("select VillageName from village where VillageId=".$rld['vt']));
	 $villagen=$vr['VillageName']; }else{ $villagen=$varr[$agrd['village_id']]; } */
	 
	 $staten=$sarr[$agrd['si']]; $distn=$darr[$agrd['di']]; 
	 $tahsiln=$tarr[$agrd['ti']]; $villagen=$varr[$agrd['vi']];
	 
	}
	else
	{
	 //$staten=''; $distn=''; $tahsiln=''; $villagen='';
	 $staten=$sarr[$agrd['state_id']]; $distn=$darr[$agrd['distric_id']]; 
	 $tahsiln=$tarr[$agrd['tahsil_id']]; $villagen=$varr[$agrd['village_id']];
	}
	
	?>
	<tr>
		<td><?=$sno?></td>
		<td><?=$agrd['agree_no']; ?></td>
		<td><?=date("d-m-Y",strtotime($agrd['agree_date'])); ?></td>
		<td><?=$cropn;?></td>
		<td><?=$agrd['ann_fscode_f'].' / '.$agrd['ann_fscode_m']?></td>
		<td style="text-align:left;"><?=$agrd['oname']?></td>
		<td style="text-align:left;"><?=$agrd['fname']?></td>
		<td style="text-align:left;"><?=$agrd['father_name']?></td>
		
		<?php /*?><td><?=$agrd['uName']?></td><?php */?>
		<?php /*?><td><?=$agrd['second_party']?></td><?php */?>
		
		<td><input type="text" style="border:hidden;width:100%;" value="<?=$varr[$agrd['village_id']].'-'.$tarr[$agrd['tahsil_id']]?>" /></td>
		<td><input type="text" style="border:hidden;width:100%;" value="<?=$darr[$agrd['distric_id']].'-'.$sarr[$agrd['state_id']]?>" /></td>
		<td><input type="text" style="border:hidden;width:100%;" value="<?=$villagen.' - '.$tahsiln?>" /></td>
		<td><input type="text" style="border:hidden;width:100%;" value="<?=$distn.' - '.$staten?>" /></td>
		<td><?=$agrd['sowing_acres']?></td>
		<td><?=$agrd['GPSMeasure']?></td>
	</tr>

	<?php
	$sno++;
	}
	?>
	<tr>
		<td colspan="14">
			<span style="float: left;">
				<?php
				if($agcou!=0){
				?>
				Showing <b><?=$start+1?></b> to <b><?=$sno-1?></b> out of <b><?=$agcou?></b> results
				<?php
				}
				?>
			</span>
			<span style="float: right;padding-right:5px;<?php if($agcou==0){echo 'display:none;';}?> ">
				Pages: 
				<?php
				if($curpage!=1){
				?>
				<button onclick="agreeSearch('<?=$curpage-1?>');">Prev</button>
				<?php
				}
				?>


				<?php
				if($pages>5){
					for($i=1;$i<=3;$i++){
					?>
					<button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
					<?php
					}
					?>
					...
					<?php
					if($curpage>3 && $curpage!=$pages){
						?>
						<button onclick="agreeSearch('<?=$curpage?>');" style="background-color: #0069D9; color:white;"><?=$curpage?></button>
						<?php
					}
					?>
					...
					<button onclick="agreeSearch('<?=$pages?>');" style="<?php if($pages==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$pages?></button>
					<?php
				}else{
					for($i=1;$i<=$pages;$i++){
					?>
					<button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
					<?php
					}
				}
				?>



				<?php
				if($curpage!=$pages){
				?>
				<button onclick="agreeSearch('<?=$curpage+1?>');" >Next</button>
				<?php
				}
				?>


			</span>
			<!-- <?=$agcou.'----'.$pages?> -->
			<?php
			// echo "SELECT agr.*, u.uName, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id FROM `agreement_".$agyear."` agr, users u, farmers f, organiser o where agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond.$limitCond;
			?>
			</td>
	</tr>
	<?php

}elseif(isset($_POST['act']) && $_POST['act']=='get_report_list'){


	$alls=mysql_query('SELECT * FROM `state`');
	while ($allsd=mysql_fetch_assoc($alls)) {
		$sarr[$allsd['StateId']]=$allsd['StateName'];
	}

	$alld=mysql_query('SELECT * FROM `distric`');
	while ($alldd=mysql_fetch_assoc($alld)) {
		$darr[$alldd['DictrictId']]=$alldd['DictrictName'];
	}

	$allt=mysql_query('SELECT * FROM `tahsil`');
	while ($alltd=mysql_fetch_assoc($allt)) {
		$tarr[$alltd['TahsilId']]=$alltd['TahsilName'];
	}

	$allv=mysql_query('SELECT * FROM `village`');
	while ($allvd=mysql_fetch_assoc($allv)){
		$varr[$allvd['VillageId']]=$allvd['VillageName'];
	}
	
	
	/************************* New User Condition *********************/
	
	$stid= mysql_query("SELECT state_id from user_location where state_id>0 and sts='A' and uid=".$_SESSION['uId']);
    $dtid= mysql_query("SELECT district_id from user_location where district_id>0 and sts='A' and uid=".$_SESSION['uId']);
    $ttid= mysql_query("SELECT tahsil_id from user_location where tahsil_id>0 and sts='A' and uid=".$_SESSION['uId']);
    $vtid= mysql_query("SELECT village_id from user_location where village_id>0 and sts='A' and uid=".$_SESSION['uId']);
   
    $rows=mysql_num_rows($stid); $rowd=mysql_num_rows($dtid); 
    $rowt=mysql_num_rows($ttid); $rowv=mysql_num_rows($vtid);
   
     
    if($rowv>0)
    {  
      while($rv=mysql_fetch_array($vtid)){ $array_v[]=$rv['village_id']; } 
      $vv = implode(',', $array_v); $qry='village_id'; $qryy='agr.vi';  
    } 
    else if($rowt>0)
    {  
      while($rt=mysql_fetch_array($ttid)){ $array_t[]=$rt['tahsil_id']; } 
      $vv = implode(',', $array_t); $qry='tahsil_id'; $qryy='agr.ti';
    }
    else if($rowd>0)
    {
      while($rd=mysql_fetch_array($dtid)){ $array_d[]=$rd['district_id']; } 
      $vv = implode(',', $array_d); $qry='distric_id'; $qryy='agr.di';
    }
    else
    {
      while($rs=mysql_fetch_array($stid)){ $array_s[]=$rs['state_id']; } 
      $vv = implode(',', $array_s); $qry='state_id'; $qryy='agr.si';
    }
	
	/************************* New User Condition *********************/
	

	$from = date('Y-m-d',strtotime($_POST['from']));
	$agyearf = (int)date('Y',strtotime($_POST['from']));

	$to = date('Y-m-d',strtotime($_POST['to']));
	$agyeart = (int)date('Y',strtotime($_POST['to']));
	
	
	


	//==== query condition for crop filter =======================================================
	if(isset($_POST['crop']) && $_POST['crop']!=''){
		$cropCond="agr.ann_crop=".$_POST['crop'];
	}else{
		$cropCond='1=1';
	}

	//==== query condition for organiser filter ==================================================
	if(isset($_POST['orgr']) && $_POST['orgr']!=''){
		$orgrCond="agr.org_id=".$_POST['orgr'];
	}else{
		$orgrCond='1=1';
	}

	//==== query condition for organiser filter ==================================================
	if(isset($_POST['secondparty']) && $_POST['secondparty']!=''){
		$farmerCond="agr.second_party=".$_POST['secondparty'];
	}else{
		$farmerCond='1=1';
	}

	//==== query condition for user filter ==================================================
	if(isset($_POST['users']) && $_POST['users']!=''){
		$userCond="agr.cr_by=".$_POST['users'];
	}else{
		if($_SESSION['uType']=='U' AND $_SESSION['uId']!=134){
			$userCond="agr.cr_by=".$_SESSION['uId'];
		}else{
			$userCond='1=1';
		}

	}

	
	//==== query condition for getting results as per users hierarchy ================= start =====================
    if($_SESSION['uId']!=134){
	$allids = array_unique(gethierarchy($_SESSION['uId']));
	$hierarchyCond = "agr.cr_by IN (".implode(', ', $allids).")";
    }
    else
    {

     $hierarchyCond='1=1';       
        
    }
	//==== query condition for getting results as per users hierarchy ================= end =======================

	
	//==== this query is for only counting number of results for setting limits on actual query ================================
	
	$qry="";
	for($i=$agyearf; $i <= $agyeart; $i++) {

		$qry.=" SELECT agr.*, u.uName, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id FROM `agreement_".$i."` agr, users u, farmers f, organiser o where agr.agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond." and ".$farmerCond." and ".$qryy." in (".$vv.")";
		//." and ".$hierarchyCond." and ".$userCond
		
		if($i!=$agyeart){
			$qry.=' UNION';
		}
		
		
		$qryS.=" SELECT sum(sowing_acres) as sowing, sum(GPSMeasure) as GPS FROM `agreement_".$i."` agr, users u, farmers f, organiser o where agr.agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond." and ".$farmerCond." and ".$qryy." in (".$vv.")";
		
		//." and ".$hierarchyCond." and ".$userCond
		
		if($i!=$agyeart){
			$qryS.=' UNION';
		}

		// echo $i.'<br>';
	}

	echo $qry;
	// exit;
	$agra=mysql_query($qry);
	$agcou=mysql_num_rows($agra);
	if($agcou>20){
		$pages=ceil($agcou/20);
	}else{
		$pages=1;
	}

	//==== query condition for setting number of pages as per number of results ==================================================
	if(isset($_POST['page']) && $_POST['page']!=''){
		$start=((int)$_POST['page']-1)*20;
		$limitCond=" LIMIT ".$start.", 20";
		$curpage=$_POST['page'];
		$sno=$start+1;
	}else{
		$limitCond=" LIMIT 20";
		$curpage=1;
		$sno=1;
	}


	if($agcou==0){
	?>
	<tr>
		<td colspan="15">No results found as per your applied filters</td>
	</tr>
	<?php
	
	}else{ $qryS=mysql_query($qryS); $agSum=mysql_fetch_assoc($qryS);
	?>
	<tr>
		<td colspan="14" style="text-align:right;"><b>Total:</b>&nbsp;</td>
		<td><b><?=number_format($agSum['sowing'],3)?></b></td>
		<td><b><?=number_format($agSum['GPS'],3)?></b></td>
		<td></td>
	</tr>
	<?php
	}


	//===== actual query with limits which returning limiited number of results as per page number =============================
	$agr=mysql_query($qry.$limitCond);
	while ($agrd=mysql_fetch_assoc($agr)) 
	{
	
	
	if($agrd['ann_crop']>0)
	{ $cr=mysql_fetch_assoc(mysql_query("select cropname,cropcode from crop where cropid=".$agrd['ann_crop'])); 
	  $cropn=$cr['cropcode']; }else{ $cropn=''; }
	if($agrd['ann7_flandid']>0)
	{
	 
	 /*
	 $fld=mysql_query('SELECT StateId as st,DictrictId as dt,TahsilId as tt,VillageId vt FROM farmers_land where flandid='.$agrd['ann7_flandid']); $rld=mysql_fetch_assoc($fld);
     if($rld['st']>0){ $sr=mysql_fetch_assoc(mysql_query("select StateName from state where StateId=".$rld['st'])); 
	 $staten=$sr['StateName']; }else{ $staten=$sarr[$agrd['state_id']]; }
     if($rld['dt']>0){ $dr=mysql_fetch_assoc(mysql_query("select DictrictName from distric where DictrictId=".$rld['dt'])); 
	 $distn=$dr['DictrictName']; }else{ $distn=$darr[$agrd['distric_id']]; }
     if($rld['tt']>0){ $tr=mysql_fetch_assoc(mysql_query("select TahsilName from tahsil where TahsilId=".$rld['tt']));
	 $tahsiln=$tr['TahsilName']; }else{ $tahsiln=$tarr[$agrd['tahsil_id']]; }
     if($rld['vt']>0){ $vr=mysql_fetch_assoc(mysql_query("select VillageName from village where VillageId=".$rld['vt']));
	 $villagen=$vr['VillageName']; }else{ $villagen=$varr[$agrd['village_id']]; } */
	 
	 $staten=$sarr[$agrd['si']]; $distn=$darr[$agrd['di']]; 
	 $tahsiln=$tarr[$agrd['ti']]; $villagen=$varr[$agrd['vi']];
	 
	}
	else
	{
	 //$staten=''; $distn=''; $tahsiln=''; $villagen='';
	 $staten=$sarr[$agrd['state_id']]; $distn=$darr[$agrd['distric_id']]; 
	 $tahsiln=$tarr[$agrd['tahsil_id']]; $villagen=$varr[$agrd['village_id']];
	}

	 $agyear = date('Y',strtotime($agrd['agree_date']));
	?>

	<tr>
		<td><?=$sno; //if($_SESSION['uId']==134){echo $qry;}?></td>
		<td><?=$agrd['agree_no']; ?></td>
		<td><?=date("d-m-Y",strtotime($agrd['agree_date'])); ?></td>
		<td><?=$cropn;?></td>
		<td><?=$agrd['ann_fscode_f'].' / '.$agrd['ann_fscode_m']?></td>
		<td style="text-align:left;"><?=$agrd['oname']?></td>
		<td style="text-align:left;"><?=$agrd['fname']?></td>
		<td style="text-align:left;"><input type="text" style="border:hidden;width:100%;" value="<?=$agrd['father_name']?>" /></td>
		
		<td><?=$agrd['uName']?></td>
		
		<?php $spe=mysql_query("select uName from users where uId=".$agrd['prod_executive']); $rpe=mysql_fetch_assoc($spe);  ?> 
		<td><?=$rpe['uName']?></td>
		
		<?php /*?><td><?=$agrd['second_party']?></td><?php */?>
		
		<td><input type="text" style="border:hidden;width:100%;" value="<?=$varr[$agrd['village_id']].'-'.$tarr[$agrd['tahsil_id']]?>" /></td>
		<td><input type="text" style="border:hidden;width:100%;" value="<?=$darr[$agrd['distric_id']].'-'.$sarr[$agrd['state_id']]?>" /></td>
		<td><input type="text" style="border:hidden;width:100%;" value="<?=$villagen.' - '.$tahsiln?>" /></td>
		<td><input type="text" style="border:hidden;width:100%;" value="<?=$distn.' - '.$staten?>" /></td>
		<td><?=$agrd['sowing_acres']?></td>
		<td><?=$agrd['GPSMeasure']?></td>
		<td style="width:20px;vertical-align:middle;text-align:center;"><img src="image/edit.png" onclick="editagri('<?=$agrd['agree_id']?>','<?=$agyear?>')" style="width:18px;height:15px;cursor:pointer;"/><!--<button class="btn btn-sm btn-primary frminp"  style="height:20px;">Edit</button>--></td>
	</tr>
	
	
	

	<?php
	$sno++;
	}

	?>
	<tr>
		<td colspan="15">
			<span style="float: left;">
				<?php
				if($agcou!=0){
				?>
				Showing <b><?=$start+1?></b> to <b><?=$sno-1?></b> out of <b><?=$agcou?></b> results
				<?php
				}
				?>
			</span>
			<span style="float: right;padding-right:5px; <?php if($agcou==0){echo 'display:none;';}?> ">
				Pages: 
				<?php
				if($curpage!=1){
				?>
				<button onclick="agreeSearch('<?=$curpage-1?>');">Prev</button>
				<?php
				}
				?>


				<?php
				if($pages>5){
					for($i=1;$i<=3;$i++){
					?>
					<button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
					<?php
					}
					?>
					...
					<?php
					if($curpage>3 && $curpage!=$pages){
						?>
						<button onclick="agreeSearch('<?=$curpage?>');" style="background-color: #0069D9; color:white;"><?=$curpage?></button>
						<?php
					}
					?>
					...
					<button onclick="agreeSearch('<?=$pages?>');" style="<?php if($pages==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$pages?></button>
					<?php
				}else{
					for($i=1;$i<=$pages;$i++){
					?>
					<button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
					<?php
					}
				}
				?>



				<?php
				if($curpage!=$pages){
				?>
				<button onclick="agreeSearch('<?=$curpage+1?>');" >Next</button>
				<?php
				}
				?>


			</span>
			<!-- <?=$agcou.'----'.$pages?> -->
			<?php
			// echo "SELECT agr.*, u.uName, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id FROM `agreement_".$agyear."` agr, users u, farmers f, organiser o where agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond.$limitCond;
			?>
			</td>
	</tr>
	<?php
}elseif(isset($_POST['act']) && $_POST['act']=='get_agr_report_list'){


	$alls=mysql_query('SELECT * FROM `state`');
	while ($allsd=mysql_fetch_assoc($alls)) {
		$sarr[$allsd['StateId']]=$allsd['StateName'];
	}

	$alld=mysql_query('SELECT * FROM `distric`');
	while ($alldd=mysql_fetch_assoc($alld)) {
		$darr[$alldd['DictrictId']]=$alldd['DictrictName'];
	}

	$allt=mysql_query('SELECT * FROM `tahsil`');
	while ($alltd=mysql_fetch_assoc($allt)) {
		$tarr[$alltd['TahsilId']]=$alltd['TahsilName'];
	}

	$allv=mysql_query('SELECT * FROM `village`');
	while ($allvd=mysql_fetch_assoc($allv)){
		$varr[$allvd['VillageId']]=$allvd['VillageName'];
	}

	$from = date('Y-m-d',strtotime($_POST['from']));
	$agyearf = (int)date('Y',strtotime($_POST['from']));

	$to = date('Y-m-d',strtotime($_POST['to']));
	$agyeart = (int)date('Y',strtotime($_POST['to']));


	//==== query condition for crop filter =======================================================
	if(isset($_POST['crop']) && $_POST['crop']!=''){
		$cropCond="agr.ann_crop=".$_POST['crop'];
	}else{
		$cropCond='1=1';
	}

    //==== query condition for production code filter =======================================================
    if(isset($_POST['prodcode']) && $_POST['prodcode']!=''){
	$prodcode="agr.ann_prodcode='".$_POST['prodcode']."'";
    }else{
	$prodcode='1=1';
    }
	
	//==== query condition for organiser filter ==================================================
	if(isset($_POST['orgr']) && $_POST['orgr']!=''){
		$orgrCond="agr.org_id=".$_POST['orgr'];
	}else{
		$orgrCond='1=1';
	}

    //==== query condition for production person filter ==================================================
	if(isset($_POST['pperson']) && $_POST['pperson']!=''){
		$pperson="agr.prod_person=".$_POST['pperson'];
	}else{
		$pperson='1=1';
	}
	
	//==== query condition for production executive filter ==================================================
	if(isset($_POST['pexe']) && $_POST['pexe']!=''){
		$pexecutive="agr.prod_executive=".$_POST['pexe'];
	}else{
		$pexecutive='1=1';
	}


	//==== query condition for organiser filter ==================================================
	if(isset($_POST['secondparty']) && $_POST['secondparty']!=''){
		$farmerCond="agr.second_party=".$_POST['secondparty'];
	}else{
		$farmerCond='1=1';
	}

	//==== query condition for user filter ==================================================
	/*if(isset($_POST['users']) && $_POST['users']!=''){
		$userCond="agr.cr_by=".$_POST['users'];
	}else{
		if($_SESSION['uType']=='U'){
			$userCond="agr.cr_by=".$_SESSION['uId'];
		}else{
			$userCond='1=1';
		}
	}*/

    $userCond='1=1';
	
	//==== query condition for keyword search START==================================================
    
	if(isset($_POST['vii']) && $_POST['vii']!=''){ $keyArea="agr.vi like '%".$_POST['vii']."%'";}
	elseif(isset($_POST['tii']) && $_POST['tii']!=''){ $keyArea="agr.ti like '%".$_POST['tii']."%'";}
	elseif(isset($_POST['dii']) && $_POST['dii']!=''){ $keyArea="agr.di like '%".$_POST['dii']."%'";}
	elseif(isset($_POST['sii']) && $_POST['sii']!=''){ $keyArea="agr.si like '%".$_POST['sii']."%'";}
	else{$keyArea='1=1';}

	if(isset($_POST['keywordSearch']) && $_POST['keywordSearch']!=''){
		$keyCond="(f.fname like '%".$_POST['keywordSearch']."%' or agr.agree_no like '%".$_POST['keywordSearch']."%')";
		//$keyCond="(f.fname like '%".$_POST['keywordSearch']."%' or o.oname like '%".$_POST['keywordSearch']."%' or agr.ann_prodcode like '%".$_POST['keywordSearch']."%' or agr.agree_no like '%".$_POST['keywordSearch']."%' or s.StateName like '%".$_POST['keywordSearch']."%' or d.DictrictName like '%".$_POST['keywordSearch']."%' or t.TahsilName like '%".$_POST['keywordSearch']."%' or v.VillageName like '%".$_POST['keywordSearch']."%')";
		
	}else{
		$keyCond='1=1';
	}


	//==== query condition for keyword search END==================================================

	


	
	//==== query condition for getting results as per users hierarchy ================= start =====================

	//$allids = array_unique(gethierarchy($_SESSION['uId']));
	//$hierarchyCond = "agr.cr_by IN (".implode(', ', $allids).")";
	
if(isset($_POST['users']) && $_POST['users']!='')
{	
 function get2hierarchy($uid)
 {
  $id=array($uid);
  $sel=mysql_query("select uId from users where uReporting='".$uid."'");
  if(mysql_num_rows($sel) > 0)
  {
	while($seld = mysql_fetch_assoc($sel))
	{
	 $idc = array($seld['uId']);
	 $id = array_merge($id,$idc,get2hierarchy($seld['uId']));
	}
  }
  return $id;	
 }

 $allids = array_unique(get2hierarchy($_POST['users'])); //$_SESSION['uId']
 $hierarchyCond = "(agr.prod_person IN (".implode(', ', $allids).") or agr.prod_executive IN (".implode(', ', $allids)."))";	
	
}
else { $hierarchyCond='1=1'; }		

	//==== query condition for getting results as per users hierarchy ================= end =======================

	
	//==== this query is for only counting number of results for setting limits on actual query ================================
	
	$qry="";
	for ($i=$agyearf; $i <= $agyeart; $i++) {
		
		$qry.=" SELECT agr.*, u.uName, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id FROM `agreement_".$i."` agr, users u, farmers f, organiser o,village v, tahsil t, distric d, state s where f.village_id=v.VillageId and f.tahsil_id=t.TahsilId and f.distric_id=d.DictrictId and f.state_id=s.StateId and agr.agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond." and ".$farmerCond." and ".$hierarchyCond." and ".$userCond." and ".$prodcode." and ".$pperson." and ".$keyArea." and ".$pexecutive." and ".$keyCond;
		if($i!=$agyeart){
			$qry.=' UNION';
		}

		// echo $i.'<br>';
	}

	//echo $qry;
	// echo '<BR><BR><BR><BR>';
	// exit;
	$agra=mysql_query($qry);
	$agcou=mysql_num_rows($agra);
	if($agcou>20){
		$pages=ceil($agcou/20);
	}else{
		$pages=1;
	}

	//==== query condition for setting number of pages as per number of results ==================================================
	if(isset($_POST['page']) && $_POST['page']!=''){
		$start=((int)$_POST['page']-1)*20;
		$limitCond=" LIMIT ".$start.", 20";
		$curpage=$_POST['page'];
		$sno=$start+1;
	}else{
		$limitCond=" LIMIT 20";
		$curpage=1;
		$sno=1;
	}

    echo '<input type="hidden" id="countval" value='.$agcou.' />';
	if($agcou==0){
	?>
	<tr>
		<td colspan="15">No results found as per your applied filters</td>
	</tr>
	<?php
	}


	//===== actual query with limits which returning limiited number of results as per page number =============================
	$agr=mysql_query($qry.$limitCond);
	while ($agrd=mysql_fetch_assoc($agr)) 
	{
	
	
	if($agrd['ann_crop']>0)
	{ $cr=mysql_fetch_assoc(mysql_query("select cropname,cropcode from crop where cropid=".$agrd['ann_crop'])); 
	  $cropn=$cr['cropcode']; }else{ $cropn=''; }
	if($agrd['ann7_flandid']>0)
	{
	 /*
	 $fld=mysql_query('SELECT StateId as st,DictrictId as dt,TahsilId as tt,VillageId vt FROM farmers_land where flandid='.$agrd['ann7_flandid']); $rld=mysql_fetch_assoc($fld);
     if($rld['st']>0){ $sr=mysql_fetch_assoc(mysql_query("select StateName from state where StateId=".$rld['st'])); 
	 $staten=$sr['StateName']; }else{ $staten=$sarr[$agrd['state_id']]; }
     if($rld['dt']>0){ $dr=mysql_fetch_assoc(mysql_query("select DictrictName from distric where DictrictId=".$rld['dt'])); 
	 $distn=$dr['DictrictName']; }else{ $distn=$darr[$agrd['distric_id']]; }
     if($rld['tt']>0){ $tr=mysql_fetch_assoc(mysql_query("select TahsilName from tahsil where TahsilId=".$rld['tt']));
	 $tahsiln=$tr['TahsilName']; }else{ $tahsiln=$tarr[$agrd['tahsil_id']]; }
     if($rld['vt']>0){ $vr=mysql_fetch_assoc(mysql_query("select VillageName from village where VillageId=".$rld['vt']));
	 $villagen=$vr['VillageName']; }else{ $villagen=$varr[$agrd['village_id']]; } */
	 
	 $staten=$sarr[$agrd['si']]; $distn=$darr[$agrd['di']]; 
	 $tahsiln=$tarr[$agrd['ti']]; $villagen=$varr[$agrd['vi']];
	 
	}
	else
	{
	 //$staten=''; $distn=''; $tahsiln=''; $villagen='';
	 $staten=$sarr[$agrd['state_id']]; $distn=$darr[$agrd['distric_id']]; 
	 $tahsiln=$tarr[$agrd['tahsil_id']]; $villagen=$varr[$agrd['village_id']];
	}

	 $agyear = date('Y',strtotime($agrd['agree_date']));
	?>

	<tr>
		<td><?=$sno?></td>
		
		<td>
		<?php if($_SESSION['uId']==1 OR $_SESSION['uId']==14 OR $_SESSION['uId']==134 OR $_SESSION['uId']==17 OR $_SESSION['uId']==20){?>
		<span onClick="OpenDetails(<?php echo $agrd['agree_id'];?>,'<?php echo $agrd['agree_no']; ?>','<?php echo $agrd['ann_crop']; ?>')" style="text-decoration:underline;color:#158AFF;cursor:pointer;"><?=$agrd['agree_no']; ?></span>
		<?php }else{ echo $agrd['agree_no']; } ?>
		</td>
		
		
		<td><?=date("d-m-Y",strtotime($agrd['agree_date'])); ?></td>
		<td><?=$cropn;?></td>
		<td><?=$agrd['ann_prodcode'];?></td>
		<td><?=$agrd['ann_fscode_f'].' / '.$agrd['ann_fscode_m']?></td>
		<td style="text-align:left;"><?=$agrd['oname']?></td>
		<td style="text-align:left;"><?=$agrd['fname']?></td>
		<td style="text-align:left;"><?=$agrd['father_name']?></td>
		
		<?php /*?><td><?=$agrd['uName']?></td><?php */?>
		<?php /*?><td><?=$agrd['second_party']?></td><?php */?>

<?php $sqPP=mysql_query("select uName from users where uId=".$agrd['prod_person']); $rqPP=mysql_fetch_assoc($sqPP); 
$sqPE=mysql_query("select uName from users where uId=".$agrd['prod_executive']); $rqPE=mysql_fetch_assoc($sqPE);
?>
		
		<td><?=$rqPP['uName'];?></td>
		<td><?=$rqPE['uName'];?></td>
		
		<td><?=$villagen.' - '.$tahsiln?></td>
		<td><?=$distn.' - '.$staten?></td>
		<!--<td><?=$agrd['sowing_acres']?></td>-->
		
		<?php /*?> <td><?=$agrd['GPSMeasure']?></td> <?php */?>
		
		<?php if($agrd['GPSMeasure']>0 && $agrd['PPI_PLDAcr']!='' && $agrd['PPI_PLDAcr']>0)
		      { $finalGPSMeas=$agrd['GPSMeasure']-$agrd['PPI_PLDAcr']; }
		      else{ $finalGPSMeas=$agrd['GPSMeasure']; } ?>
		
		<!--<td><?=$finalGPSMeas?></td>-->
		
	</tr>
	
	
	

	<?php
	$sno++;
	}

	?>
	<tr>
		<td colspan="15">
			<span style="float: left;">
				<?php
				if($agcou!=0){
				?>
				Showing <b><?=$start+1?></b> to <b><?=$sno-1?></b> out of <b><?=$agcou?></b> results
				<?php
				}
				?>
			</span>
			<span style="float: right;padding-right:5px; <?php if($agcou==0){echo 'display:none;';}?> ">
				Pages: 
				<?php
				if($curpage!=1){
				?>
				<button onclick="agreeSearch('<?=$curpage-1?>');">Prev</button>
				<?php
				}
				?>


				<?php
				if($pages>5){
					for($i=1;$i<=3;$i++){
					?>
					<button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
					<?php
					}
					?>
					...
					<?php
					if($curpage>3 && $curpage!=$pages){
						?>
						<button onclick="agreeSearch('<?=$curpage?>');" style="background-color: #0069D9; color:white;"><?=$curpage?></button>
						<?php
					}
					?>
					...
					<button onclick="agreeSearch('<?=$pages?>');" style="<?php if($pages==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$pages?></button>
					<?php
				}else{
					for($i=1;$i<=$pages;$i++){
					?>
					<button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
					<?php
					}
				}
				?>



				<?php
				if($curpage!=$pages){
				?>
				<button onclick="agreeSearch('<?=$curpage+1?>');" >Next</button>
				<?php
				}
				?>


			</span>
			<!-- <?=$agcou.'----'.$pages?> -->
			<?php
			// echo "SELECT agr.*, u.uName, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id FROM `agreement_".$agyear."` agr, users u, farmers f, organiser o where agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond.$limitCond;
			?>
			</td>
	</tr>
	<?php
}
?>	