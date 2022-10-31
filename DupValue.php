<?php
include 'config.php';
?>
<?php /*
if($_REQUEST['action']=='DelDupId' AND $_REQUEST['DupId']>0)
{  echo "delete from village where VillageId=".$_REQUEST['DupId']; $sqlDel=mysql_query("delete from village where VillageId=".$_REQUEST['DupId']); }
?>
<style type="text/css">
	.pagethings{
		position: absolute;
		left: 200px;
		padding: 20px;
	}
	.nshw{
		display: none;
	}

</style>
<div class="pagethings">
 <div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
<table>

<tr>
	 <td><font style="font-size:14px;font-weight:bold;color:#000000;"><b>Villages</b></font><br>
	   <table border="0">      
<?php $sql=mysql_query("SELECT COUNT(*) AS repetitions, `VillageName`, `TahsilId` FROM village GROUP BY VillageName, TahsilId HAVING repetitions >1 ORDER BY TahsilId, VillageName ASC");
while($res=mysql_fetch_assoc($sql)){ ?>
        <tr>
		 <td colspan="6" style="font-size:14px;color:#000000;font-family:Georgia;"><?php echo 'Dup:&nbsp;'.$res['repetitions'].',&nbsp;Date:&nbsp;'.$res['VillageName'].'-'.$res['TahsilId']; ?></td>
		</tr>
		<tr>
		 <td align="left">
		  <table bgcolor="#FFF" border="1" cellspacing="0" cellspacing="1">
<?php $sql2=mysql_query("select VillageId from village where VillageName='".$res['VillageName']."' AND TahsilId=".$res['TahsilId']." order by VillageId ASC"); 
while($res2=mysql_fetch_assoc($sql2)){ 

 $sql3=mysql_query("select village_id from farmers where village_id=".$res2['VillageId']); 
 $row3=mysql_num_rows($sql3); 

?>		  
		   <tr>
		    <td style="width:100px;font-size:12px;" align="center"><?php echo $res2['VillageId']; if($row3>0){echo ' - Y ';}else{echo ' - N ';} ?></td>
			<td style="width:50px;font-size:12px;" align="center"><span style="cursor:progress"><img src="image/delete.png" onClick="javascript:window.location='DupValue.php?action=DelDupId&ern1=r114&ern2w=234&ern3y=10234&ern=4e2&erne=4e&ernw=234&erney=110022344&rernr=09drfGe&ernS=eewwqq&yAchQ=1&mAchQ=1&DupId=<?php echo $res2['VillageId']; ?>'"/></span></td>
		   </tr>
<?php } ?>		   
		  </table>
		 </td>
		</tr>  
<?php } ?>		
	   </table>
	  </td>
	</tr>
 </table>
 </div> 	
</div>

*/ ?>


<?php
if($_REQUEST['action']=='DelDupId' AND $_REQUEST['DupId']>0)
{  echo "delete from tahsil where TahsilId=".$_REQUEST['DupId']; $sqlDel=mysql_query("delete from tahsil where TahsilId=".$_REQUEST['DupId']); }
?>
<style type="text/css">
	.pagethings{
		position: absolute;
		left: 200px;
		padding: 20px;
	}
	.nshw{
		display: none;
	}

</style>
<div class="pagethings">
 <div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
<table>

<tr>
	 <td><font style="font-size:14px;font-weight:bold;color:#000000;"><b>Villages</b></font><br>
	   <table border="0">      
<?php $sql=mysql_query("SELECT COUNT(*) AS repetitions, `TahsilName`, `DistrictId` FROM tahsil GROUP BY TahsilName, DistrictId HAVING repetitions >1 ORDER BY DistrictId, TahsilName ASC");
while($res=mysql_fetch_assoc($sql)){ ?>
        <tr>
		 <td colspan="6" style="font-size:14px;color:#000000;font-family:Georgia;"><?php echo 'Dup:&nbsp;'.$res['repetitions'].',&nbsp;Date:&nbsp;'.$res['TahsilName'].'-'.$res['DistrictId']; ?></td>
		</tr>
		<tr>
		 <td align="left">
		  <table bgcolor="#FFF" border="1" cellspacing="0" cellspacing="1">
<?php $sql2=mysql_query("select TahsilId from tahsil where TahsilName='".$res['TahsilName']."' AND DistrictId=".$res['DistrictId']." order by TahsilId ASC"); 
while($res2=mysql_fetch_assoc($sql2)){ 

 $sql3=mysql_query("select tahsil_id from farmers where tahsil_id=".$res2['TahsilId']); 
 $row3=mysql_num_rows($sql3); 

?>		  
		   <tr>
		    <td style="width:100px;font-size:12px;" align="center"><?php echo $res2['TahsilId']; if($row3>0){echo ' - Y ';}else{echo ' - N ';} ?></td>
			<td style="width:50px;font-size:12px;" align="center"><span style="cursor:progress"><img src="image/delete.png" onClick="javascript:window.location='DupValue.php?action=DelDupId&ern1=r114&ern2w=234&ern3y=10234&ern=4e2&erne=4e&ernw=234&erney=110022344&rernr=09drfGe&ernS=eewwqq&yAchQ=1&mAchQ=1&DupId=<?php echo $res2['TahsilId']; ?>'"/></span></td>
		   </tr>
<?php } ?>		   
		  </table>
		 </td>
		</tr>  
<?php } ?>		
	   </table>
	  </td>
	</tr>
 </table>
 </div> 	
</div>