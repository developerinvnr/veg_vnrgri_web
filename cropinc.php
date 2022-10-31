<?php
 include 'sidemenu.php'; $y=base64_decode($_REQUEST['v']);
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
<script type="text/javascript">
function ClickY(v){ window.location="cropinc.php?v="+v; }
function selcrop(v)
{ 
 $.post("mastersAjaxx.php",{ act:'findvariety',crop:v },
   function(data)
   { 
    //alert(data);
    $('#hybname').html(data);
   }
  );
}
function sel2crop(v,id)
{ 
 $.post("mastersAjaxx.php",{ act:'findvariety',crop:v },
   function(data)
   { 
    $('#hybname'+id).html(data);
   }
  );
}

function selVariety(v)
{
  $.post("mastersAjaxx.php",{ act:'findpcode',prod:v },
   function(data)
   { 
    //alert(data);
    $('#prodcode').val(data);
   }
  );
}
</script>
<SCRIPT language=Javascript>
<!--Only Number
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))          
   return false;
 return true;
}


function isNumberFKey(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
   return false;

  return true;
}
//-->

<!-- Only Number & decin
function valifloat(v)
{
  v.val($this.val().replace(/[^\d.]/g, '')); 
}
</script>


<div class="pagethings" style="width:80%;">
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

<button id="addstbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addsttbl').show();$(this).hide();">Add New</button>

<div id="addsttbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc; text-align:center;">
		<h6 style="font-weight: bold;">New</h6>
		<table class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
			<th rowspan="2" style="width: 150px !important;">Crop Name <font style="color:#FF0000;">*</font></th>
			<th rowspan="2" style="width: 150px !important;">Hybrid Name <font style="color:#FF0000;">*</font></th>
			<th rowspan="2" style="width: 50px !important;">Production<br>Code <font style="color:#FF0000;">*</font></th>
			<!-- <th colspan="2">SP Code Female</th>
			<th colspan="2">SP Code male</th> -->
			<th rowspan="2" style="width: 50px !important;">Type</th>
			<th rowspan="2" style="width: 60px !important;">Estimated Yield/Acre</th>
			<th colspan="3">In Rs./Kg of Processed Seed<br>[Genetic Purity (%)]</th>
			<th rowspan="2" style="width:80px !important;">Action</th>
			</tr>
			<tr>
			<!-- <th style="width: 50px !important;">Code</th>
			<th style="width: 50px !important;">Num.</th>
			<th style="width: 50px !important;">Code</th>
			<th style="width: 50px !important;">Num.</th> -->
			<th>100%</th>
			<th>98-99.99%</th>
			<th>96-97.99%</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<select id="crop" class="form-control frminp" onChange="selcrop(this.value)">
					<option value="">SELECT</option>
					<?php $sc=mysql_query("select * from crop order by cropname asc"); while($rc=mysql_fetch_assoc($sc)){?>	                    <option value="<?=$rc['cropid'];?>"><?=$rc['cropname'];?></option><?php } ?>
					</select>
				</td>
				<td>
				   <span id="hybnamespan"></span>
				   <select id="hybname" class="form-control frminp" onchange="selVariety(this.value)">
				    <option value="">SELECT</option>
				   </select>
				</td>
				<td><input id="prodcode" class="form-control frminp" style="text-transform:uppercase;"></td>


				<!-- 
				<td><input class="form-control frminp" id="f1" maxlength="5" onkeyup="odeve()" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" style="text-transform:uppercase;"></td>
				<td><input class="form-control frminp" id="f2" onkeyup="odeve()" onKeyPress="return isNumberKey(event)" maxlength="5"></td>
				<td><input class="form-control frminp" id="m1" maxlength="5" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" style="text-transform:uppercase;"></td>
				<td><input class="form-control frminp" id="m2" onkeyup="odeve()" onKeyPress="return isNumberKey(event)" maxlength="5"></td>
				 -->



				<td>
					<select id="type" class="form-control frminp"  style="width:80px;">
					 <option value="HYB">HYB</option><option value="OP">OP</option>
					</select> 
				</td>
				<td><input class="form-control frminp" id="estyield" maxlength="10" onKeyPress="return isNumberFKey(event)"></td>
				<td><input class="form-control frminp" id="gp1" maxlength="5" onKeyPress="return isNumberFKey(event)"></td>
				<td><input class="form-control frminp" id="gp2" maxlength="5" onKeyPress="return isNumberFKey(event)"></td>
				<td><input class="form-control frminp" id="gp3" maxlength="5" onKeyPress="return isNumberFKey(event)"></td>
				
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addst()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addsttbl').hide();$('#addstbtn').show();" >Cancel</button>
				</td>
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addsttbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll; text-align:center;">
		<h6 style="font-weight: bold;">Crop Production Code & Quality Based Incentive</h6>
		
		<table id="statetable" class="estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
			<th rowspan="2" style="width: 150px !important;">
			<input type="hidden" id="yearno" value="<?=$y;?>" /> 
			<input type="hidden" id="year2no" value="<?=$_REQUEST['v'];?>" />
			<select class="form-control frminp" style="width:100px; background-color:#CDFF9B;" onChange="ClickY(this.value)"><option value="<?=$_REQUEST['v'];?>" selected="selected"><?=$y;?></option><?php $sy=mysql_query('SELECT yearno FROM `master_fsqc_transaction` group by yearno order by yearno desc');	$rowy=mysql_num_rows($sy); while($ry=mysql_fetch_assoc($sy)){ ?><option value="<?=base64_encode($ry['yearno']);?>" <?php if($ry['yearno']==$y){echo 'selected';} ?>><?=$ry['yearno'];?></option><?php } if($rowy==0){ ?><option value="<?=base64_encode($y);?>"><?=$y;?></option><?php } ?></select><br>Crop Name <font style="color:#FF0000;">*</font></th>
			<th rowspan="2" style="width: 150px !important;">Hybrid Name <font style="color:#FF0000;">*</font></th>
			<th rowspan="2" style="width: 50px !important;">Production<br>Code <font style="color:#FF0000;">*</font></th>
			<!-- <th colspan="2">SP Code Female</th>
			<th colspan="2">SP Code male</th> -->
			<th rowspan="2" style="width: 50px !important;">Type</th>
			<th rowspan="2" style="width: 60px !important;">Estimated<br>Yield/Acre</th>
			<th colspan="3">In Rs./Kg of Processed Seed<br>[Genetic Purity (%)]</th>
			<th rowspan="2" style="width:80px !important;">Action</th>
			</tr>
			<tr>
			<!-- <th style="width: 50px !important;">Code</th>
			<th style="width: 50px !important;">Num.</th>
			<th style="width: 50px !important;">Code</th>
			<th style="width: 50px !important;">Num.</th> -->
			<th>100%</th>
			<th>98-99.99%</th>
			<th>96-97.99%</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$alls=mysql_query('SELECT qc.*,cropname FROM `master_fsqc_transaction` qc inner join crop c on qc.cropid=c.cropid where yearno='.$y.' order by cropname asc, varietyid asc ');
			while($allsd=mysql_fetch_assoc($alls)) {
			?>
			<tr>
				<td>
					<span id="showcrop<?=$allsd['trid']?>" style="float: left;"><?=$allsd['cropname'];?></span>
					<select id="crop<?=$allsd['trid']?>" class="form-control frminp nshw" onChange="sel2crop(this.value,<?=$allsd['trid']?>)">
						<?php $sc=mysql_query("select * from crop order by cropname asc"); while($rc=mysql_fetch_assoc($sc)){?>	                    <option value="<?=$rc['cropid'];?>" <?php if($rc['cropid']==$allsd['cropid']){echo 'selected';} ?>><?=$rc['cropname'];?></option><?php } ?>
					</select>
					
				</td>
				
				<td> 
				    <?php $sv=mysql_query("select varietyname from variety where varietyid=".$allsd['varietyid']); 
					$rv=mysql_fetch_assoc($sv);?>
					<span id="showhybname<?=$allsd['trid']?>" style="float:left;"><?=$rv['varietyname'];?></span>
					<select id="hybname<?=$allsd['trid']?>" class="form-control frminp nshw">	                   
					 <option value="<?=$allsd['varietyid'];?>"><?=$rv['varietyname'];?></option>
					</select>
				</td>
				
				<td>
					<span id="showprodcode<?=$allsd['trid']?>"><?=$allsd['production_code'];?></span>
				<input class="form-control frminp nshw" id="prodcode<?=$allsd['trid']?>" value="<?=$allsd['production_code']?>" style="text-transform:uppercase;">
				</td>




				<!-- 
				<td>
					<span id="showf1<?=$allsd['trid']?>"><?=$allsd['spcode_f1'];?></span>
					<input class="form-control frminp nshw" id="f1<?=$allsd['trid']?>" value="<?=$allsd['spcode_f1']?>" maxlength="5" onkeyup="odeve2(<?=$allsd['trid']?>)" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" style="text-transform:uppercase;">
				</td>
				<td>
					<span id="showf2<?=$allsd['trid']?>"><?=$allsd['spcode_f2'];?></span>
					<input class="form-control frminp nshw" id="f2<?=$allsd['trid']?>" onkeyup="odeve2(<?=$allsd['trid']?>)" value="<?=$allsd['spcode_f2']?>" maxlength="5" onKeyPress="return isNumberKey(event)">
				</td>
				<td>
					<span id="showm1<?=$allsd['trid']?>"><?=$allsd['spcode_m1'];?></span>
					<input class="form-control frminp nshw" id="m1<?=$allsd['trid']?>" value="<?=$allsd['spcode_m1']?>" maxlength="5" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" style="text-transform:uppercase;">
				</td>
				<td>
					<span id="showm2<?=$allsd['trid']?>"><?=$allsd['spcode_m2'];?></span>
					<input class="form-control frminp nshw" id="m2<?=$allsd['trid']?>" onkeyup="odeve2(<?=$allsd['trid']?>)" value="<?=$allsd['spcode_m2']?>" maxlength="5" onKeyPress="return isNumberKey(event)">
				</td>

				 -->




				
				<td style="text-align:center;">
				    <span id="showtype<?=$allsd['trid']?>"><?=$allsd['type'];?></span>
					<select id="type<?=$allsd['trid']?>" class="form-control frminp nshw" >
					 <option value="HYB" <?php if($allsd['type']=='HYB'){echo 'selected';} ?>>HYB</option><option value="OP" <?php if($allsd['type']=='OP'){echo 'selected';} ?>>OP</option>
					</select>
				</td>
				<td style="text-align:center;">
					<span id="showestyield<?=$allsd['trid']?>"><?=floatval($allsd['estimated_yield']);?></span>
					<input class="form-control frminp nshw" id="estyield<?=$allsd['trid']?>" value="<?=$allsd['estimated_yield']?>" maxlength="10" onKeyPress="return isNumberFKey(event)">
				</td>

				<td style="text-align:center;">
					<span id="showgp1<?=$allsd['trid']?>"><?=floatval($allsd['genetic_purity1']);?></span>
					<input class="form-control frminp nshw" id="gp1<?=$allsd['trid']?>" value="<?=$allsd['genetic_purity1']?>" maxlength="5" onKeyPress="return isNumberFKey(event)">
				</td>
				<td style="text-align:center;">
					<span id="showgp2<?=$allsd['trid']?>"><?=floatval($allsd['genetic_purity2']);?></span>
					<input class="form-control frminp nshw" id="gp2<?=$allsd['trid']?>" value="<?=$allsd['genetic_purity2']?>" maxlength="5" onKeyPress="return isNumberFKey(event)">
				</td>
				<td style="text-align:center;">
					<span id="showgp3<?=$allsd['trid']?>"><?=floatval($allsd['genetic_purity3']);?></span>
					<input class="form-control frminp nshw" id="gp3<?=$allsd['trid']?>" value="<?=$allsd['genetic_purity3']?>" maxlength="5" onKeyPress="return isNumberFKey(event)">
				</td>
				
				
				<td>
					<button id="ebtn<?=$allsd['trid']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allsd['trid']?>')">Edit</button>
					<button id="sbtn<?=$allsd['trid']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allsd['trid']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$allsd['trid']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allsd['trid']?>')" style="display:none;">Cancel</button>
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
		$('#showcrop'+id).hide();
		$('#showhybname'+id).hide();
		$('#showprodcode'+id).hide();
		$('#showf1'+id).hide();
		$('#showf2'+id).hide();
		$('#showm1'+id).hide();
		$('#showm2'+id).hide();
		$('#showtype'+id).hide();
		$('#showestyield'+id).hide();
		$('#showgp1'+id).hide();
		$('#showgp2'+id).hide();
		$('#showgp3'+id).hide();
		
		$('#crop'+id).show();
		$('#hybname'+id).show();
		$('#prodcode'+id).show();
		$('#f1'+id).show();
		$('#f2'+id).show();
		$('#m1'+id).show();
		$('#m2'+id).show();
		$('#type'+id).show();
		$('#estyield'+id).show();
		$('#gp1'+id).show();
		$('#gp2'+id).show();
		$('#gp3'+id).show();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){
		$('#showcrop'+id).show();
		$('#showhybname'+id).show();
		$('#showprodcode'+id).show();
		$('#showf1'+id).show();
		$('#showf2'+id).show();
		$('#showm1'+id).show();
		$('#showm2'+id).show();
		$('#showtype'+id).show();
		$('#showestyield'+id).show();
		$('#showgp1'+id).show();
		$('#showgp2'+id).show();
		$('#showgp3'+id).show();

		$('#crop'+id).hide();
		$('#hybname'+id).hide();
		$('#prodcode'+id).hide();
		$('#f1'+id).hide();
		$('#f2'+id).hide();
		$('#m1'+id).hide();
		$('#m2'+id).hide();
		$('#type'+id).hide();
		$('#estyield'+id).hide();
		$('#gp1'+id).hide();
		$('#gp2'+id).hide();
		$('#gp3'+id).hide();

		$('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
		
	}
	
	function odeve()
	{
	  $('#m1').val($('#f1').val());
	  var f2 = $('#f2').val();
	  var m2 = $('#m2').val();
	  
	  if(f2!='' && m2!='')
	  {
		if(f2==m2){ $('#type').val('OP'); }
		else{ $('#type').val('HYB'); }
	  }
	}
	
	function odeve2(id)
	{
	  $('#m1'+id).val($('#f1'+id).val());
	  var f2 = $('#f2'+id).val();
	  var m2 = $('#m2'+id).val();
	  if(f2!='' && m2!='')
	  {
		if(f2==m2){ $('#type'+id).val('OP'); }
		else{ $('#type'+id).val('HYB'); }
	  }
	}

	function saved(id){
	    var crop = $('#crop'+id).val();
		var hybname = $('#hybname'+id).val();
		var prodcode = $('#prodcode'+id).val();
		var f1 = $('#f1'+id).val();
		var f2 = $('#f2'+id).val();
		var m1 = $('#m1'+id).val();
		var m2 = $('#m2'+id).val();
		var type = $('#type'+id).val();
		var estyield = $('#estyield'+id).val();
		var gp1 = $('#gp1'+id).val();
		var gp2 = $('#gp2'+id).val();
		var gp3 = $('#gp3'+id).val();
		var yearno = $('#yearno').val();
		var year2no = $('#year2no').val();
		
		if(crop==''){ alert("select crop name"); return false; }
		if(hybname==''){ alert("select hybrid name"); return false; }
		if(prodcode==''){ alert("enter production code"); return false; }
		
		$.post("mastersAjaxx.php",{ act:'saveQCICDetails',crop:crop, hybname:hybname, prodcode:prodcode, f1:f1, f2:f2, m1:m1, m2:m2, type:type, estyield:estyield, gp1:gp1, gp2:gp2, gp3:gp3, yearno:yearno, id:id},function(data) { 
                          
			if(data.includes("updated")){
				
				$("#savmsg").show(300);
				setTimeout(function(){ window.location='cropinc.php?v='+year2no;  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
			$('#ebtn'+id).show();
			$('#sbtn'+id).hide();
			$('#cbtn'+id).hide();
          }
        );

		
	}


	function addst(){ 
		var crop = $('#crop').val();
		var hybname = $('#hybname').val();
		var prodcode = $('#prodcode').val();
		var f1 = $('#f1').val();
		var f2 = $('#f2').val();
		var m1 = $('#m1').val();
		var m2 = $('#m2').val();
		var type = $('#type').val();
		var estyield = $('#estyield').val();
		var gp1 = $('#gp1').val();
		var gp2 = $('#gp2').val();
		var gp3 = $('#gp3').val();
		var yearno = $('#yearno').val();
		var year2no = $('#year2no').val(); //alert(year2no);
		
		if(crop==''){ alert("select crop name"); return false; }
		if(hybname==''){ alert("select hybrid name"); return false; }
		if(prodcode==''){ alert("enter production code"); return false; }

		$.post("mastersAjaxx.php",{ act:'addQCIC',crop:crop, hybname:hybname, prodcode:prodcode, f1:f1, f2:f2, m1:m1, m2:m2, type:type, estyield:estyield, gp1:gp1, gp2:gp2, gp3:gp3, yearno:yearno},function(data) { //alert(data);
                                                  
			if(data.includes("added")){
				$('#addsttbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location='cropinc.php?v='+year2no; }, 800);
	
		
				

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}

			
          }
        );
		
	}


	

	function editp(th,id){
		$(th).hide();
		$('#spbtn'+id).show();
		$('#pertr'+id).show();

	}

	$(document).ready(function() {
	    $('#statetable').DataTable();
	} );
</script>


