<?php
include 'sidemenu.php';

session_start();
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
		background-color: #EDEDED !important;
		font-size: 16px;
		font-weight: bold;
		padding: 10px !important;
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
	.frminp{
	  padding: 4px !important;
	  height:25px;
	  border-radius: 4px;
	  font-size: 11px;
	  font-weight:550;
	}
	.frmbtn{
	  padding: 2px 4px !important;
	  font-size: 11px;
	}
	body{
		/*background-color: #EDEDED;*/
	}
	.estable thead th,.estable tbody th{
  font-size: 12px !important;
  padding: 1px 2px !important;
  text-align: center;
  font-weight: 500;
  border:2px solid #ccc;
  margin:0px;
}
.estable thead th{
  background-color:#b7e0f4;
  color: #000;
  font-size: 15px;
  font-weight: bold;
  padding: 7px 3px !important;
}

.estable tbody td{
  background-color: #fff !important;
}
label{
	font-size: 12px;
	font-weight: bold;
}
</style>


<div class="pagethings">


	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>
	<?php
	if(isset($_REQUEST['added']) && $_REQUEST['added']=='yes'){
		?>
		<script type="text/javascript">
			$("#savmsg").show(300);
			setTimeout(function(){ $("#savmsg").hide(300);  }, 3000);
		</script>
		<?php
	}
	?>

	<?php
	/*============================================
	here taking all the districts and putting on a array, 
	so in below Tahsil loop we don't have to fetch all states again and again...
	==============================================*/
	$alls=mysql_query('SELECT * FROM `state`');
	while ($allsd=mysql_fetch_assoc($alls)){
		$sarr[$allsd['StateId']]=$allsd['StateName'];

	}

	


	?>

	<form id="farmertable"  enctype="multipart/form-data" method="post" action="mastersAjax.php">
		<input type="hidden" name="act" value="addfarmer">
		<br>
		<table class=" fstable table table-bordered ">
			
			<tbody >
			
			<tr>
				<td colspan="8" class="lightlabel">Aadhar Mandotory Permissions</td>
			</tr>
			<tr>
				<td >
					<table class="estable" style="width: 100%;">
						<thead>
						<tr>
							<th style="width: 200px;">State</th>
							<th style="width: 200px;display: none;">District</th>
							<th style="width: 200px;display: none;">Tahsil</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<div style="height: 500px; overflow: scroll;">
								<?php
								$alls=mysql_query('SELECT a.*,s.StateName FROM `aadhar_permission` a, state s where a.state_id=s.StateId ');
								while ($allsd=mysql_fetch_assoc($alls)){
									?>
									<label  style="width: 100%; text-align:left;<?php if($allsd['permission']=='A'){echo 'background-color: #4CAF50;color:white;';}?>">
										<input  id="chkst<?=$key?>" type="checkbox" name="state" value="<?=$allsd['id']?>" onclick="lstate(this.value,this)" <?php if($allsd['permission']=='A'){echo 'checked';} ?> >
										<?=$allsd['StateName']?>
									</label><br>
									
									<?php
								}
								?>
								</div>
							</td>
							<!-- ===================================================================================
								this div is hided because district permission is said to hide after the code builded, but the districts permission is working fine,if you need to show district just remove display:none below  and also remove the display:none from above <th> tags
							    ===================================================================================== -->
							<!-- <td style="display: none;">
								
								<div id="districtList" style="height: 500px; overflow: scroll;">
									
								</div>
							</td>
							=========================================================================================
								this div is hided because tahsil permission is said to hide after the code builded, but the tahsil permission is working fine,if you need to show tahsil just remove display:none below and also remove the display:none from above <th> tags 
							  	=======================================================================================
							<td style="display: none;">
								
								<div id="tahsilList" style="height: 500px; overflow: scroll;">
									
								</div>
							</td> -->
							
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			
			</tbody>
			
		</table>
	</form>


			

</div>




<script type="text/javascript">
	function closediv(uid){
		$('#editUDiv', window.parent.document).hide(500);
		$('#epbtn'+uid, window.parent.document).show();
		$('#editingbtn'+uid, window.parent.document).hide();
		window.parent.document.getElementById('addfarbtn').style.display='block';
	}
</script>


<!-- this dump div is being used on js lstate function to take js scripts from ajax file  -->
<div id="dump">
	&nbsp;
</div>
<!-- this dump div is being used on js lstate function to take js scripts from ajax file  -->



<script type="text/javascript">

	
	function lstate(sid,sth){
		
		if($(sth).prop("checked") == true){

            $(sth).parent().css("background-color","#4CAF50");
            $(sth).parent().css("color","#fff");
            $.post("mastersAjax.php",{ act:'addAadharPermission',sid:sid},function(data){ });
    //         $.post("mastersAjax.php",{ act:'getStateDistricts',sid:sid,sname:sname,uid:uid },function(data) {
				// $('#districtList').append(data);
	   //      });	
        }else if($(sth).prop("checked") == false){
            $(sth).parent().css("background-color","#fff");
            $(sth).parent().css("color","#000");
            $.post("mastersAjax.php",{ act:'removeAadharPermission',sid:sid},function(data) {
            	
	        });
            

        }
        
	}
	// function ldistrict(did,dth,dname,uid){
	// 	if($(dth).prop("checked") == true){
 //            $(dth).parent().css("background-color","#4CAF50");
 //            $(dth).parent().css("color","#fff");
 //            $.post("mastersAjax.php",{ act:'addlocation',did:did,uid:uid},function(data) {});
 //            $.post("mastersAjax.php",{ act:'getDistrictTahsils',did:did,dname:dname,uid:uid },function(data) {
	// 			$('#tahsilList').append(data);
	//           }
	//         );
 //        }else if($(dth).prop("checked") == false){
 //            $(dth).parent().css("background-color","#fff");
 //            $(dth).parent().css("color","#000");
 //            $.post("mastersAjax.php",{ act:'removelocation',did:did,uid:uid },function(data) {});
 //            $('.ditahs'+did).hide();
 //        }
        
	// }
	// function ltahsil(tid,tth,tname,uid){
	// 	if($(tth).prop("checked") == true){
 //            $(tth).parent().css("background-color","#4CAF50");
 //            $(tth).parent().css("color","#fff");
 //            $.post("mastersAjax.php",{ act:'addlocation',tid:tid,uid:uid },function(data) {});
 //        }else if($(tth).prop("checked") == false){
 //            $(tth).parent().css("background-color","#fff");
 //            $(tth).parent().css("color","#000");
 //            $.post("mastersAjax.php",{ act:'removelocation',tid:tid,uid:uid},function(data) {});
 //        }
        
	// }
</script>



<?php
$sel=mysql_query("SELECT ul.*,s.StateName FROM `user_location` ul, state s where ul.`state_id`!=0 and ul.sts='A' and ul.uid='".$_REQUEST['uid']."' and ul.state_id=s.StateId");
while ($sels=mysql_fetch_assoc($sel)) {
	?>
	<script type="text/javascript">
		$("<?='#chkst'.$sels['state_id']?>").prop("checked",true);
		lstate('<?=$sels['state_id']?>','<?='#chkst'.$sels['state_id']?>','<?=$sels['StateName']?>','<?=$_REQUEST['uid']?>');
	</script>
	<?php
}
?>