<?php
session_start();
include "config.php";
date_default_timezone_set('Asia/Calcutta');
?>
<style> printLink{display : none;} .pagebreak { clear:both; page-break-before:always; }</style>
<script type="text/javascript" language="javascript">
function printp(){ window.print(); }
</script>

<?php
if(isset($_REQUEST['orgr']) && $_REQUEST['orgr']!=''){
	$orgrCond="f.oid=".$_REQUEST['orgr'];
}else{
	$orgrCond='1=1';
}

    if(isset($_REQUEST['vii']) && $_REQUEST['vii']!=''){ $keyArea="f.village_id like '%".$_REQUEST['vii']."%'";}
	elseif(isset($_REQUEST['tii']) && $_REQUEST['tii']!=''){ $keyArea="f.tahsil_id like '%".$_REQUEST['tii']."%'";}
	elseif(isset($_REQUEST['dii']) && $_REQUEST['dii']!=''){ $keyArea="f.distric_id like '%".$_REQUEST['dii']."%'";}
	elseif(isset($_REQUEST['sii']) && $_REQUEST['sii']!=''){ $keyArea="f.state_id like '%".$_REQUEST['sii']."%'";}
	else{$keyArea='1=1';}

    $qry.=" SELECT f.*, o.oname, v.VillageName, t.TahsilName, d.DictrictName, s.StateName FROM farmers f, organiser o,village v, tahsil t, distric d, state s where f.village_id=v.VillageId and f.tahsil_id=t.TahsilId and f.distric_id=d.DictrictId and f.state_id=s.StateId and f.oid=o.oid and ".$orgrCond." and ".$keyArea." ";
		
	
	$agr=mysql_query($qry);

    $sn=1;
	while ($agrd=mysql_fetch_assoc($agr)) 
	{
	  $str = chunk_split($agrd['tem_fid'], 4, ' '); 
?>	  
	 <table style="width:100%;" border="1" cellspacing="1">
	  <tr>
	   <td style="background-color:#FFFF71; height:25px;"><b>Sn:</b>&nbsp;<?=$sn;?> &nbsp;&nbsp; <b>FARMER ID:</b>&nbsp;<?=$str; ?> &nbsp;&nbsp; <b>Name:</b>&nbsp;<?=ucfirst(strtolower($agrd['fname'])); ?> &nbsp;&nbsp; <b>Contact:</b>&nbsp;<?=$agrd['contact_1']; ?> &nbsp;&nbsp;&nbsp;&nbsp;<?php if($sn==1){ echo '<span onclick="printp()" style="color:#000099;cursor:pointer;"><u>Print<u></span>'; } ?></td>
	  </tr>
	  <tr>
	   <td colspan="2" style="vertical-align:top;">
	   <?php
	       if(file_exists("files/".$agrd['doc_aadhar'])){ $path='files'; }
		   elseif(file_exists("files_2/".$agrd['doc_aadhar'])){ $path='files_2'; }
		   elseif(file_exists("files_3/".$agrd['doc_aadhar'])){ $path='files_3'; } 
		   elseif(file_exists("files_4/".$agrd['doc_aadhar'])){ $path='files_4'; }
		   elseif(file_exists("files_5/".$agrd['doc_aadhar'])){ $path='files_5'; }
	   ?>     
	    <img src="<?=$path?>/<?=$agrd['doc_passbook'];?>" style="width:100%; max-height:850px;" />
	   </td>
	  </tr>  
	  <tr><td style="height:50px;border:hidden;" >&nbsp;</td></tr>
	  </table>
	  
	<div class="pagebreak"> </div>
     

<?php 
	  $sn++;
     }

?>

