<?php
session_start();
include "config.php";
error_reporting(E_ALL && ~E_NOTICE);

if(isset($_POST['submit']))
{
   
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
                    $ArrDate=mysql_real_escape_string($data[1]); //Arrival Date
			        $LotNo=mysql_real_escape_string($data[4]); //Lot Number
					$ArrBag=mysql_real_escape_string($data[7]); //Arrival No Of Bag
			        $ArrQty=mysql_real_escape_string($data[8]); //Arrival Qty
                    
					/*********************************/
					$chr="/";
					if(strpos($LotNo, $chr)!== false)
					{
					  $firstPart = strtok( $LotNo, $chr );
					  $lot_no=substr($firstPart, 1);             
                    } 
					else{ $lot_no=$LotNo; }
					
					//$lot_no=substr($lot_no,1);
					
					/*********************************/
					
                    if($ctr>3){
                        
						$curr_year=date("Y"); $prv_year=date("Y")-1;
						$up=0;
						for($i=$prv_year; $i<=$curr_year; $i++)
						{
						 $agrisel = mysql_query("select * from `agreementlot_".$i."` where lot_no='".$lot_no."'");
                         $agcount=mysql_num_rows($agrisel);
                         
                         //echo $agcount.'-';
                         
						 if($agcount>0)
						 {
						      //echo "update agreementlot_".$i." set arrival_date='".date("Y-m-d",strtotime($ArrDate))."', arrival_noofbag='".$ArrBag."', arrival_qty='".$ArrQty."', arrival_upby=".$_SESSION['uId']." where lot_no='".$lot_no."'";
						   $up=mysql_query("update agreementlot_".$i." set arrival_date='".date("Y-m-d",strtotime($ArrDate))."', arrival_noofbag='".$ArrBag."', arrival_qty='".$ArrQty."', arrival_upby=".$_SESSION['uId']." where lot_no='".$lot_no."'");
						   if($up){$up=1;}
						 }
						}
                        
			            if($up==1){ $msg='Data Updated Successfully'; $msgcolor='green'; }
						else
						{ //$msg='Problem Occur'; $msgcolor='red'; 
						  $msg='Data Updated Successfully'; $msgcolor='green';
						}
			            
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

} //if(isset($_POST['submit']))

 
   
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
<legend style="font-weight:bold;font-size:22px;font-family: Arial, Helvetica, sans-serif;">Import Arrival Details:</legend>
<br>

<form name="excelform" action="arrivalimport.php" method="post" enctype="multipart/form-data" onSubmit="return Validate(this)">
    
    <input class="btn" type="file" name="fileToUpload" id="fileToUpload">
    &nbsp;&nbsp;(<a href="Arrival Data Import Format.xlsx">CSV Format</a>)
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