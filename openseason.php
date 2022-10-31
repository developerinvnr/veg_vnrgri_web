<?php

include 'sidemenu.php';



if(isset($_POST['sbtn']))

{

 $sql=mysql_query("update view_season set Kharif='".$_POST['vKharif']."', Rabi='".$_POST['vRabi']."', Summer='".$_POST['vSummer']."' where SesId=1");

 if($sql){echo '<script>window.location="openseason.php?sts=y";</script>';}

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



</style>



<div class="pagethings">

	

		

	<div id="savmsg" class="alert alert-success frminp" style="display:<?php if($_REQUEST['sts']=='y'){echo 'block';}else{echo 'none';}?>;">update Successfully!</div>



	<div id="addcrtbl" style="margin-bottom: 10px; text-align:center;padding:5px;background-color: #EDEDED;border:2px solid #ccc;height: 200px;width:595px;overflow:scroll;">

		<h6 style="font-weight: bold;">Open Season</h6>

		<table id="croptable" class=" estable table table-bordered">

			<thead>

			 <tr>

			  <th style="width:120px;">Kharif</th>
			  <th style="width:120px;">Rabi</th>
			  <th style="width:120px;">Summer</th>
			  <th style="width:100px;">Action</th>

			 </tr>

			</thead>

			<tbody>

			<?php $allcr=mysql_query('SELECT * FROM view_season where SesId=1'); $allcrd=mysql_fetch_assoc($allcr); ?>

			<form method="post" name="sf">

			<tr>

				<td style="text-align:center;vertical-align:middle;">

					<input type="checkbox" name="season1" id="season1" onclick="FunKRS(1)" <?php if($allcrd['Kharif']=='Y'){echo 'checked';} ?> disabled>

				    <input type="hidden" name="vKharif" id="vses1" value="<?=$allcrd['Kharif']?>" >

				</td>

				<td style="text-align:center;vertical-align:middle;">

				  <input type="checkbox" name="season2" id="season2" onclick="FunKRS(2)" value="<?=$allcrd['Rabi']?>" <?php if($allcrd['Rabi']=='Y'){echo 'checked';} ?> disabled>

				  <input type="hidden" name="vRabi" id="vses2" value="<?=$allcrd['Rabi']?>" >

				</td>
				
				<td style="text-align:center;vertical-align:middle;">

				  <input type="checkbox" name="season3" id="season3" onclick="FunKRS(3)" value="<?=$allcrd['Summer']?>" <?php if($allcrd['Summer']=='Y'){echo 'checked';} ?> disabled>

				  <input type="hidden" name="vSummer" id="vses3" value="<?=$allcrd['Summer']?>" >

				<td>

				 <input type="button" id="ebtn" class="frmbtn btn btn-primary btn-sm" onclick="editd()" value="edit" />

				 <input type="submit" id="sbtn" name="sbtn" class="frmbtn btn btn-success btn-sm" value="save" style="display:none;"/>

				 <input type="button" id="cbtn" class="frmbtn btn btn-sm btn-danger" onclick="cancd()" value="cancel" style="display:none;"/>

				</td>

			</tr>

			</form>	

			</tbody>

		</table>

	</div>

	

	



</div>



<script type="text/javascript">

    function FunKRS(v)
	{
	 if(document.getElementById("season"+v).checked==true){ document.getElementById("vses"+v).value='Y'; }
	 else { document.getElementById("vses"+v).value='N'; }
	}


	function editd(){ 
	 document.getElementById("season1").disabled=false;
	 document.getElementById("season2").disabled=false;
	 document.getElementById("season3").disabled=false;

	 $('#ebtn').hide();

	 $('#sbtn').show();

	 $('#cbtn').show();

	}



	function cancd(id){

	 document.getElementById("Kharif").disabled=true;

	 document.getElementById("Rabi").disabled=true;

	 $('#ebtn').show();

	 $('#sbtn').hide();

	 $('#cbtn').hide();

	}

</script>





