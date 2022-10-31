<?php
session_start();
include 'config.php'; 

function gethierarchy($uid)
{
 $id=array($uid);
	
 if($_SESSION['uType']=='S')
 {
  $sel=mysql_query("select uId from users");
  while($seld = mysql_fetch_assoc($sel)){ $idc = array($seld['uId']); $id = array_merge($id,$idc); }
 }
 else
 { 
   $sel=mysql_query("select uId from users where uReporting='".$uid."'");
   if(mysql_num_rows($sel) > 0)
   {
    while($seld = mysql_fetch_assoc($sel))
    {
     $idc = array($seld['uId']);
     $id = array_merge($id,$idc,gethierarchy($seld['uId']));
    }
   }
  }
  return $id;	
}
?>

<?php
if(isset($_POST['act']) && $_POST['act']=='get_agr_report_Arrlist')
{
  ?>
  <table class=" estable table table-bordered" style="width:100%;">
  <thead >
	<tr>
		<th rowspan="2" style="width:30px;">Sn</th>
		<th rowspan="2" style="width:80px;">Agreement<br />ID</th>
		<th rowspan="2" style="width:50px;">Crop</th>
		<th rowspan="2" style="width:30px;">Hybrid<br />Code</th>
		<th rowspan="2" style="width:120px;">Farmer Name</th>
		<!--<th rowspan="2" style="width:100px;">Organiser<br />Name</th>-->
		<th colspan="6">Dispatch</th>
		<th colspan="3">Arrival</th>
		<th rowspan="2" style="width:40px;">Action</th>
	</tr>
	<tr>	
		<th style="width:50px;">LotNo</th>
		<th style="width:60px;">Date</th>
		<th style="width:80px;">Driver <br />No</th>
		<th style="width:80px;">Lorry <br />No</th>
		<th style="width:40px;">No.Of<br>Bag</th>
		<th style="width:60px;">Qty <br />(in Kq)</th>
		<th style="width:80px;">Date</th>
		<th style="width:50px;">Qty <br />(in Kq)</th>
		<th style="width:100px;">Remark</th>
			
	</tr> 
</thead>
  <tbody>
  
  <?php
  if(isset($_POST['vii']) && $_POST['vii']!=''){ $keyArea="agr.vi like '%".$_POST['vii']."%'";}
  elseif(isset($_POST['tii']) && $_POST['tii']!=''){ $keyArea="agr.ti like '%".$_POST['tii']."%'";}
  elseif(isset($_POST['dii']) && $_POST['dii']!=''){ $keyArea="agr.di like '%".$_POST['dii']."%'";}
  elseif(isset($_POST['sii']) && $_POST['sii']!=''){ $keyArea="agr.si like '%".$_POST['sii']."%'";}
  else{$keyArea='1=1';}
  
  $from = date('Y-m-d',strtotime($_POST['from'])); $agyearf = (int)date('Y',strtotime($_POST['from']));
  $to = date('Y-m-d',strtotime($_POST['to'])); $agyeart = (int)date('Y',strtotime($_POST['to']));
  
  if(isset($_POST['crop']) && $_POST['crop']!=''){ $cropCond="agr.ann_crop=".$_POST['crop']; }
  else{ $cropCond='1=1'; } 

  if(isset($_POST['prodcode']) && $_POST['prodcode']!=''){ $prodcode="agr.ann_prodcode='".$_POST['prodcode']."'"; }
  else{ $prodcode='1=1'; }
  
  if(isset($_POST['orgr']) && $_POST['orgr']!=''){ $orgrCond="agr.org_id=".$_POST['orgr']; }
  else{ $orgrCond='1=1'; }
  
  if(isset($_POST['driv']) && $_POST['driv']!=''){ $driv="l.driver_no='".$_POST['driv']."'"; }
  else{ $driv='1=1'; }

  if(isset($_POST['pperson']) && $_POST['pperson']!=''){ $pperson="agr.prod_person=".$_POST['pperson']; }
  else{ $pperson='1=1'; }
	
  if(isset($_POST['pexe']) && $_POST['pexe']!=''){ $pexecutive="agr.prod_executive=".$_POST['pexe']; }
  else{ $pexecutive='1=1'; }
  
  /***************** user Check *********************/
  if(isset($_POST['users']) && $_POST['users']!='' && $_POST['users']>0)
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
  
  
  /****************** Query ******************************/
  /****************** Query ******************************/
  $qry=""; $datey=$agyeart;  //$agyeart
  
  for($i=2019; $i<=$datey; $i++) //$agyearf
  {
	$qry.=" SELECT l.*, ann_prodcode, cropname, cropcode, f.fname, o.oname FROM agreementlot_".$i." l inner join agreement_".$i." agr on l.agree_no=agr.agree_no inner join crop c on agr.ann_crop=c.cropid inner join farmers f on agr.second_party=f.fid inner join organiser o on agr.org_id=o.oid where l.dispatch_date between '".$from."' and '".$to."' and ".$keyArea." and ".$cropCond." and ".$prodcode." and ".$orgrCond." and ".$driv." and ".$pperson." and ".$pexecutive." and ".$hierarchyCond;

	if($i!=$datey){ $qry.=' UNION'; }

  }
   
  $agra=mysql_query($qry);
  $agcou=mysql_num_rows($agra);
  if($agcou>20){ $pages=ceil($agcou/20); }else{ $pages=1; }
  /****************** Query ******************************/
  /****************** Query ******************************/
  
  if(isset($_POST['page']) && $_POST['page']!='')
  {
   $start=((int)$_POST['page']-1)*20; $limitCond=" LIMIT ".$start.", 20"; $curpage=$_POST['page']; $sno=$start+1;
  }
  else{ $limitCond=" LIMIT 20"; $curpage=1; $sno=1; }
  
  echo '<input type="hidden" id="countval" value='.$agcou.' />';
  if($agcou==0){ ?><tr><td colspan="15">No results found as per your applied filters</td></tr><?php } 
  
  $agr=mysql_query($qry.$limitCond);
  //echo $qry.$limitCond;
  while ($agrd=mysql_fetch_assoc($agr)){ ?>
	<tr style="height:24px;" id="TR<?=$sno?>">
		<td><?=$sno?></td>
		<td><?=$agrd['agree_no']; ?></td>
		<td><input type="text" style="border:hidden;width:99%;" value="<?=$agrd['cropcode'];?>" /></td>
		<td><?=$agrd['ann_prodcode'];?></td>
		<td><input type="text" style="border:hidden;width:99%;" value="<?=$agrd['fname']?>" /></td>
		<?php /*?><td><input type="text" style="border:hidden;width:99%;" value="<?=$agrd['oname']?>" /></td><?php */?>
		<td><?=$agrd['lot_no']?></td>
		<td><?=date("d-m-Y",strtotime($agrd['dispatch_date']))?></td>
		<td><?=$agrd['driver_no']?></td>
		<td><?=$agrd['lorry_no']?></td>
		<td><?=$agrd['noofbag']?></td>
		<td><?=$agrd['qty']?></td>
		
		<td><input style="width:99%;text-align:center;background-color:#FFFF9D;" id="arrDt<?=$sno?>" value="<?php if($agrd['arrival_date']!='1970-01-01' && $agrd['arrival_date']!='0000-00-00' && $agrd['arrival_date']!=''){echo date("d-m-Y",strtotime($agrd['arrival_date'])); }?>" readonly/></td>
        <?php /**/?><script>$('#arrDt<?=$sno?>').datepicker({format:'dd-mm-yyyy',});</script><?php /**/?>
		
		
		<td><input style="width:99%;text-align:center;background-color:#FFFF9D;" id="arrQty<?=$sno?>" value="<?=$agrd['arrival_qty']?>" onKeyPress="return isNumberKey(event)" readonly/></td>
		<td><input style="width:99%;text-align:left;background-color:#FFFF9D;" id="arrRmk<?=$sno?>" value="<?=$agrd['arrival_rmk']?>" readonly/></td>
		<td style="text-align:center;">
		 <span style="cursor:pointer;">
		 <img src="image/edit.png" id="Edit<?=$sno?>" style="width:16px;height:16px;" onclick="FunEdit(<?=$sno?>)" />
		 <img src="image/save.gif" id="Save<?=$sno?>" style="width:16px;height:16px; display:none;" onclick="FunSave(<?=$sno?>,<?=$agrd['agri_lotId']?>,'<?=$agrd['agree_no']?>')" />  </span>
		 
		</td>
	</tr>
  <?php $sno++; } //while ?>
  
    <tr>
	  <td colspan="15">
	  <span style="float:left;">
	  <?php if($agcou!=0){ ?>Showing <b><?=$start+1?></b> to <b><?=$sno-1?></b> out of <b><?=$agcou?></b> results<?php } ?>
	  </span>
	  
      <span style="float: right;padding-right:5px; <?php if($agcou==0){echo 'display:none;';}?> ">
	  Pages: <?php if($curpage!=1){ ?><button onclick="agreeSearch('<?=$curpage-1?>');">Prev</button><?php } ?>

	  <?php if($pages>5)
	        {
	         for($i=1;$i<=3;$i++)
			 { ?>      
	         <button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
	  <?php  } ?>
      ...
      <?php  if($curpage>3 && $curpage!=$pages)
	         { ?>
			 <button onclick="agreeSearch('<?=$curpage?>');" style="background-color: #0069D9; color:white;"><?=$curpage?></button>
	  <?php  } ?>
	  ...
			 <button onclick="agreeSearch('<?=$pages?>');" style="<?php if($pages==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$pages?></button>
	  
	  <?php } //if($pages>5)
	        else
			{
			 for($i=1;$i<=$pages;$i++)
			 { ?>
			 <button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
	  <?php  }
		    } ?>

	   <?php if($curpage!=$pages){ ?>
	     <button onclick="agreeSearch('<?=$curpage+1?>');" >Next</button>
       <?php } ?>

      </span>
	  </td>
    </tr>
	
	</tbody>
    </table>
	<?php  
}


if(isset($_POST['act']) && $_POST['act']=='savearrival')
{
 $yer=substr($_POST['agid'], 0, 4); 
 $up=mysql_query("update agreementlot_".$yer." set arrival_date='".date("Y-m-d",strtotime($_POST['Dt']))."', arrival_qty='".$_POST['Qty']."', arrival_rmk='".$_POST['Rmk']."', arrival_upby=".$_SESSION['uId']." where agri_lotId=".$_POST['id']." and agree_no='".$_POST['agid']."'");
 if($up){echo 'updated';}else{echo 'error';}
}

?>

<?php
if(isset($_POST['act']) && $_POST['act']=='get_agr_report_ArrRpt')
{
  ?>
  <table class=" estable table table-bordered" style="width:100%;">
  <thead >
	<tr>
		<th rowspan="2" style="width:30px;">Sn</th>
		<th rowspan="2" style="width:80px;">Agreement<br />ID</th>
		<th rowspan="2" style="width:50px;">Crop</th>
		<th rowspan="2" style="width:30px;">Hybrid<br />Code</th>
		<th rowspan="2" style="width:120px;">Farmer Name</th>
		<!--<th rowspan="2" style="width:100px;">Organiser<br />Name</th>-->
		<th colspan="6">Dispatch</th>
		<th colspan="3">Arrival</th>
	</tr>
	<tr>	
		<th style="width:50px;">LotNo</th>
		<th style="width:60px;">Date</th>
		<th style="width:80px;">Driver <br />No</th>
		<th style="width:80px;">Lorry <br />No</th>
		<th style="width:40px;">No.Of<br>Bag</th>
		<th style="width:60px;">Qty <br />(in Kq)</th>
		<th style="width:80px;">Date</th>
		<th style="width:50px;">Qty <br />(in Kq)</th>
		<th style="width:100px;">Remark</th>
			
	</tr> 
</thead>
  <tbody>
  
  <?php
  if(isset($_POST['vii']) && $_POST['vii']!=''){ $keyArea="agr.vi like '%".$_POST['vii']."%'";}
  elseif(isset($_POST['tii']) && $_POST['tii']!=''){ $keyArea="agr.ti like '%".$_POST['tii']."%'";}
  elseif(isset($_POST['dii']) && $_POST['dii']!=''){ $keyArea="agr.di like '%".$_POST['dii']."%'";}
  elseif(isset($_POST['sii']) && $_POST['sii']!=''){ $keyArea="agr.si like '%".$_POST['sii']."%'";}
  else{$keyArea='1=1';}
  
  $from = date('Y-m-d',strtotime($_POST['from'])); $agyearf = (int)date('Y',strtotime($_POST['from']));
  $to = date('Y-m-d',strtotime($_POST['to'])); $agyeart = (int)date('Y',strtotime($_POST['to']));
  
  if(isset($_POST['crop']) && $_POST['crop']!=''){ $cropCond="agr.ann_crop=".$_POST['crop']; }
  else{ $cropCond='1=1'; } 

  if(isset($_POST['prodcode']) && $_POST['prodcode']!=''){ $prodcode="agr.ann_prodcode='".$_POST['prodcode']."'"; }
  else{ $prodcode='1=1'; }
  
  if(isset($_POST['orgr']) && $_POST['orgr']!=''){ $orgrCond="agr.org_id=".$_POST['orgr']; }
  else{ $orgrCond='1=1'; }
  
  if(isset($_POST['driv']) && $_POST['driv']!=''){ $driv="l.driver_no='".$_POST['driv']."'"; }
  else{ $driv='1=1'; }

  if(isset($_POST['pperson']) && $_POST['pperson']!=''){ $pperson="agr.prod_person=".$_POST['pperson']; }
  else{ $pperson='1=1'; }
	
  if(isset($_POST['pexe']) && $_POST['pexe']!=''){ $pexecutive="agr.prod_executive=".$_POST['pexe']; }
  else{ $pexecutive='1=1'; }
  
  /***************** user Check *********************/
  if(isset($_POST['users']) && $_POST['users']!='' && $_POST['users']>0)
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
  
  
  /****************** Query ******************************/
  /****************** Query ******************************/
  $qry=""; $datey=$agyeart;  //$agyeart
  
  for($i=2019; $i<=$datey; $i++) //$agyearf
  {
	$qry.=" SELECT l.*, ann_prodcode, cropname, cropcode, f.fname, o.oname FROM agreementlot_".$i." l inner join agreement_".$i." agr on l.agree_no=agr.agree_no inner join crop c on agr.ann_crop=c.cropid inner join farmers f on agr.second_party=f.fid inner join organiser o on agr.org_id=o.oid where l.dispatch_date between '".$from."' and '".$to."' and ".$keyArea." and ".$cropCond." and ".$prodcode." and ".$orgrCond." and ".$driv." and ".$pperson." and ".$pexecutive." and ".$hierarchyCond;

	if($i!=$datey){ $qry.=' UNION'; }

  }
   
  $agra=mysql_query($qry);
  $agcou=mysql_num_rows($agra);
  if($agcou>20){ $pages=ceil($agcou/20); }else{ $pages=1; }
  /****************** Query ******************************/
  /****************** Query ******************************/
  
  if(isset($_POST['page']) && $_POST['page']!='')
  {
   $start=((int)$_POST['page']-1)*20; $limitCond=" LIMIT ".$start.", 20"; $curpage=$_POST['page']; $sno=$start+1;
  }
  else{ $limitCond=" LIMIT 20"; $curpage=1; $sno=1; }
  
  echo '<input type="hidden" id="countval" value='.$agcou.' />';
  if($agcou==0){ ?><tr><td colspan="15">No results found as per your applied filters</td></tr><?php } 
  
  $agr=mysql_query($qry.$limitCond);
  //echo $qry.$limitCond;
  while ($agrd=mysql_fetch_assoc($agr)){ ?>
	<tr style="height:24px;" id="TR<?=$sno?>">
		<td><?=$sno?></td>
		<td><?=$agrd['agree_no']; ?></td>
		<td><input type="text" style="border:hidden;width:99%;" value="<?=$agrd['cropcode'];?>" /></td>
		<td><?=$agrd['ann_prodcode'];?></td>
		<td><input type="text" style="border:hidden;width:99%;" value="<?=$agrd['fname']?>" /></td>
		<?php /*?><td><input type="text" style="border:hidden;width:99%;" value="<?=$agrd['oname']?>" /></td><?php */?>
		<td><?=$agrd['lot_no']?></td>
		<td><?=date("d-m-Y",strtotime($agrd['dispatch_date']))?></td>
		<td><?=$agrd['driver_no']?></td>
		<td><?=$agrd['lorry_no']?></td>
		<td><?=$agrd['noofbag']?></td>
		<td><?=$agrd['qty']?></td>
		
		<td><?php if($agrd['arrival_date']!='1970-01-01' && $agrd['arrival_date']!='0000-00-00' && $agrd['arrival_date']!=''){echo date("d-m-Y",strtotime($agrd['arrival_date'])); }?></td>
		
		<td><?=$agrd['arrival_qty']?></td>
		<td style="text-align:left;"><?=$agrd['arrival_rmk']?></td>
	</tr>
  <?php $sno++; } //while ?>
  
    <tr>
	  <td colspan="15">
	  <span style="float:left;">
	  <?php if($agcou!=0){ ?>Showing <b><?=$start+1?></b> to <b><?=$sno-1?></b> out of <b><?=$agcou?></b> results<?php } ?>
	  </span>
	  
      <span style="float: right;padding-right:5px; <?php if($agcou==0){echo 'display:none;';}?> ">
	  Pages: <?php if($curpage!=1){ ?><button onclick="agreeSearch('<?=$curpage-1?>');">Prev</button><?php } ?>

	  <?php if($pages>5)
	        {
	         for($i=1;$i<=3;$i++)
			 { ?>      
	         <button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
	  <?php  } ?>
      ...
      <?php  if($curpage>3 && $curpage!=$pages)
	         { ?>
			 <button onclick="agreeSearch('<?=$curpage?>');" style="background-color: #0069D9; color:white;"><?=$curpage?></button>
	  <?php  } ?>
	  ...
			 <button onclick="agreeSearch('<?=$pages?>');" style="<?php if($pages==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$pages?></button>
	  
	  <?php } //if($pages>5)
	        else
			{
			 for($i=1;$i<=$pages;$i++)
			 { ?>
			 <button onclick="agreeSearch('<?=$i?>');" style="<?php if($i==$curpage){echo 'background-color: #0069D9; color:white;';}?>"><?=$i?></button>
	  <?php  }
		    } ?>

	   <?php if($curpage!=$pages){ ?>
	     <button onclick="agreeSearch('<?=$curpage+1?>');" >Next</button>
       <?php } ?>

      </span>
	  </td>
    </tr>
	
	</tbody>
    </table>
	<?php  
}
?>	

