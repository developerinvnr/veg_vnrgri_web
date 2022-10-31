<!---
<div id="loaderDiv" style="background-color: rgba(0,0,0,0.8);width: 100%;height: 100%;position: fixed;top:0px;left: 0px;font-size: 12px;z-index: 9999;">
	
	<center>
	<span style="color:white;top: 40%;left:42%;position: absolute;">Please Wait, Loading all farmers list...<img src="image/loader.gif"></span>
	</center>
</div>
-->


<?php
include 'sidemenu.php';



 /*
====================================================================================================================
====================================================================================================================
   
    the page   'changeFarmerDocNames.php'    is for renaming the uploaded images as per the combination of 
    "uploaded id"+"category name"
    to make the uploaded file names unique

====================================================================================================================
====================================================================================================================
*/
include 'changeFarmerDocNames.php';

if($_REQUEST['acct']=='delete' && $_REQUEST['id']>0)
{
 $sqlD=mysql_query("delete from farmers where fid=".$_REQUEST['id']);
 if($sqlD)
 {
  echo '<script>alert("farmer deleted successfully!"); window.location="farmer.php?df='.$_REQUEST['df'].'&dt='.$_REQUEST['dt'].'&fsts='.$_REQUEST['fsts'].'";</script>';
 }
}

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
	.lightlabel{
		background-color: #ccc !important;
		padding-left: 5px !important;
		font-size: 12px;
		font-weight: bold;
		padding: 0px;
	}
	.fstable tbody th{
	  color: #000;
	  font-size: 12px;
	  font-weight: bold;
	  padding: 5px !important;
	}

	.fstable tbody td{
	  padding: 1px;
	}

</style>

<script language="javascript">
function OpenDelete(fid)
{
 var agree = confirm("Are you sure, you want to delete this farmers?");
 if(agree)
 {  
   var agree2 = confirm("Second time : Are you sure, you want to delete this farmers?");
   if(agree2)
   {
    var df=$('#df').val(); var dt=$('#dt').val(); var fsts = $('#fstatus').val();
    window.location="farmer.php?acct=delete&id="+fid+"&df="+df+"&dt="+dt+"&fsts="+fsts;
   }
   else{ return false; } 
 }else{ return false; }
}		
</script>

<?php
/*============================================
here taking all the states, districts, tahsils, village and putting on a array, 
so in below loops we don't have to fetch all states again and again...
==============================================*/

// $alls=mysql_query('SELECT * FROM `state`');
// while ($allsd=mysql_fetch_assoc($alls)) {
// 	$sarr[$allsd['StateId']]=$allsd['StateName'];
// }

// $alld=mysql_query('SELECT * FROM `distric`');
// while ($alldd=mysql_fetch_assoc($alld)) {
// 	$darr[$alldd['DictrictId']]=$alldd['DictrictName'];
// }

$sarr=$_SESSION['sarr'];
$darr=$_SESSION['darr'];

/*

$allt=mysql_query('SELECT * FROM `tahsil`');
while ($alltd=mysql_fetch_assoc($allt)) {
	$tarr[$alltd['TahsilId']]=$alltd['TahsilName'];
}

$allv=mysql_query('SELECT * FROM `village`');
while ($allvd=mysql_fetch_assoc($allv)) {
	$varr[$allvd['VillageId']]=$allvd['VillageName'];
}

*/

?>

<div class="pagethings">
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<button id="addfarbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addfartbl').show(800);$('#actiontext').html('&nbsp;New Farmer');$(this).hide(500);$('#addFarmIframe').attr('src','addFarmer.php');">Add Farmer</button>

	<div id="addfartbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;" id="actiontext"></h6>
		
		<iframe id="addFarmIframe" src="" style="width:100%;height:420px;border:0px;"></iframe>
	</div>

	<div id="addfartbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;width:100%;">
		<h6 style="font-weight: bold;">All Farmer &nbsp;&nbsp;&nbsp;&nbsp;
		 <font style="font-size:12px;">
		 Date From:&nbsp;<input id="df" name="df" style="width:130px;text-align:center;" value="<?=date("d-m-Y",strtotime($_REQUEST['df']));?>" readonly/>
		 &nbsp;&nbsp;
		 To:&nbsp;<input type="text" id="dt" name="dt" style="width:130px;text-align:center;" value="<?=date("d-m-Y",strtotime($_REQUEST['dt']));?>" readonly/>
		 &nbsp;&nbsp;
		 Status: 
		 <select id="fstatus">
			<option value="P" <?php if($_REQUEST['fsts']=='P'){echo 'selected';}?>>Pending</option>
			<option value="C" <?php if($_REQUEST['fsts']=='C'){echo 'selected';}?>>Completed</option>
			<option value="N" <?php if($_REQUEST['fsts']=='N'){echo 'selected';}?>>New, From Last Month</option>
			<option value="A" <?php if($_REQUEST['fsts']=='A'){echo 'selected';}?>>All</option>
		 </select>
		 &nbsp;&nbsp;
		 
		 <input type="button" value="show" onclick="FunClickFT()" style="width:60px;"/> 
		 </font>
		<script language="javascript">
		 $('#df').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#df').val(); });
		 $('#dt').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#dt').val(); });
		 function FunClickFT()
		 {
		  var df=$('#df').val(); var dt=$('#dt').val(); var fsts = $('#fstatus').val();
		  window.location="farmer.php?df="+df+"&dt="+dt+"&fsts="+fsts;
		 }
		</script>
		</h6>

<?php 
$stid= mysql_query("SELECT state_id from user_location where uid=".$_SESSION['uId']." AND sts='A' AND state_id>0");
$rows=mysql_num_rows($stid);
while($rec=mysql_fetch_array($stid)){ $array_s[]=$rec['state_id']; }
$state = implode(',', $array_s);

$utid= mysql_query("SELECT uid from user_location where state_id in (".$state.") AND sts='A' AND state_id>0 group by uid"); //AND uid not in (12,13,14,15)
$rowu=mysql_num_rows($utid);
while($recu=mysql_fetch_array($utid)){ $array_u[]=$recu['uid']; }
$user = implode(',', $array_u);
?>

		
		<table id="tahtable" class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
			<th style="width:50px;">Sn</th>
			<!--<th style="width:60px;">Farmer ID</th>-->
			<th style="width:130px;">Farmer ID</th>
			<th style="width:200px;">Farmer Name</th>
			<th style="width:80px;">Contact</th>
			<th style="width:150px;">Father of/ Wife of</th>
			<th style="width:100px;">State</th>
			<th>District</th>
			<!--<th>Tahsil</th>
			<th>Village</th>-->
			<th style="width:100px;">File</th>
			<th style="width:100px;">Cr. By</th>
			<th style="width:50px;">Action</th>
			</tr>
			</thead>
			<tbody>

			<?php if($_REQUEST['df']!='' && $_REQUEST['dt']!='')
			{ 
			    
			 if($_REQUEST['fsts']=='P')
			 {
			  $qryextr="AND cr_date between '".date("Y-m-d",strtotime($_REQUEST['df']))."' AND '".date("Y-m-d",strtotime($_REQUEST['dt']))."' AND (oid IS NULL OR bank_name IS NULL OR account_no IS NULL OR ifsc_code IS NULL OR village_id IS NULL OR father_name IS NULL OR state_id='' OR distric_id='' OR tahsil_id='' OR village_id='')";    
			  //$qryextr='AND (oid IS NULL OR bank_name IS NULL OR account_no IS NULL OR ifsc_code IS NULL OR village_id IS NULL OR father_name IS NULL)';
			 }
			 elseif($_REQUEST['fsts']=='C')
			 {
			  $qryextr="AND cr_date between '".date("Y-m-d",strtotime($_REQUEST['df']))."' AND '".date("Y-m-d",strtotime($_REQUEST['dt']))."' AND oid>0 AND bank_name IS NOT NULL AND account_no IS NOT NULL AND ifsc_code IS NOT NULL AND village_id IS NOT NULL AND father_name IS NOT NULL AND state_id!='' AND distric_id!='' AND tahsil_id!='' AND village_id!=''";    
			  //$qryextr='AND oid>0 AND bank_name IS NOT NULL AND account_no IS NOT NULL AND ifsc_code IS NOT NULL AND village_id IS NOT NULL AND father_name IS NOT NULL';
			 }
			 elseif($_REQUEST['fsts']=='N')
			 {
			  $Onedate=date('Y-m-d', strtotime("-1 months", strtotime(date("Y-m-d"))));
			  $qryextr="AND cr_date>='".$Onedate."'";
			  
			  $allvar=mysql_query("SELECT * FROM `farmers` where (state_id in ($state) OR cr_by in ($user)) ".$qryextr." order by fname asc");
			  
			 }
			 elseif($_REQUEST['fsts']=='A')
			 {
			  //$qryextr="AND cr_date between '".date("Y-m-d",strtotime($_REQUEST['df']))."' AND '".date("Y-m-d",strtotime($_REQUEST['dt']))."'"; 
			  $qryextr="cr_date between '".date("Y-m-d",strtotime($_REQUEST['df']))."' AND '".date("Y-m-d",strtotime($_REQUEST['dt']))."'";
			  
			 $allvar=mysql_query("SELECT * FROM `farmers` where ".$qryextr." order by fname asc");
			 }
			 else
			 {
			  $qryextr="AND cr_date between '".date("Y-m-d",strtotime($_REQUEST['df']))."' AND '".date("Y-m-d",strtotime($_REQUEST['dt']))."' AND (oid IS NULL OR bank_name IS NULL)";   
			 $allvar=mysql_query("SELECT * FROM `farmers` where (state_id in ($state) OR cr_by in ($user)) AND ".$qryextr." order by fname asc"); 
			  
			  //$qryextr='AND (oid IS NULL OR bank_name IS NULL OR account_no IS NULL OR ifsc_code IS NULL OR village_id IS NULL OR father_name IS NULL)';
			 }   
			 
			 
			 //echo "SELECT * FROM `farmers` where (state_id in ($state) OR cr_by in ($user)) ".$qryextr." order by fname asc";
			 
			 //$allvar=mysql_query("SELECT * FROM `farmers` order by fname asc");
			    
			 //$allvar=mysql_query("SELECT * FROM `farmers` where (state_id in ($state) OR cr_by in ($user)) ".$qryextr." order by fname asc");
             $sn=1;
             
             
             
			 while($allf=mysql_fetch_assoc($allvar)){ 
			
			 $len=strlen($allf['fid']);
			 if($len==1){$fid='0000'.$allf['fid'];}elseif($len==2){$fid='000'.$allf['fid'];}
			 elseif($len==3){$fid='00'.$allf['fid'];}elseif($len==4){$fid='0'.$allf['fid'];}else{$fid=$allf['fid'];}
			?>
			<tr>
                
				<td>
					<?=$sn?>
				</td>
				<?php /*
				<td>
					<?=$fid?>
				</td>
				*/ ?>
				
				<td  style="text-align:left;">
					<?php
					$str = chunk_split($allf['tem_fid'], 4, ' ');
					echo $str;
					?>
				</td>
				
				<td style="text-align:left;">
					<?=strtoupper($allf['fname'])?>
					&nbsp;
<?php if($_SESSION['uId']==1 OR $_SESSION['uId']==14 OR $_SESSION['uId']==134){?>
<span onClick="OpenDelete(<?php echo $allf['fid'];?>)" style="text-decoration:underline;color:#158AFF;cursor:pointer;">..</span>
<?php } ?>
				</td>
				<td>
					<?=$allf['contact_1']?>
				</td>
				<td style="text-align:left;">
					<?=strtoupper($allf['father_name'])?>
				</td>
				<td>
					<?=$sarr[$allf['state_id']]?>
				</td>
				<td>
					<?=$darr[$allf['distric_id']]?>
				</td>
				
				<?php /* ?>
				<td>
					<?=$tarr[$allf['tahsil_id']]?>
				</td>
				<td>
					<?=$varr[$allf['village_id']]?>
				</td>
				<?php */ ?>
				
				<td>
					<?php if($allf['doc_passbook']!=''){ ?>
					<a href="JavaScript:void(0);"  onclick="openthis('<?=$allf['doc_passbook']?>')">Passbook</a>

					<?php }if($allf['doc_idproof']!=''){ ?>
					&nbsp;&nbsp;&nbsp;<a href="JavaScript:void(0);" onclick="openthis('<?=$allf['doc_idproof']?>')">ID</a>

					<?php }if($allf['doc_addproof']!=''){ ?>
					&nbsp;&nbsp;&nbsp;<a href="JavaScript:void(0);" onclick="openthis('<?=$allf['doc_addproof']?>')">Address</a>
					<?php }if($allf['doc_aadhar']!=''){ ?>
					&nbsp;&nbsp;&nbsp;<a href="JavaScript:void(0);" onclick="openthis('<?=$allf['doc_aadhar']?>')">Aadhar</a>
					<?php } ?>
				</td>
				
				<td>
	<?php $scrby=mysql_query("select uName from users where uId=".$allf['cr_by']); $rcrby=mysql_fetch_assoc($scrby); 
          echo strtoupper($rcrby['uName']);
?>
				</td>
				
				<td>
					<button id="ebtn<?=$allf['fid']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allf['fid']?>')">Edit</button>
				</td>
				
			</tr>
			
			<?php $sn++;
			 }
			
			} //if($_REQUEST['df']!='' && $_REQUEST['dt']!='') 
			?>	
			</tbody>
		</table>
	</div>
	
	

</div>

<script type="text/javascript">
	function editd(id){
		$('#addfartbl').show(800);
		$('#actiontext').html('&nbsp;Edit Farmer');
		$('#addfarbtn').hide(500);
		$('#addFarmIframe').attr('src','editFarmer.php?fid='+id);
	}

	$(document).ready(function() {
	    $('#tahtable').DataTable();
	    
	} );
	
    /*
	function openthis(file){
		window.open('files/'+file,'Farmer Details', 'width=800, height=600');
	}
	*/
	
	
</script>


<script type="text/javascript">
function openthis(file)
{ 
 var url = "files/"+file; 
 var url2 = "files_2/"+file;
 var url3 = "files_3/"+file;
 var url4 = "files_4/"+file;
 var url5 = "files_5/"+file; 
 
 /*11111111111111111111111111111*/
 
 
 if(url!="") 
 { 
   $.ajax({ url:url, type:'HEAD', 
    error: function()
    {  
	 
	 /*22222222222222222222222222222*/
	 /*22222222222222222222222222222*/
	 if(url2!="") 
     { 
      $.ajax({ url:url2, type:'HEAD', 
       error: function()
       {  
	     /*33333333333333333333333333333*/
		 /*33333333333333333333333333333*/
	     if(url3!="") 
         { 
           $.ajax({ url:url3, type:'HEAD', 
           error: function()
           {  
		     
			 /*4444444444444444444444444444*/
		     /*4444444444444444444444444444*/
	         if(url4!="") 
             { 
              $.ajax({ url:url4, type:'HEAD', 
               error: function()
               {  
			   
			     /*55555555555555555555555555555555555*/
		         /*55555555555555555555555555555555555*/
	             if(url5!="") 
                 { 
                   $.ajax({ url:url5, type:'HEAD', 
                    error: function()
                    {  
			         alert("File doesn't exists");
                    }, 
                    success: function(){ window.open(url5,'Farmer Details', 'width=800, height=600'); } 
                   }); 
  
                 }else{ alert("Please enter File URL"); } 
	             /*55555555555555555555555555555555555*/
		         /*55555555555555555555555555555555555*/
			    
               }, 
               success: function(){ window.open(url4,'Farmer Details', 'width=800, height=600'); } 
              }); 
  
             }else{ alert("Please enter File URL"); } 
	         /*4444444444444444444444444444*/
		     /*4444444444444444444444444444*/
			 
           }, 
           success: function(){ window.open(url3,'Farmer Details', 'width=800, height=600'); } 
          }); 
  
         }else{ alert("Please enter File URL"); } 
	     /*33333333333333333333333333333*/
		 /*33333333333333333333333333333*/
			
       }, 
       success: function(){ window.open(url2,'Farmer Details', 'width=800, height=600'); } 
      }); 
   
     }else{ alert("Please enter File URL"); } 
	 /*22222222222222222222222222222*/
	 /*22222222222222222222222222222*/
	 		
    }, 
    success: function(){ window.open(url,'Farmer Details', 'width=800, height=600'); } 
   }); 
   
 }else{ alert("Please enter File URL"); } 
 
}
</script>





<script type="text/javascript">
	$(document).ready(function(){
		$('#loaderDiv').hide();
	});
</script>