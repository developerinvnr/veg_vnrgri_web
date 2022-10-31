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


	.ftable thead th,.ftable tbody th,.ftable tbody td{
	  font-size: 12px !important;
	  padding: 1px 2px !important;
	  text-align: center;
	  font-weight: 500;
	  border:2px solid #ccc;
	  margin:0px;
	}
	.ftable thead th{
	  background-color:#b7e0f4;
	  color: #000;
	  font-size: 13px;
	  font-weight: bold;
	  padding: 7px 3px !important;
	}

	.ftable tbody td{
	  background-color: #fff !important;
	}

</style>

<div class="pagethings">
	

	<div id="addcrtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;height: 500px;width:900px;overflow:scroll;">
		<h6 style="font-weight: bold;">Report</h6>

		<table class="ftable">
			<thead>
				<tr>
					<th>From:<input type="" name="" id="from"></th>
				
					<th>To:<input type="" name="" id="to"></th>
				
					<th>
					<button class="btn btn-sm btn-primary frmbtn" onclick="agreeSearch()">Search</button>
					</th>
					<th>
						&emsp;<a href="javascript:void(0)" onclick="exportagri()">Export</a>&emsp;
						<script type="text/javascript">
							function exportagri(){
								var from = $('#from').val();
								var to = $('#to').val();
								myWindow = window.open('exportagri.php?from='+from+'&to='+to, '_blank', 'location=yes,height=300,width=400,scrollbars=yes,status=yes');
								setTimeout(function(){ 
									myWindow.close();
								},500);
							}
						</script>
					</th>
				</tr>

			</thead>
		</table>



		<br><br>
		<table id="" class=" estable table table-bordered">
			<thead>
				<tr>
					<th>Agreement-ID</th>
					<th>Organiser Name</th>
					<th>Production Person</th>
					<th>Farmer Id</th>
					<th>Farmer Name</th>
					<th>Farmer Father Name</th>
					<th>Village</th>
					<th>Tahsil</th>
					<th>District</th>
					<th>State</th>
					<th>Sowing Acre</th>
					<th>Standing Acre</th>
				</tr>
			</thead>
			<tbody id="reportBody">
				
			</tbody>
		</table>
	</div>
	
	

</div>

<script>
	$('#from').datepicker({format:'dd-mm-yyyy',});
	$('#to').datepicker({format:'dd-mm-yyyy',});

	function agreeSearch(){
		var from = $('#from').val();
		var to = $('#to').val();

		$.post("reportAjax.php",{ act:'get_report',from:from,to:to},function(data) {
			$('#reportBody').html(data);
			console.log(data);
			
	    });

	}
</script>




