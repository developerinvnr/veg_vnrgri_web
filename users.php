<?php
include 'sidemenu.php';
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

<SCRIPT language=Javascript>
<!--
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

 return true;
}
//-->
   </SCRIPT>



<?php
$allp=mysql_query('SELECT * FROM `user_posts`'); 
while ($allpd=mysql_fetch_assoc($allp)){
	$parr[$allpd['upid']]=$allpd['postName'];
}
?>

<?php
$allr=mysql_query("SELECT * FROM `users` where uStatus='A' and uType!='S'"); 
while ($allrd=mysql_fetch_assoc($allr)){
	$rarr[$allrd['uId']]=$allrd['uName'];
}
?>



<div class="pagethings" style="width:82%;">
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<div id="editUDiv" style="display:none;margin-bottom: 10px;padding:2px;background-color:#EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;" id="actiontext"></h6>
		<iframe id="editUIframe" src="addFarmer.php" style="width:1000px;height:600px;"></iframe>
	</div>

	<button id="addubtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addutbl').show(500);$(this).hide(500);">Add User</button>

	<div id="addutbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New User</h6>
		<table class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th>Name <font color="#FF0000">*</font></th>
				<th>Username <font color="#FF0000">*</font></th>
				<th>Password <font color="#FF0000">*</font></th>
				<th>User Type <font color="#FF0000">*</font></th>
				<th>Contact <font color="#FF0000">*</font></th>
				<th>Email</th>
				<th>Post</th>
				<th>Reporting</th>
				<th>Status <font color="#FF0000">*</font></th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<input class="form-control frminp" id="unadd" >
				</td>
				<td>
					<input class="form-control frminp" id="usnadd" >
				</td>
				<td>
					<input class="form-control frminp" id="upwadd" type="password" maxlength="25" style="width:100px;">
				</td>
				<td style="width: 80px;">
					<select id="utadd" class="form-control frminp">
						<option disabled selected value="" >Select</option>
						<!--<option value="S">SuperAdmin</option>-->
						<option value="A">Admin</option>
						<option value="U">User</option>
					</select>
				</td>
				<td>
					<input class="form-control frminp" id="ucadd" onkeypress="return isNumberKey(event)" style="width:80px;" maxlength="10">
				</td>
				<td>
					<input class="form-control frminp" id="ueadd" >
				</td>
				<td>
					
					<select class="form-control frminp"   id="upadd" style="width:120px;" >
						<option disabled selected value="" >Select</option>
						<?php
						$allp=mysql_query('SELECT * FROM `user_posts`');			
						while ($allpd=mysql_fetch_assoc($allp)) {
						?>
					  <option value="<?=$allpd['upid']?>"><?=$allpd['postName']?> </option>
					  	<?php
						}
						?>
					</select>
				</td>
				<td>
					<!-- <input class="form-control frminp" id="uradd" > -->
					<select class="form-control frminp"   id="uradd" style="width:120px;" >
						<option disabled selected value="" >Select</option>
						
						<?php foreach ($rarr as $key => $value) { ?>
						<option value="<?=$key?>" ><?=$value?></option>
						<?php } ?>
					</select>
					
				</td>
				<td>
					<select id="usadd" class="form-control frminp">
						<option value="A">Active</option>
						<option value="D">Deactive</option>
					</select>
				</td>
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addud()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addutbl').hide(500);$('#addubtn').show(500);">Cancel</button>
				</td>
				
			</tr>
			
			<?php $sarr=$_SESSION['sarr'];  ?>
			<?php if($_SESSION['uId']==14 OR $_SESSION['uId']==15){ ?>
			<tr>
			 <td colspan="12">
			  <table style="width:90%;">
			    <tr style="background-color:#B0FFFF; font-weight:bold;">
			  <th>QA Dept</th>
			  <th>State-1</th>
			  <th>State-2</th>
			  <th>State-3</th>
			  <th>State-4</th>
			  <th>State-5</th>
			 </tr>  
			
			 <tr>
			  <td><select id="QADept" class="form-control frminp">
				<option value="N">No</option>
				<option value="Y">Yes</option>
			   </select>
			  </td>
			  <td><select id="Qs1" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>"><?=$value?></option>
				<?php }	?>
			   </select></td>
			  <td><select id="Qs2" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>"><?=$value?></option>
				<?php }	?>
			   </select></td>
			  <td><select id="Qs3" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>"><?=$value?></option>
				<?php }	?>
			   </select></td>
			  <td><select id="Qs4" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>"><?=$value?></option>
				<?php }	?>
			   </select></td>
			  <td><select id="Qs5" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>"><?=$value?></option>
				<?php }	?>
			   </select></td>
			 </tr>
			  </table>
			 </td>
			</tr>   
			<?php }else{ ?>
			 <input type="hidden" id="QADept" value="N" />
			 <input type="hidden" id="Qs1" value="" />
			 <input type="hidden" id="Qs2" value="" />
			 <input type="hidden" id="Qs3" value="" />
			 <input type="hidden" id="Qs4" value="" />
			 <input type="hidden" id="Qs5" value="" />
			<?php } ?>
			
			</tbody>
			
		</table>
		
	</div>

	<div style="margin-bottom: 10px;padding:5px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold; text-align:center;">All Users</h6>
		<table id="userstable"  class=" estable table table-bordered " style="width:100%;">
			<thead>
			<tr>
				<th rowspan="2" style="width:30px;">S.No</th>
				<th rowspan="2">Name <font color="#FF0000">*</font></th>
				<th rowspan="2">Username <font color="#FF0000">*</font></th>
				<th rowspan="2">User Type <font color="#FF0000">*</font></th>
				<th rowspan="2">Contact <font color="#FF0000">*</font></th>
				<th rowspan="2">Email</th>
				<th rowspan="2">Post</th>
				<th rowspan="2">Reporting</th>
				<th rowspan="2">Status <font color="#FF0000">*</font></th>
				<th rowspan="2">Details</th>
				<th colspan="4">Permissions</th>
			</tr>
			<tr>
				<th style="width:50px importenet!;">Crop</th>
				<th style="width:50px importenet!;">Location</th>
				<th style="width:50px importenet!;">Page</th>
				<?php if($_SESSION['uId']==14 OR $_SESSION['uId']==15){ ?>
				<th style="width:50px importenet!;">Pwd</th>
				<?php } ?>
			</tr>
			</thead>
			<tbody>
			<?php

			$sno=1;

//$allu=mysql_query("SELECT * FROM `users` order by uName asc");

			$allu=mysql_query("SELECT * FROM `users` where uType!='S' order by uName asc"); //AND QADept!='Y' 			
			while ($allud=mysql_fetch_assoc($allu)) {
			?>
			<tr>
				<td><?=$sno?></td>
				<td style="text-align:left;">
					<span id="showun<?=$allud['uId']?>"><?=ucwords(strtolower($allud['uName']))?></span>
					<input class="form-control frminp nshw" id="un<?=$allud['uId']?>" value="<?=ucwords(strtolower($allud['uName']))?>">
					
				
				<?php $sarr=$_SESSION['sarr'];  ?>
			<?php if(($_SESSION['uId']==14 OR $_SESSION['uId']==15) && $allud['QADept']=='Y'){ ?>
			<table>
			<tr>
			 <td>
			  <table style="width:90%;">
			    <tr style="background-color:#B0FFFF; font-weight:bold;">
			  <th>QA Dept</th>
			  <th>State-1</th>
			  <th>State-2</th>
			  <th>State-3</th>
			  <th>State-4</th>
			  <th>State-5</th>
			 </tr>  
			
			 <tr>
			  <td><select id="QADept<?=$allud['uId']?>" class="form-control frminp">
				<option value="N" <?php if($allud['QADept']=='N'){echo 'selected';} ?>>No</option>
				<option value="Y" <?php if($allud['QADept']=='Y'){echo 'selected';} ?>>Yes</option>
			   </select>
			  </td>
			  <td><select id="Qs1<?=$allud['uId']?>" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>" <?php if($allud['Qs1']==$key){echo 'selected';} ?>><?=$value?></option>
				<?php }	?>
			   </select></td>
			  <td><select id="Qs2<?=$allud['uId']?>" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>" <?php if($allud['Qs2']==$key){echo 'selected';} ?>><?=$value?></option>
				<?php }	?>
			   </select></td>
			  <td><select id="Qs3<?=$allud['uId']?>" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>" <?php if($allud['Qs3']==$key){echo 'selected';} ?>><?=$value?></option>
				<?php }	?>
			   </select></td>
			  <td><select id="Qs4<?=$allud['uId']?>" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>" <?php if($allud['Qs4']==$key){echo 'selected';} ?>><?=$value?></option>
				<?php }	?>
			   </select></td>
			  <td><select id="Qs5<?=$allud['uId']?>" class="form-control frminp">
				<option value="">Select</option>
				<?php foreach ($sarr as $key => $value) { ?> 
				 <option value="<?=$key?>" <?php if($allud['Qs5']==$key){echo 'selected';} ?>><?=$value?></option>
				<?php }	?>
			   </select></td>
			 </tr>
			  </table>
			 </td>
			</tr>
			</table>   
			<?php }else{ ?>
			 <input type="hidden" id="QADept<?=$allud['uId']?>" value="N" />
			 <input type="hidden" id="Qs1<?=$allud['uId']?>" value="" />
			 <input type="hidden" id="Qs2<?=$allud['uId']?>" value="" />
			 <input type="hidden" id="Qs3<?=$allud['uId']?>" value="" />
			 <input type="hidden" id="Qs4<?=$allud['uId']?>" value="" />
			 <input type="hidden" id="Qs5<?=$allud['uId']?>" value="" />
			<?php } ?>	
					
					
				</td>
				<td style="text-align:left;">
					<span id="showusn<?=$allud['uId']?>"><?=$allud['uUsername']?></span>
					<input class="form-control frminp nshw" id="usn<?=$allud['uId']?>" value="<?=$allud['uUsername']?>">
				</td>
				<td>
					<span id="showut<?=$allud['uId']?>">
						<?php
						if($allud['uType']=='U'){echo 'User';}elseif($allud['uType']=='A'){echo 'Admin';}
						?>
							
					</span>
					<select id="ut<?=$allud['uId']?>" class="form-control frminp nshw">
						<option disabled >Select</option>
						<?php /*?><option value="S" <?=($allud['uType']=='S')?'selected':'';?> >SuperAdmin</option><?php */?>
						<option value="A" <?=($allud['uType']=='A')?'selected':'';?> >Admin</option>
						<option value="U" <?=($allud['uType']=='U')?'selected':'';?> >User</option>
						

					</select>
				</td>
				<td>
					<span id="showuc<?=$allud['uId']?>"><?=$allud['uContact']?></span>
					<input class="form-control frminp nshw" id="uc<?=$allud['uId']?>" onkeypress="return isNumberKey(event)" value="<?=$allud['uContact'];?>" maxlength="10">
				</td>
				<td style="text-align:left;">
					<span id="showue<?=$allud['uId']?>"><?=$allud['uEmail']?></span>
					<input class="form-control frminp nshw" id="ue<?=$allud['uId']?>" value="<?=$allud['uEmail']?>">
				</td>


				<td>
					<span id="showup<?=$allud['uId']?>"><?=ucwords(strtolower($parr[$allud['uPost']]))?></span>
					<!-- <input class="form-control frminp nshw" id="ue<?=$allud['uId']?>" value="<?=$allud['uEmail']?>"> -->
					<select class="form-control frminp nshw"   id="up<?=$allud['uId']?>" style="width:120px;" >
						<option disabled selected value="" >Select</option>
						<?php foreach ($parr as $key => $value) { ?>
						<option value="<?=$key?>" <?php if($key==$allud['uPost']){echo 'selected';} ?> ><?=ucwords(strtolower($value))?></option>
						<?php } ?>
					</select>
				</td>

				<td>
					<span id="showur<?=$allud['uId']?>"><?=ucwords(strtolower($rarr[$allud['uReporting']]))?></span>
					<!-- <input class="form-control frminp nshw" id="ur<?=$allud['uId']?>" value="<?=$allud['uEmail']?>"> -->
					<select class="form-control frminp nshw"   id="ur<?=$allud['uId']?>" style="width:120px;" >
						<option disabled selected value="" >Select</option>
						<?php foreach ($rarr as $key => $value) { 

						if($key!=$allud['uId']){
						?>
						<option value="<?=$key?>" <?php if($key==$allud['uReporting']){echo 'selected';} ?> ><?=ucwords(strtolower($value))?></option>
						<?php } } ?>
					</select>
				</td>


				<td>
					<span id="showus<?=$allud['uId']?>"><?=($allud['uStatus']=='A')?'Active':'Deactive';?></span>
					<select id="us<?=$allud['uId']?>" class="form-control frminp nshw">
						<option disabled >Select</option>
						<option value="A" <?=($allud['uStatus']=='A')?'selected':'';?> >Active</option>
						<option value="D" <?=($allud['uStatus']=='D')?'selected':'';?> >Deactive</option>
					</select>
				</td>
				<td>
					<button id="ebtn<?=$allud['uId']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allud['uId']?>')">Edit</button><?php if($_SESSION['uId']==14){ echo $allud['uId']; }?>
					<button id="sbtn<?=$allud['uId']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allud['uId']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$allud['uId']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allud['uId']?>')" style="display:none;">Cancel</button>
				</td>
				<td>
					<button id="eCropbtn<?=$allud['uId']?>" class="frmbtn btn btn-primary btn-sm editbtnss" onclick="editCrop(this,'<?=$allud['uId']?>')">Edit</button>
					<button id="editingCropbtn<?=$allud['uId']?>" class="frmbtn btn btn-default btn-sm editingbtnss" style="display:none;" >Editing</button>
				</td>
				<td>
					<button id="epbtn<?=$allud['uId']?>" class="frmbtn btn btn-primary btn-sm editbtnss" onclick="editloc(this,'<?=$allud['uId']?>')">Edit</button>
					<button id="editingbtn<?=$allud['uId']?>" class="frmbtn btn btn-default btn-sm editingbtnss" style="display:none;" >Editing</button>
				</td>
				<td>
					<button id="ePgbtn<?=$allud['uId']?>" class="frmbtn btn btn-primary btn-sm editbtnss" onclick="editpag(this,'<?=$allud['uId']?>')">Edit</button>
					<button id="editingPgbtn<?=$allud['uId']?>" class="frmbtn btn btn-default btn-sm editingbtnss" style="display:none;" >Editing</button>
					
				</td>
				
				<?php if($_SESSION['uId']==14 OR $_SESSION['uId']==15){ ?>
				<td>
					<button id="ePwdbtn<?=$allud['uId']?>" class="frmbtn btn btn-primary btn-sm editbtnss" onclick="editpwd(this,'<?=$allud['uId']?>')">Edit</button>
					<button id="editingPwdbtn<?=$allud['uId']?>" class="frmbtn btn btn-default btn-sm editingbtnss" style="display:none;" >Editing</button>
					
				</td>
				<?php } ?>
			</tr>
			
			<?php
			$sno++;
			}
			?>	
			</tbody>
		</table>
	</div>
	
	

</div>

<script type="text/javascript">
	function editd(id){
		$('#showun'+id).hide();
		$('#showusn'+id).hide();
		$('#showut'+id).hide();
		$('#showuc'+id).hide();
		$('#showue'+id).hide();
		$('#showus'+id).hide();
		$('#showup'+id).hide();
		$('#showur'+id).hide();

		$('#un'+id).show();
		$('#usn'+id).show();
		$('#ut'+id).show();
		$('#uc'+id).show();
		$('#ue'+id).show();
		$('#us'+id).show();
		$('#up'+id).show();
		$('#ur'+id).show();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}
	function cancd(id){
		$('#showun'+id).show();
		$('#showusn'+id).show();
		$('#showut'+id).show();
		$('#showuc'+id).show();
		$('#showue'+id).show();
		$('#showus'+id).show();
		$('#showup'+id).show();
		$('#showur'+id).show();

		$('#un'+id).hide();
		$('#usn'+id).hide();
		$('#ut'+id).hide();
		$('#uc'+id).hide();
		$('#ue'+id).hide();
		$('#us'+id).hide();
		$('#up'+id).hide();
		$('#ur'+id).hide();

        $('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
	}

	function saved(id){
		var un  = $('#un'+id).val();
		var usn = $('#usn'+id).val();
		var ut  = $('#ut'+id).val();
		var uc  = $('#uc'+id).val();
		var ue  = $('#ue'+id).val();
		var us  = $('#us'+id).val();
		var up  = $('#up'+id).val();
		var ur  = $('#ur'+id).val();
		
		var QADept  = $('#QADept'+id).val(); //alert(QADept);
		var Qs1  = $('#Qs1'+id).val();
		var Qs2  = $('#Qs2'+id).val();
		var Qs3  = $('#Qs3'+id).val();
		var Qs4  = $('#Qs4'+id).val();
		var Qs5  = $('#Qs5'+id).val();
		
		if(un==''){ alert("enter name of user"); return false; }
		if(usn==''){ alert("enter user username"); return false; }
		if(uc==''){ alert("enter user contact number"); return false; }
		
		if(ue!='')
		{
		 var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
         if(!filter.test(ue)){ alert('Invalid Email Address'); return false; }
		}

		$.post("mastersAjax.php",{ act:'saveUserDetails',un:un,usn:usn,ut:ut,uc:uc,ue:ue,us:us,id:id,up:up,ur:ur,QADept:QADept,Qs1:Qs1,Qs2:Qs2,Qs3:Qs3,Qs4:Qs4,Qs5:Qs5 },function(data) {

			// console.log(data);
                        
			if(data.includes("updated")){

				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = "<?=basename($_SERVER['PHP_SELF'])?>";  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
			$('#ebtn'+id).show();
			$('#sbtn'+id).hide();
			$('#cbtn'+id).hide();

          }
        );
		
	}


	function addud(){
		var unadd  = $('#unadd').val();
		var usnadd = $('#usnadd').val();
		var upwadd = $('#upwadd').val();
		var utadd  = $('#utadd').val();
		var ucadd  = $('#ucadd').val();
		var ueadd  = $('#ueadd').val();
		var usadd  = $('#usadd').val();
		var upadd  = $('#upadd').val();
		var uradd  = $('#uradd').val();
		
        var QADept  = $('#QADept').val();
		var Qs1  = $('#Qs1').val();
		var Qs2  = $('#Qs2').val();
		var Qs3  = $('#Qs3').val();
		var Qs4  = $('#Qs4').val();
		var Qs5  = $('#Qs5').val();


		if(unadd==''){ alert("enter name of user"); return false; }
		if(usnadd==''){ alert("enter user username"); return false; }
		if(upwadd==''){ alert("enter user password"); return false; }
		if(ucadd==''){ alert("enter user contact number"); return false; }
		
		if(ueadd!='')
		{
		 var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
         if(!filter.test(ueadd)){ alert('Invalid Email Address'); return false; }
		}

		$.post("mastersAjax.php",{ act:'addUser',unadd:unadd , usnadd:usnadd ,upwadd:upwadd , utadd:utadd , ucadd:ucadd , ueadd:ueadd , usadd:usadd, upadd:upadd,uradd:uradd,QADept:QADept,Qs1:Qs1,Qs2:Qs2,Qs3:Qs3,Qs4:Qs4,Qs5:Qs5 },function(data) {
                                                    
			if(data.includes("added")){
				$('#addutbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = '<?=basename($_SERVER['PHP_SELF'])?>';  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}

			
          }
        );
		
	}

	function editCrop(th,id){
		$('.editingbtnss').hide(500);
		$('.editbtnss').show(500);
		$(th).hide(500);
		$('#editUDiv').show(500);
		$('#editingCropbtn'+id).show(500);
		$('#editUIframe').attr('src','editCropPermission.php?uid='+id);
	}

	function editloc(th,id){
		$('.editingbtnss').hide(500);
		$('.editbtnss').show(500);
		$(th).hide(500);
		$('#editUDiv').show(500);
		$('#editingbtn'+id).show(500);
		$('#editUIframe').attr('src','editLocationPermission.php?uid='+id);
	}

	function editpag(th,id){
		$('.editingbtnss').hide(500);
		$('.editbtnss').show(500);
		$(th).hide(500);
		$('#editUDiv').show(500);
		$('#editingPgbtn'+id).show(500);
		$('#editUIframe').attr('src','editPagePermission.php?uid='+id);
	}
	
	function editpwd(th,id){
		$('.editingbtnss').hide(300);
		$('.editbtnss').show(300);
		$(th).hide(300);
		$('#editUDiv').show(300);
		$('#editingPwdbtn'+id).show(300);
		$('#editUIframe').attr('src','editUpwd.php?uid='+id);
	}
	
	$(document).ready(function() {
	    $('#userstable').DataTable();
	} );
</script>


