<div id="loaderDiv" style="background-color: rgba(0,0,0,0.8);width: 100%;height: 100%;position: fixed;top:0px;left: 0px;font-size: 12px;z-index:9999999;">
  <span style="color:white;top: 40%;left:42%;position: absolute;">Please Wait, getting all agreement data...<img src="image/loader.gif"></span>
</div>

<?php 
session_start(); 
include 'sidemenu.php'; 

/*
============================================================================================
  here in below code, putting all permitted states, districts, tahsil and villages in session 
  so it can be used on all pages without loading again and again
============================================================================================
*/


?>
<style type="text/css">
.pagethings{ position:absolute; left:200px; padding:20px; }
.card{ margin-top:50px; background-color:#D3E4EF; cursor:pointer; border:1px solid #c1c1c1;
       font-family: font-family: Arial, Helvetica, sans-serif;
       padding: 40px 0px; }
.count{ font-size:35px;font-weight:bold; color:#3F779E; }
</style>
<script>
function DelFun(vid)
{  
   $.post("dupAjax.php",{ act:'deletedd',vid:vid },function(data) { 
                                                    
			if(data.includes("done")){ //alert("success");
			
			document.getElementById("TR"+vid).style.background='#009933'; 

			}else if(data.includes("error")){
				alert(' Something went wrong!');
			}

          }
        ); 
    
}

</script>
<div class="pagethings" style="width:85%;">
 <div class="card-deck" style="padding-right:50px;padding-left:50px;">

 <!--/***********************************/-->
 <!--/***********************************/-->
 <?php //if($_SESSION['uId']==14){ ?>
 <?php //if($_REQUEST['act']=='DelDupId' AND $_REQUEST['VisitId']>0)
 //{  $sqlDel=mysql_query("delete from visit_detail where VisitId=".$_REQUEST['VisitId']); } ?>
 
 <tr>
  <td><font style="font-size:14px;font-weight:bold;color:#000;"><b>Month</b></font><br>
  <table border="0">      
  <?php $sql=mysql_query("SELECT COUNT(*) AS repetitions, `VUserId`, VDate, VTime FROM visit_details GROUP BY VUserId, VDate, VTime, VCrop, VHyb_code,  VState, VVillage, VTot_acrg  HAVING repetitions >1 ORDER BY VUserId,VDate ASC"); while($res=mysql_fetch_assoc($sql)){ ?>
    <tr>
     <td colspan="6" style="font-size:14px;color:#000;font-family:Georgia;"><?php echo 'Dup:&nbsp;'.$res['repetitions'].',&nbsp;User:&nbsp;'.$res['VUserId'].',&nbsp;Month:&nbsp;'.$res['VDate'].',&nbsp;Month:&nbsp;'.$res['VTime']; ?></td>
    </tr>
    <tr>
	 <td align="left">
	  <table bgcolor="#FFF" border="1" cellspacing="0" cellspacing="1">
      <?php $sql2=mysql_query("select VisitId, VTime, VCrop, VHyb_code, VVillage, VState, VTot_acrg from visit_details where VUserId=".$res['VUserId']." AND VDate='".$res['VDate']."' AND VTime='".$res['VTime']."' ORDER BY VUserId,VDate,VTime,VTot_acrg ASC,VCrop,VHyb_code,VState");
while($res2=mysql_fetch_assoc($sql2)){ ?>		  
	   <tr id="TR<?=$res2['VisitId']?>">
	    <td style="width:100px;font-size:12px;" align="center"><?php echo $res2['VisitId']; ?></td>    
		<td style="width:100px;font-size:12px;" align="center"><?php echo $res2['VTime']; ?></td>
		<td style="width:100px;font-size:12px;" align="center"><?php echo $res2['VCrop']; ?></td>
		<td style="width:100px;font-size:12px;" align="center"><?php echo $res2['VHyb_code']; ?></td>
		<td style="width:100px;font-size:12px;" align="center"><?php echo $res2['VState']; ?></td>
		<td style="width:100px;font-size:12px;" align="center"><?php echo $res2['VTot_acrg']; ?></td>
		<td style="width:50px;font-size:12px;" align="center"><span style="cursor:pointer;"><img src="image/delete.png" onClick="DelFun(<?=$res2['VisitId']?>)"/></span></td>
	   </tr>
       <?php } //while($res2=mysql_fetch_assoc($sql2)) ?>		   
	  </table>
	 </td>
	</tr>  
  <?php } //while($res=mysql_fetch_assoc($sql)) ?>		
  </table>
  </td>
 </tr>
 <?php //} //if($_SESSION['EmployeeID']==169)?>
 <!--/***********************************/-->
 <!--/***********************************/-->

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


