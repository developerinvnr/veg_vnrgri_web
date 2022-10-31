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

<div class="pagethings">
	
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<button id="addcrbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addcrtbl').show(500);$(this).hide(500);">Add Post</button>

	<div id="addcrtbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New Post</h6>
		<table class=" estable table table-bordered">
			<thead>
			<tr>
				<th>Post Name</th>
				<th>Post Short Name</th>
				<th style="width:100px;">Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<input class="form-control frminp" id="crn" >
				</td>
				<td>
					<input class="form-control frminp" id="crc" >
				</td>
				
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addcr()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addcrtbl').hide(500);$('#addcrbtn').show(500);" >Cancel</button>
				</td>
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;height: 500px;width:595px;overflow:scroll;">
		<h6 style="font-weight: bold;">All Posts</h6>
		<table id="Posttable" class=" estable table table-bordered">
			<thead>
			<tr>
				<th>Post Name</th>
				<th>Post Short Name</th>
				<th style="width:100px;">Action</th>

			</tr>
			</thead>
			<tbody>
			<?php
			$allp=mysql_query('SELECT * FROM `user_posts` order by postName asc');

			while ($allpd=mysql_fetch_assoc($allp)) {
			?>
			<tr>
				<td>
					<span id="showcrn<?=$allpd['upid']?>" style="float: left;"><?=$allpd['postName']?></span>
					<input class="form-control frminp nshw" id="crn<?=$allpd['upid']?>"  value="<?=$allpd['postName']?>" >
				</td>
				<td>
					<span id="showcrc<?=$allpd['upid']?>" ><?=$allpd['postShortName']?></span>
					<input class="form-control frminp nshw" id="crc<?=$allpd['upid']?>"  value="<?=$allpd['postShortName']?>" >
				</td>
				<td>
					<button id="ebtn<?=$allpd['upid']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allpd['upid']?>')">Edit</button>
					<button id="sbtn<?=$allpd['upid']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allpd['upid']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$allpd['upid']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allpd['upid']?>')" style="display:none;">Cancel</button>
				</td>
			</tr>
			
			<?php
			}
			?>	
			</tbody>
		</table>
	</div>
	
	

</div>

<script type="text/javascript">
	function editd(id){
		$('#showcrn'+id).hide();
		$('#showcrc'+id).hide();

		$('#crn'+id).show();
		$('#crc'+id).show();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){
		$('#showcrn'+id).show();
		$('#showcrc'+id).show();

		$('#crn'+id).hide();
		$('#crc'+id).hide();

		$('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
	}

	function saved(id){
		var crn  = $('#crn'+id).val();
		var crc  = $('#crc'+id).val();
		
		if(crn==''){ alert("enter Post name"); return false; }
		if(crc==''){ alert("enter Post code"); return false; }

		$.post("mastersAjax.php",{ act:'savePostDetails',crn:crn , crc:crc ,id:id },function(data) {
                          
			if(data.includes("updated")){
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = "<?=basename($_SERVER['PHP_SELF'])?>";  }, 800);
			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
			$('#ebtn'+id).show();
			$('#sbtn'+id).hide();
			$('#cbtn'+id).hide();
        });		
	}


	function addcr(){
		var crn  = $('#crn').val();
		var crc = $('#crc').val();

        if(crn==''){ alert("enter Post name"); return false; }
		if(crc==''){ alert("enter Post code"); return false; }
		
		$.post("mastersAjax.php",{ act:'addPost',crn:crn,crc:crc },function(data) {
                                                    
			if(data.includes("added")){
				$('#addcrtbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = '<?=basename($_SERVER['PHP_SELF'])?>';  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
        });
	}


	function editp(th,id){
		$(th).hide();
		$('#spbtn'+id).show();
		$('#pertr'+id).show();

	}

	$(document).ready(function() {
	    $('#Posttable').DataTable();
	} );
</script>


