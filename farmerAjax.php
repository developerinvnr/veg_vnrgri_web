<?php
session_start();
include 'config.php';

if(isset($_POST['act']) && $_POST['act']=='get_farmer_report_list')
{

	if(isset($_POST['orgr']) && $_POST['orgr']!=''){
		$orgrCond="f.oid=".$_POST['orgr'];
	}else{
		$orgrCond='1=1';
	}
    
	if(isset($_POST['vii']) && $_POST['vii']!=''){ $keyArea="f.village_id like '%".$_POST['vii']."%'";}
	elseif(isset($_POST['tii']) && $_POST['tii']!=''){ $keyArea="f.tahsil_id like '%".$_POST['tii']."%'";}
	elseif(isset($_POST['dii']) && $_POST['dii']!=''){ $keyArea="f.distric_id like '%".$_POST['dii']."%'";}
	elseif(isset($_POST['sii']) && $_POST['sii']!=''){ $keyArea="f.state_id like '%".$_POST['sii']."%'";}
	else{$keyArea='1=1';}
		
		$qry.=" SELECT f.*, o.oname, v.VillageName, t.TahsilName, d.DictrictName, s.StateName FROM farmers f, organiser o,village v, tahsil t, distric d, state s where f.village_id=v.VillageId and f.tahsil_id=t.TahsilId and f.distric_id=d.DictrictId and f.state_id=s.StateId and f.oid=o.oid and ".$orgrCond." and ".$keyArea." ";
		
	
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
	$agr=mysql_query($qry.$limitCond);
	while ($agrd=mysql_fetch_assoc($agr)) 
	{
	  $str = chunk_split($agrd['tem_fid'], 4, ' ');
	?>

	<tr>
		<td><?=$sno?></td>
		<td><input type="text" style="border:hidden;width:98%;" value="<?=$str; ?>" /></td>
		<td><input type="text" style="border:hidden;width:98%;" value="<?=ucfirst(strtolower($agrd['fname'])); ?>" /></td>
		<td><?=$agrd['contact_1'];?></td>
		<td><input type="text" style="border:hidden;width:98%;" value="<?=ucfirst(strtolower($agrd['father_name']));?>" /></td>
		<td><input type="text" style="border:hidden;width:98%;" value="<?=ucfirst(strtolower($agrd['oname']));?>" /></td>
 <td><input type="text" style="border:hidden;width:98%;" value="<?=ucfirst(strtolower($agrd['VillageName']));?>" /></td>
 <td><input type="text" style="border:hidden;width:98%;" value="<?=ucfirst(strtolower($agrd['StateName']));?>" /></td>
 <td><input type="text" style="border:hidden;width:98%;" value="<?=ucfirst(strtolower($agrd['DictrictName']));?>" /></td>
 <td><input type="text" style="border:hidden;width:98%;" value="<?=ucfirst(strtolower($agrd['StateName']));?>" /></td>
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
			
			</td>
	</tr>
	<?php
}
?>	
