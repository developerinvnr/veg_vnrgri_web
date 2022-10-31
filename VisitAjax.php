<?php

session_start();

include 'config.php';





if(isset($_POST['action']) && $_POST['ci']!='' && $_POST['action']=='get_hy')

{

 echo '<option value="">Select</option>';

 $sphy=mysql_query("select VHyb_code from visit_details where VCrop=".$_POST['ci']." group by VHyb_code order by VHyb_code"); while($rphy=mysql_fetch_assoc($sphy)){ echo '<option value='.$rphy['VHyb_code'].'>'.$rphy['VHyb_code'].'</option>'; }

}



if(isset($_POST['action']) && $_POST['si']!='' && $_POST['action']=='get_vi')

{

 echo '<option value="">Select</option>';

 $spv=mysql_query("select VVillage from visit_details where VState='".$_POST['si']."' group by VVillage order by VVillage"); while($rpv=mysql_fetch_assoc($spv)){ echo '<option value='.$rpv['VVillage'].'>'.ucwords(strtolower($rpv['VVillage'])).'</option>'; }

}



if(isset($_POST['act']) && $_POST['act']=='get_visit_report_list')

{

   if(isset($_POST['crop']) && $_POST['crop']>0){$crop="v.VCrop=".$_POST['crop'];}else{$crop='1=1';}

   if(isset($_POST['hy']) && $_POST['hy']!=''){$hy="v.VHyb_code='".$_POST['hy']."'";}else{$hy='1=1';}

   if(isset($_POST['sii']) && $_POST['sii']!=''){$state="v.VState='".$_POST['sii']."'";}else{$state='1=1';}

   if(isset($_POST['vii']) && $_POST['vii']!=''){$village="v.VVillage='".$_POST['vii']."'";}else{$village='1=1';}

   if(isset($_POST['ui']) && $_POST['ui']>0){$userId="v.VUserId='".$_POST['ui']."'";}else{$userId='1=1';}

   

   //echo "SELECT v.*,cropname,uName FROM visit_details v inner join crop c on v.VCrop=c.cropid inner join users u on v.VUserId=u.uId where VDate between '".date("Y-m-d",strtotime($_POST['from']))."' AND '".date("Y-m-d",strtotime($_POST['to']))."' AND ".$crop." AND ".$hy." AND ".$state." AND ".$village." AND ".$userId."";

   

   $qry="SELECT v.*,uName FROM visit_details v inner join users u on v.VUserId=u.uId where VDate between '".date("Y-m-d",strtotime($_POST['from']))."' AND '".date("Y-m-d",strtotime($_POST['to']))."' AND ".$hy." AND ".$state." AND ".$village." AND ".$userId.""; $sgcuu=mysql_query($qry); $agcou=mysql_num_rows($sgcuu);

   

   if($agcou>20){ $pages=ceil($agcou/20); }else{ $pages=1; }

   

   if(isset($_POST['page']) && $_POST['page']!='')

   {

	 $start=((int)$_POST['page']-1)*20;

	 $limitCond=" LIMIT ".$start.", 20";

	 $curpage=$_POST['page'];

	 $sno=$start+1;

   }

   else{ $limitCond=" LIMIT 20"; $curpage=1; $sno=1; }

   

   echo '<input type="hidden" id="countval" value='.$agcou.' />';

   if($agcou==0){?><tr><td colspan="10">No results found as per your applied filters</td></tr><?php }

   

   $agr=mysql_query($qry.$limitCond);

	while($agrd=mysql_fetch_assoc($agr)) 

	{

	  $str = chunk_split($agrd['tem_fid'], 4, ' ');

	?>

	<tr>

	 <td><?=$sno?></td>

	 <td><input type="text" style="border:hidden;width:98%;" value="<?=date("d-m-Y",strtotime($agrd['VDate'])).' '.$agrd['VTime']; ?>" /></td>

	 <td><input type="text" style="border:hidden;width:98%;" value="<?=ucwords(strtolower($agrd['uName']));?>" /></td>

	 <td><input type="text" style="border:hidden;width:98%;" value="<?=$agrd['cropname'];?>" /></td>

	 <td><input type="text" style="border:hidden;width:98%;" value="<?=$agrd['VHyb_code'];?>" /></td>

	 <td><input type="text" style="border:hidden;width:98%;" value="<?=ucwords(strtolower($agrd['VState']));?>" /></td>

     <td><input type="text" style="border:hidden;width:98%;" value="<?=ucwords(strtolower($agrd['VVillage']));?>" /></td>

     <td><input type="text" style="border:hidden;width:98%;" value="<?=$agrd['VTot_acrg'];?>" /></td>

     <td><input type="text" style="border:hidden;width:98%;" value="<?=ucwords(strtolower($agrd['VGPS_loc']));?>" /></td>

	 <td><input type="text" style="border:hidden;width:98%;" value="<?=$agrd['Remark'];?>" /></td>

     

	</tr>

   <?php $sno++; } ?>

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

			

			</td>

	</tr>

	<?php

}







if(isset($_REQUEST['action']) && $_REQUEST['action']=='exportvisit')

{



 $xls_filename = 'Field_Visited_Report'.$_REQUEST['from'].'_'.$_REQUEST['from'].'.xls'; 

 header("Content-Type: application/csv");

 header("Content-Disposition: attachment; filename=$xls_filename");

 header("Pragma: no-cache");

 header("Expires: 0");

 $sep = "\t"; 

 echo "Sn\tDate-Time\tUser\tCropName\tHybridCode\tState\tVillage\tAcreage\tLocation\tRemark";

 print("\n");



 if(isset($_REQUEST['crop']) && $_REQUEST['crop']>0){$crop="v.VCrop=".$_REQUEST['crop'];}else{$crop='1=1';}

 if(isset($_REQUEST['hy']) && $_REQUEST['hy']!=''){$hy="v.VHyb_code='".$_REQUEST['hy']."'";}else{$hy='1=1';}

 if(isset($_REQUEST['sii']) && $_REQUEST['sii']!=''){$state="v.VState='".$_REQUEST['sii']."'";}else{$state='1=1';}

 if(isset($_REQUEST['vii']) && $_REQUEST['vii']!=''){$village="v.VVillage='".$_REQUEST['vii']."'";}else{$village='1=1';} 

 if(isset($_REQUEST['ui']) && $_REQUEST['ui']>0){$userId="v.VUserId='".$_REQUEST['ui']."'";}else{$userId='1=1';}  


 $qry=mysql_query("SELECT v.*,cropname,uName FROM visit_details v inner join crop c on v.VCrop=c.cropid inner join users u on v.VUserId=u.uId where VDate between '".date("Y-m-d",strtotime($_REQUEST['from']))."' AND '".date("Y-m-d",strtotime($_REQUEST['to']))."' AND ".$crop." AND ".$hy." AND ".$state." AND ".$village." AND ".$userId.""); 



  $sn=1;

  while($agrd=mysql_fetch_assoc($qry)) 

  {

	

   echo $sn.$sep;

   echo date("d-m-Y",strtotime($agrd['VDate'])).' '.$agrd['VTime'].$sep;

   echo ucwords(strtolower($agrd['uName'])).$sep;

   echo $agrd['cropname'].$sep;

   echo $agrd['VHyb_code'].$sep;

   echo ucwords(strtolower($agrd['VState'])).$sep;

   echo ucwords(strtolower($agrd['VVillage'])).$sep;

   echo $agrd['VTot_acrg'].$sep;

   echo ucwords(strtolower($agrd['VGPS_loc'])).$sep;

   echo ucwords(strtolower($agrd['Remark'])).$sep;

  

   print("\n");

   $sn++;

 }





}









?>







