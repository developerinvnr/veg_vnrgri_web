<?php include 'config.php'; ?>
<?php 
if(isset($_POST['savedocdetails']))
{

 if((!empty($_FILES["Aadhar"])) && ($_FILES['Aadhar']['error']==0))
  { $AadharN=strtolower(basename($_FILES['Aadhar']['name']));
    $AadharExt=substr($AadharN, strrpos($AadharN, '.') + 1);
	$Aadhar='Aadhar_'.$_POST['oid'].'_doc.'.$AadharExt;
	$AadharPath='org_file/'.$Aadhar;
    move_uploaded_file($_FILES["Aadhar"]["tmp_name"],$AadharPath);
  } else {$Aadhar='';}
  
 if((!empty($_FILES["Pan"])) && ($_FILES['Pan']['error']==0))
  { $PanN=strtolower(basename($_FILES['Pan']['name']));
    $PanExt=substr($PanN, strrpos($PanN, '.') + 1);
	$Pan='Pan_'.$_POST['oid'].'_doc.'.$PanExt;
	$PanPath='org_file/'.$Pan;
    move_uploaded_file($_FILES["Pan"]["tmp_name"],$PanPath);
  } else {$Pan='';}
  
 if((!empty($_FILES["Passbook"])) && ($_FILES['Passbook']['error']==0))
  { $PassbookN=strtolower(basename($_FILES['Passbook']['name']));
    $PassbookExt=substr($PassbookN, strrpos($PassbookN, '.') + 1);
	$Passbook='Passbook_'.$_POST['oid'].'_doc.'.$PassbookExt;
	$PassbookPath='org_file/'.$Passbook;
    move_uploaded_file($_FILES["Passbook"]["tmp_name"],$PassbookPath);
  } else {$Passbook='';} 
 
 
  $sqlUp=mysql_query("update organiser set doc_aadhar='".$Aadhar."', doc_pan='".$Pan."', doc_passbook='".$Passbook."' where oid=".$_POST['oid']);

  if($sqlUp){echo '<script>alert("File upload successfully"); window.close();</script>';} 
 
}

if($_REQUEST['Act']=='del' && $_REQUEST['oid']!='' && $_REQUEST['file']!='')
{
  if($_REQUEST['n']==1){ $fup="doc_aadhar=''";}
  elseif($_REQUEST['n']==2){ $fup="doc_pan=''";}
  elseif($_REQUEST['n']==3){ $fup="doc_passbook=''";}
  $sqlUp=mysql_query("update organiser set ".$fup." where oid=".$_REQUEST['oid']);

  if($sqlUp)
  {
    unlink('org_file/'.$_REQUEST['file']);
	echo '<script>alert("File deleted successfully");</script>';
	//header('location:uporgfile.php?oid='.$_REQUEST['oid']);
  }
}

?>
<html>
<head>
<title><?php include_once('../Title.php'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link type="text/css" href="css/body.css" rel="stylesheet" />
<link type="text/css" href="css/pro_dropdown_3.css" rel="stylesheet"/>
<style>
.htf{font-family:Times New Roman;;color:#000;font-weight:bold;text-align:center;font-size:18px;height:24px;}
.tdf{font-family:Times New Roman;font-size:14px;height:22px;color:#000000;}
.tdf2{background-color:#FFFF9D;font-family:Times New Roman;;font-size:15px;height:22px;text-align:center;}
.CalenderButton {background-image:url(images/CalenderBtn.jpeg);width:16px;height:16px;background-color:#E0DBE3;border-color:#FFFFFF;}
</style>
<body style="background-color:#FFFFFF;">
	
<script type="text/javascript" language="javascript">
function validate(fn) 
{ 
 document.getElementById("loaderDiv").style.display='block'; 
}

function FunDelete(n,oid,fl)
{
 var agree=confirm("Are you sure?");
 if(agree)
 {
  window.location="uporgfile.php?Act=del&n="+n+"&oid="+oid+"&file="+fl;
  document.getElementById("loader2Div").style.display='block'; 
 }
}
</script>
<center>
<div id="loaderDiv" style="background-color: rgba(0,0,0,0.8);width: 100%;height: 100%;position: fixed;top:0px;left: 0px;font-size: 12px; display:none;">	
	<center>
	<span style="color:white;top: 50%;left:10%;position: absolute;">Please Wait, Uploading in Progress...<img src="image/loader.gif"></span>
	</center>
</div>
<div id="loader2Div" style="background-color: rgba(0,0,0,0.8);width: 100%;height: 100%;position: fixed;top:0px;left: 0px;font-size: 12px; display:none;">	
	<center>
	<span style="color:white;top: 50%;left:10%;position: absolute;">Please Wait, Deleting in Progress...<img src="image/loader.gif"></span>
	</center>
</div>
<table border="0" style="margin-top:50px;width:98%;">
<tr>
 <td style="width:100%;" align="center">
  <table border="0" style="width:99%;">
   <tr><td style="width:100%;" align="center"><b>Upload Organiser file</b></td></tr>
   <?php $alls=mysql_query('SELECT * FROM `organiser` where oid='.$_REQUEST['oid']); $allsd=mysql_fetch_assoc($alls); ?>
   <tr><td style="height:20px;color:#0069D2;" align="center"><b><?php echo strtoupper($allsd['oname']).' / '.$allsd['mobile_1']; ?></b></td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr>
    <td class="tdf" align="center">	
    <table border="1" style="width:100%;" cellpadding="0" cellspacing="0">
<form name="fn" method="post" enctype="multipart/form-data" onSubmit="return validate(this)" >
<input type="hidden" name="oid" value="<?php echo $_REQUEST['oid']; ?>" />
<input type="hidden" name="sn" value="<?php echo $_REQUEST['sn']; ?>" />
     <tr style="background-color:#FFFFFF;height:24px;">
	  <td class="tdf">&nbsp;Aadhar</td>
	  <td class="tdf" valign="top"><input type="file" class="InputSel" id="Aadhar" name="Aadhar" readonly>
	  <?php if($allsd['doc_aadhar']!=''){ echo '<font color="#0033CC"><b>Uploaded</b></font>'; } ?></td>
	  <td style="width:50px;text-align:center;cursor:pointer;"><?php if($allsd['doc_aadhar']!=''){ ?><img src="image/delete.png" onClick="FunDelete(1,<?=$_REQUEST['oid']?>,'<?=$allsd['doc_aadhar']?>')"><?php } ?></td>
	 </tr>	
	 <tr style="background-color:#FFFFFF;height:24px;">
	  <td class="tdf">&nbsp;Pan</td>
	  <td class="tdf" valign="top"><input type="file" class="InputSel" id="Pan" name="Pan" readonly>
	  <?php if($allsd['doc_pan']!=''){ echo '<font color="#0033CC"><b>Uploaded</b></font>'; } ?></td>
	  <td style="width:50px;text-align:center;cursor:pointer;"><?php if($allsd['doc_pan']!=''){ ?><img src="image/delete.png" onClick="FunDelete(2,<?=$_REQUEST['oid']?>,'<?=$allsd['doc_pan']?>')"><?php } ?></td>
	 </tr>
	 <tr style="background-color:#FFFFFF;height:24px;">
	  <td class="tdf">&nbsp;Passbook</td>
	  <td class="tdf" valign="top"><input type="file" class="InputSel" id="Passbook" name="Passbook" readonly>
	  <?php if($allsd['doc_passbook']!=''){ echo '<font color="#0033CC"><b>Uploaded</b></font>'; } ?></td>
	  <td style="width:50px;text-align:center;cursor:pointer;"><?php if($allsd['doc_passbook']!=''){ ?><img src="image/delete.png" onClick="FunDelete(3,<?=$_REQUEST['oid']?>,'<?=$allsd['doc_passbook']?>')"><?php } ?></td>
	 </tr>
	 <tr>
	  <td colspan="4" class="tdf" valign="top" align="center"><input type="submit" name="savedocdetails" value="upload" style="width:60px;" /></td>
	 </tr> 
</form>	 
	</table>
	</td>
  </table>
 </td>
</tr>
</table>
</center>

</body>