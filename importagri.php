<?php
session_start();
include "config.php";
error_reporting(E_ALL);

if(isset($_POST['submit'])){
   
    $name = $_FILES['fileToUpload']['name'];
    $size = $_FILES['fileToUpload']['size'];
    $type = $_FILES['fileToUpload']['type'];
    $tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $ext = pathinfo($name, PATHINFO_EXTENSION);
	
    if(isset($name)){
        if(!empty($name)){
            if($ext=='csv'){
                if(($handle = fopen($_FILES['fileToUpload']['tmp_name'], "r"))!== FALSE) 
                {
                  $ctr = 1; // used to exclude the CSV header
                  while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                  {
                    $AgriId=mysql_real_escape_string($data[1]); //Agreement No
			        $LotNo=mysql_real_escape_string($data[23]); //Lot Number
                    
                    if($ctr>3){

                        $agyear = substr($AgriId, 0, 4); //here extracting year from agree_no
					    $agrisel = mysql_query("select * from `agreementlot_".$agyear."` where agree_no='".$AgriId."' AND lot_no='".$LotNo."'");
                        $agcount=mysql_num_rows($agrisel);
                        $ins='';
						if($agcount==0)
						{  

                         $ins=mysql_query("insert into agreementlot_".$agyear."(agree_no, lot_no) values('".$AgriId."', '".$LotNo."')");            if($ins){$ins=1;} 
                        } //if($agcount==0)
              
			            if($ins==1){ $msg='Data Updated Successfully'; $msgcolor='green'; }
						else{ $msg='Problem Occur'; $msgcolor='red'; }
			            
						echo "<script>document.getElementById('loaderDiv').style.display='none';</script>";
                     
                        $ctr++;
                    }else{
                       
                        $ctr++;
                    }
                    
                  
                    
                  }
                  

                  fclose($handle);
                  
                }
            }else{
                $msg='Please choose \'.csv\' file only !';
                $msgcolor='#E14900';
            }
            
        }else{
            $msg='Please choose the file !';
            $msgcolor='#E14900';
        }
    }

}


/*if(isset($_POST['submit'])){
    

    $name = $_FILES['fileToUpload']['name'];
    $size = $_FILES['fileToUpload']['size'];
    $type = $_FILES['fileToUpload']['type'];
    $tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $ext = pathinfo($name, PATHINFO_EXTENSION);
  
    if(isset($name)){
        if(!empty($name)){
            if($ext=='csv'){
                if(($handle = fopen($_FILES['fileToUpload']['tmp_name'], "r"))!== FALSE) 
                {
                  $ctr = 1; // used to exclude the CSV header


                  
                  while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                  {


                    $c1=mysql_real_escape_string($data[1]); //Agreement No
					$c17=mysql_real_escape_string($data[21]); //Sowing Acre
                    $c18=mysql_real_escape_string($data[22]); //Standing Acre
                    
                    if($ctr>1 ){

                        $agyear = substr($c1, 0, 4); //here extracting year from agree_no

                        $agrisel=mysql_query("select * from `agreement_".$agyear."` where agree_no='".$c1."'");
                        $agcount=mysql_num_rows($agrisel);
                        if($agcount>0){  
						 $agdata=mysql_fetch_assoc($agrisel);
                            //if farmer exists, then just add cureent acres to previous acres //`sowing_acres`='".$c17."', 
                            
                            if(mysql_query("Update `agreement_".$agyear."` set `standing_acres`='".$c18."' where agree_no='".$c1."'")){
                               
                                $msg='Data Updated Successfully'; $msgcolor='green';
                               
                            }
                        }else{
                            
                            

                        }
                        
                        
                     
                        $ctr++;
                    }else{
                       
                        $ctr++;
                    }
                    
                  
                    
                  }
                  

                  fclose($handle);
                  
                }
            }else{
                $msg='Please choose \'.csv\' file only !';
                $msgcolor='#E14900';
            }
            
        }else{
            $msg='Please choose the file !';
            $msgcolor='#E14900';
        }
    }

}*/
?>
<div id="loaderDiv" style="background-color: rgba(0,0,0,0.8);width: 100%;height: 100%;position: fixed;top:0px;left: 0px;font-size: 12px; display:none;">	
	<center>
	<span style="color:white;top: 50%;left:38%;position: absolute;">Please Wait, Uploading in Progress...<img src="image/loader.gif"></span>
	</center>
</div>
<!DOCTYPE html>
<html>
<script type="text/javascript">
function Validate(excelform)
{
  document.getElementById('loaderDiv').style.display='block';
}
</script>
	
<body>
<?php
if(isset($msg)){
    echo '<br>';
?>
    <div style="width:90%;font-family: Arial, Helvetica, sans-serif; background-color:<?php echo $msgcolor;?>;color:white;padding:10px; border-radius: 3px;">
        <?php echo $msg;?>
    </div>
    <br>
<?php
}
?>
<br><br>
<center>
<fieldset>
<legend style="font-weight:bold;font-size:22px;font-family: Arial, Helvetica, sans-serif;">Import Lot Number:</legend>
<br>

<form name="excelform" action="importagri.php" method="post" enctype="multipart/form-data" onSubmit="return Validate(this)">
    
    <input class="btn" type="file" name="fileToUpload" id="fileToUpload">
    &nbsp;&nbsp;(<a href="Lot No. Import Format.xlsx">CSV Format</a>)
    <br><br>
    <i style="font-size:14px;font-family: Arial, Helvetica, sans-serif; font-weight: bold;color:#666666">
    ( Note: Please upload '.csv' file only )</i>
    <br><br>
    <input class="btn" type="submit" value="Upload" name="submit">
</form>

</fieldset>
</center>
</body>
</html>