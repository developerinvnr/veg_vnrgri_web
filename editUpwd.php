<?php 
include 'cdns.php'; 
include 'config.php'; 
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
		background-color: #EDEDED;
	}
	.estable thead th,.estable tbody th{
	  font-size: 12px !important;
	  padding: 1px 2px !important;
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
		cursor: pointer;
		padding-left:10px;
	}
</style>
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
$us=mysql_query('SELECT * FROM `users` where uId='.$_REQUEST['uid']);
$usd=mysql_fetch_assoc($us);
?>
	
	<input type="hidden" name="uuId" id="uuId" value="<?=$_REQUEST['uid']?>">
	<table class=" fstable table table-bordered">
		
		<tbody >
		<tr>
			<td colspan="8"><font style="font-weight:bold;"><?=$usd['uName']?></font>&nbsp;&nbsp;<font class="lightlabel">User Password Change</font></td>
		</tr>
		<tr>
		 <td style="height:50px;">&nbsp;</td>
		</tr>
		<tr>
			<td>
				<table class="estable">
					<tbody>
					
					 <tr>

      <td>

        <div id="chngpwddiv" style="display: block;">

          <input type="password" id="newpass" placeholder="New Password"><br>

          <input type="password" id="cnewpass" placeholder="Confirm New Password"><br>

          

          <button class="btn btn-sm btn-primary frmbtn" onclick="save22pass()" style="float:right;">Save</button>
		  
        </div>

      </td>

    </tr>
					</tbody>
				</table>
			</td>
		</tr>
		
		</tbody>
		
	</table>
</form>

<button type="button" class="frmbtn btn btn-sm btn-danger" style="width:100px;position: absolute;top:4px;right: 4px;" onclick="closediv('<?=$_REQUEST['uid']?>')"  >Close</button>
				</center>
<script type="text/javascript">
	function closediv(uid){
		$('#editUDiv', window.parent.document).hide(300);
		$('#epbtn'+uid, window.parent.document).show();
		$('#editingbtn'+uid, window.parent.document).hide();
	}
</script>



<script type="text/javascript">

function save22pass(){
  var newpass = $('#newpass').val();
  var cnewpass = $('#cnewpass').val();
  var uuId = $('#uuId').val();
  
  if(newpass==cnewpass)
  {
    $.post("editUpwdAjax.php",{ act:'save22Pass',newpass:newpass,uuId:uuId},function(data) 
	{ 
      if(data.includes("updatedd"))
	  { 
	   alert('Password Changed Successfully! \n\n\n');    
      }
	  else if(data.includes("errorr"))
	  {
        alert('Something went wrong! \n Please try again after sometime. \n\n\n');
      }
    });
  }
  else
  {
    alert('New Passwords not matched! \n Please enter same password. \n\n\n');    
  }
}
</script>


