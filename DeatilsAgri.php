<?php session_start();
include 'config.php'; 

$agr_y = substr($_REQUEST['no'], 0, 4);

if(isset($_POST['Chkdta']))
{

$sqlu=mysql_query("update `agreement_".$agr_y."` set prod_person='".$_POST['prod_person']."', prod_executive='".$_POST['prod_executive']."', S_sowing_method_male='".$_REQUEST['S_sowing_method_male']."', S_foundation_male_lot='".$_REQUEST['S_foundation_male_lot']."', S_numberof_treys_male='".$_REQUEST['S_numberof_treys_male']."', S_nursery_sowingdate_male='".date("Y-m-d",strtotime($_REQUEST['S_nursery_sowingdate_male']))."', S_seed_qty_male='".$_REQUEST['S_seed_qty_male']."', S_numberof_cell_male='".$_REQUEST['S_numberof_cell_male']."', S_sowing_method_female='".$_REQUEST['S_sowing_method_female']."', S_foundation_female_lot='".$_REQUEST['S_foundation_female_lot']."', S_numberof_treys_female='".$_REQUEST['S_numberof_treys_female']."', S_nursery_sowingdate_female='".date("Y-m-d",strtotime($_REQUEST['S_nursery_sowingdate_female']))."', S_seed_qty_female='".$_REQUEST['S_seed_qty_female']."', S_numberof_cell_female='".$_REQUEST['S_numberof_cell_female']."', S_ObsvtionDate_male='".date("Y-m-d",strtotime($_REQUEST['S_ObsvtionDate_male']))."', S_ObsvtionDate_female='".date("Y-m-d",strtotime($_REQUEST['S_ObsvtionDate_female']))."', S_germ_per_male='".$_REQUEST['S_germ_per_male']."', S_germ_per_female='".$_REQUEST['S_germ_per_female']."', T_date_female='".date("Y-m-d",strtotime($_REQUEST['T_date_female']))."', T_acrage_female='".$_REQUEST['T_acrage_female']."', T_spacing_rr_no_female='".$_REQUEST['T_spacing_rr_no_female']."', T_spacing_pp_no_female='".$_REQUEST['T_spacing_pp_no_female']."', T_plant_population_female='".$_REQUEST['T_plant_population_female']."', T_date_male='".date("Y-m-d",strtotime($_REQUEST['T_date_male']))."', T_acrage_male='".$_REQUEST['T_acrage_male']."', T_spacing_rr_no_male='".$_REQUEST['T_spacing_rr_no_male']."', T_spacing_pp_no_male='".$_REQUEST['T_spacing_pp_no_male']."', T_plant_population_male='".$_REQUEST['T_plant_population_male']."', T_total_standing_ac='".$_REQUEST['T_total_standing_ac']."', V_sown_transp_ac='".$_REQUEST['V_sown_transp_ac']."', V_gps_ac='".$_REQUEST['V_gps_ac']."', V_giff_ac='".$_REQUEST['V_giff_ac']."', V_pld_ac='".$_REQUEST['V_pld_ac']."', V_Diff_ac='".$_REQUEST['V_Diff_ac']."', V_off_type_female='".$_REQUEST['V_off_type_female']."', V_off_type_male='".$_REQUEST['V_off_type_male']."', V_disease_observed_female='".$_REQUEST['V_disease_observed_female']."', V_disease_observed_male='".$_REQUEST['V_disease_observed_male']."', F_flowering_start_date_female='".date("Y-m-d",strtotime($_REQUEST['F_flowering_start_date_female']))."', F_flowering_start_date_male='".date("Y-m-d",strtotime($_REQUEST['F_flowering_start_date_male']))."', F_crossing_start_date='".date("Y-m-d",strtotime($_REQUEST['F_crossing_start_date']))."', F_crossing_end_date='".date("Y-m-d",strtotime($_REQUEST['F_crossing_end_date']))."', F_plant_population='".$_REQUEST['F_plant_population']."', F_pld_ac='".$_REQUEST['F_pld_ac']."', F_standing_ac='".$_REQUEST['F_standing_ac']."', GPS_Measure='".$_REQUEST['GPS_Measure']."', F_off_type_female='".$_REQUEST['F_off_type_female']."', F_off_type_male='".$_REQUEST['F_off_type_male']."', F_disease_observed_female='".$_REQUEST['F_disease_observed_female']."', F_disease_observed_male='".$_REQUEST['F_disease_observed_male']."', F_male_removal_date='".date("Y-m-d",strtotime($_REQUEST['F_male_removal_date']))."', F_number_of_seed_fruit='".$_REQUEST['F_number_of_seed_fruit']."', F_number_of_fruits_plant='".$_REQUEST['F_number_of_fruits_plant']."', F_total_number_of_plants='".$_REQUEST['F_total_number_of_plants']."', F_100seed_weight='".$_REQUEST['F_100seed_weight']."', F_estimated_yield='".$_REQUEST['F_estimated_yield']."', Pf_plant_population='".$_REQUEST['Pf_plant_population']."', Pf_pld_ac='".$_REQUEST['Pf_pld_ac']."', Pf_standing_ac='".$_REQUEST['Pf_standing_ac']."', Final_GPS_Measure='".$_REQUEST['Final_GPS_Measure']."', Pf_off_type_female='".$_REQUEST['Pf_off_type_female']."', Pf_off_type_male='".$_REQUEST['Pf_off_type_male']."', Pf_disease_observed_female='".$_REQUEST['Pf_disease_observed_female']."', Pf_disease_observed_male='".$_REQUEST['Pf_disease_observed_male']."', Pf_number_of_seed_fruit='".$_REQUEST['Pf_number_of_seed_fruit']."', Pf_number_of_fruits_plant='".$_REQUEST['Pf_number_of_fruits_plant']."', Pf_total_number_of_plant='".$_REQUEST['Pf_total_number_of_plant']."', Pf_100seed_weight='".$_REQUEST['Pf_100seed_weight']."', Pf_estimated_yield='".$_REQUEST['Pf_estimated_yield']."', Pf_total_off_type_female='".$_REQUEST['Pf_total_off_type_female']."', Pf_total_off_type_male='".$_REQUEST['Pf_total_off_type_male']."', H_plant_population_female='".$_REQUEST['H_plant_population_female']."', H_harvesting_start_date='".date("Y-m-d",strtotime($_REQUEST['H_harvesting_start_date']))."',  H_harvesting_end_date='".date("Y-m-d",strtotime($_REQUEST['H_harvesting_end_date']))."', H_harvesting_acrage_female='".$_REQUEST['H_harvesting_acrage_female']."', H_final_yield='".$_REQUEST['H_final_yield']."' where agree_no='".$_POST['agree_no']."' AND agree_id=".$_POST['agree_id']);
if($sqlu){$msg='Data updated successfully';}

}

if(isset($_POST['ChkDeleteAgri']))
{
$sqlu=mysql_query("delete from `agreement_".$agr_y."` where agree_no='".$_POST['agree_no']."' AND agree_id=".$_POST['agree_id']);
if($sqlu){$msg='Data deleted successfully';}
}



$agr=mysql_query("SELECT agr.*, c.cropname, c.cropcode, f.fname, f.aadhar_no, f.pan_no,  f.fid, f.tem_fid, f.dob, f.father_name, o.oname, c.cropname, c.cropcode, v.VillageName, t.TahsilName, d.DictrictName, s.StateName FROM `agreement_".$agr_y."` agr inner join farmers f on agr.second_party=f.fid inner join organiser o on agr.org_id=o.oid inner join crop c on agr.ann_crop=c.cropid inner join village v on agr.vi=v.VillageId inner join tahsil t on agr.ti=t.TahsilId inner join distric d on agr.di=d.DictrictId inner join state s on agr.si=s.StateId where agree_no='".$_REQUEST['no']."' AND agree_id=".$_REQUEST['id']); $agrd=mysql_fetch_assoc($agr);
?>
<style>
.th{ color:#0033FF; font-size:16px; width:100px; }
.input {font-size:12px; width:98%; }
.gap{ width:20px; font-size:12px; }
</style>
<script type="text/javascript">
function Validate(FFname)
{
 var agree = confirm("Are you sure?");
 if(agree)
 {  
   var agree2 = confirm("Are you sure second time?");
   if(agree2){return true;}else{ return false; } 
 }else{ return false; }
}

</script>
<form name="FFname" method="post" onsubmit="return Validate(this)">
<input type="hidden" name="agree_no" value="<?=$_REQUEST['no'];?>" />
<input type="hidden" name="agree_id" value="<?=$_REQUEST['id'];?>" />
<table style="width:100%;" border="0">
<center><span class="th"><b>Agree_No:</span>&nbsp;<?=$agrd['agree_no'];?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">Agree Date:</span>&nbsp;<?=date("d-m-Y",strtotime($agrd['agree_date']));?></b><center><br />
<span class="th">FarmerID:</span>&nbsp;<?=chunk_split($agrd['tem_fid'], 4, ' ');?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">Farmer Name:</span>&nbsp;<?=$agrd['fname'];?><br />

<span class="th">DOB:</span>&nbsp;<?=date("d-m-Y",strtotime($agrd['dob']));?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">Contact:</span>&nbsp;<?=$agrd['contact_1'];?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">Father:</span>&nbsp;<?=strtoupper($agrd['father_name']);?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">Organiser:</span>&nbsp;<?=strtoupper($agrd['oname']);?><br />

<span class="th">Crop:</span>&nbsp;<?=strtoupper($agrd['cropname']);?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">HyCode:</span>&nbsp;<?=strtoupper($agrd['ann_prodcode']);?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">FSCode M/F:</span>&nbsp;<?=$agrd['ann_fscode_m'].' / '.$agrd['ann_fscode_f'];?><br />

<span class="th">State:</span>&nbsp;<?=strtoupper($agrd['StateName']);?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">District:</span>&nbsp;<?=strtoupper($agrd['DictrictName']);?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">Tahsil:</span>&nbsp;<?=strtoupper($agrd['TahsilName']);?>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="th">Village:</span>&nbsp;<?=strtoupper($agrd['VillageName']);?>&nbsp;&nbsp;&nbsp;&nbsp;

<p><br>



<tr style="height:5px;"><td></td></tr>
<tr>
 <td class="th">Prod. Person</td><td style="width:10px;">:</td>
 <td><select class="form-control frminp" name="prod_person" id="prod_person" style="width:150px;">
 <?php $u=mysql_query("SELECT uId,uName FROM `users` where uStatus='A' order by uName asc");
  while($ud=mysql_fetch_assoc($u)){ ?><option value="<?=$ud['uId']?>" <?php if($agrd['prod_person']==$ud['uId']){echo 'selected';} ?>><?=strtoupper($ud['uName'])?></option><?php } ?></select></td>
 
 <td class="th">Executive</td><td style="width:10px;">:</td>
 <td><select class="form-control frminp" name="prod_executive" id="prod_executive" style="width:150px;">
 <?php $u=mysql_query("SELECT uId,uName FROM `users` where uStatus='A' order by uName asc");
  while($ud=mysql_fetch_assoc($u)){ ?><option value="<?=$ud['uId']?>" <?php if($agrd['prod_executive']==$ud['uId']){echo 'selected';} ?>><?=strtoupper($ud['uName'])?></option><?php } ?></select></td>
 
 <td class="th" colspan="6"></td>
</tr>
<tr style="height:5px;"><td></td></tr>

<tr style="height:5px;"><td colspan="10"><b>Sowing & Germination</b></td></tr>
<tr>
 <td class="th">Sowing method male</td><td style="width:10px;">:</td>
 <td class="th"><input type="text" class="input" name="S_sowing_method_male" value="<?=$agrd['S_sowing_method_male']?>" /></td>
 
 <td class="th">Foundation male lot</td><td style="width:10px;">:</td>
 <td class="th"><input type="text" class="input" name="S_foundation_male_lot" value="<?=$agrd['S_foundation_male_lot']?>" /></td>
 
 <td class="th">Numberof treys male</td><td style="width:10px;">:</td>
 <td class="th"><input type="text" class="input" name="S_numberof_treys_male" value="<?=$agrd['S_numberof_treys_male']?>" /></td>
</tr>
<tr>
<td class="th">Nursery sowing date male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_nursery_sowingdate_male" value="<?=$agrd['S_nursery_sowingdate_male']?>" /></td>
<td class="th">Seed qty male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_seed_qty_male" value="<?=$agrd['S_seed_qty_male']?>" /></td>
<td class="th">No of cell male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_numberof_cell_male" value="<?=$agrd['S_numberof_cell_male']?>" /></td>
</tr>
<tr>
<td class="th">Sowing method female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_sowing_method_female" value="<?=$agrd['S_sowing_method_female']?>" /></td>
<td class="th">Foundation female lot</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_foundation_female_lot" value="<?=$agrd['S_foundation_female_lot']?>" /></td>
<td class="th">No of treys female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_numberof_treys_female" value="<?=$agrd['S_numberof_treys_female']?>" /></td>
</tr>
<tr>
<td class="th">Nursery sowing date female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_nursery_sowingdate_female" value="<?=$agrd['S_nursery_sowingdate_female']?>" /></td>
<td class="th">Seed qty female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_seed_qty_female" value="<?=$agrd['S_seed_qty_female']?>" /></td>
<td class="th">No of cell female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_numberof_cell_female" value="<?=$agrd['S_numberof_cell_female']?>" /></td>
</tr>
<tr>
<td class="th">Obsv. Date male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_ObsvtionDate_male" value="<?=$agrd['S_ObsvtionDate_male']?>" /></td>
<td class="th">Obsv. Date female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_ObsvtionDate_female" value="<?=$agrd['S_ObsvtionDate_female']?>" /></td>
<td class="th">Germ(%) male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_germ_per_male" value="<?=$agrd['S_germ_per_male']?>" /></td>
</tr>
<tr>
<td class="th">Germ(%) female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="S_germ_per_female" value="<?=$agrd['S_germ_per_female']?>" /></td></tr>



<tr style="height:5px;"><td colspan="10"><b>Transplanting</b></td></tr>
<tr>
<td class="th">Date female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_date_female" value="<?=$agrd['T_date_female']?>" /></td>
<td class="th">Acrage female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_acrage_female" value="<?=$agrd['T_acrage_female']?>" /></td>
<td class="th">Spacing r*r no. female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_spacing_rr_no_female" value="<?=$agrd['T_spacing_rr_no_female']?>" /></td>
</tr>
<tr>
<td class="th">Spacing p*p no female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_spacing_pp_no_female" value="<?=$agrd['T_spacing_pp_no_female']?>" /></td>
<td class="th">Plant population female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_plant_population_female" value="<?=$agrd['T_plant_population_female']?>" /></td>
<td class="th">Date male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_date_male" value="<?=$agrd['T_date_male']?>" /></td>
</tr>
<tr>
<td class="th">Acrage male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_acrage_male" value="<?=$agrd['T_acrage_male']?>" /></td>
<td class="th">Spacing r*r no male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_spacing_rr_no_male" value="<?=$agrd['T_spacing_rr_no_male']?>" /></td>
<td class="th">Spacing p*p no male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_spacing_pp_no_male" value="<?=$agrd['T_spacing_pp_no_male']?>" /></td>
</tr>
<tr>
<td class="th">Plant population male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_plant_population_male" value="<?=$agrd['T_plant_population_male']?>" /></td>
<td class="th">Total standing ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="T_total_standing_ac" value="<?=$agrd['T_total_standing_ac']?>" /></td></tr>



<tr style="height:5px;"><td colspan="10"><b>Vegetative</b></td></tr>
<tr>
<td class="th">Sown transp Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="V_sown_transp_ac" value="<?=$agrd['V_sown_transp_ac']?>" /></td>
<td class="th">Gps Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="V_gps_ac" value="<?=$agrd['V_gps_ac']?>" /></td>
<td class="th">Diff Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="V_giff_ac" value="<?=$agrd['V_giff_ac']?>" /></td>
</tr>
<tr>
<td class="th">Pld Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="V_pld_ac" value="<?=$agrd['V_pld_ac']?>" /></td>
<td class="th">Diff Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="V_Diff_ac" value="<?=$agrd['V_Diff_ac']?>" /></td>
<td class="th">Off type female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="V_off_type_female" value="<?=$agrd['V_off_type_female']?>" /></td>
</tr>
<tr>
<td class="th">Off type male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="V_off_type_male" value="<?=$agrd['V_off_type_male']?>" /></td>
<td class="th">Disease observed female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="V_disease_observed_female" value="<?=$agrd['V_disease_observed_female']?>" /></td>
<td class="th">Disease observed male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="V_disease_observed_male" value="<?=$agrd['V_disease_observed_male']?>" /></td>
</tr>


<tr style="height:5px;"><td colspan="10"><b>Flowering</b></td></tr>
<tr>
<td class="th">Flowering start date female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_flowering_start_date_female" value="<?=$agrd['F_flowering_start_date_female']?>" /></td>
<td class="th">Flowering start date male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_flowering_start_date_male" value="<?=$agrd['F_flowering_start_date_male']?>" /></td>
<td class="th">Crossing start date</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_crossing_start_date" value="<?=$agrd['F_crossing_start_date']?>" /></td>
</tr>
<tr>
<td class="th">Crossing end date</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_crossing_end_date" value="<?=$agrd['F_crossing_end_date']?>" /></td>
<td class="th">Plant population</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_plant_population" value="<?=$agrd['F_plant_population']?>" /></td>
<td class="th">Standing Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_standing_ac" value="<?=$agrd['F_standing_ac']?>" /></td>
</tr>
<tr>
<td class="th">Pld Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_pld_ac" value="<?=$agrd['F_pld_ac']?>" /></td>
<td class="th">Final Standing Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="GPS_Measure" value="<?=$agrd['GPS_Measure']?>" /></td>
<td class="th">Off type female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_off_type_female" value="<?=$agrd['F_off_type_female']?>" /></td>
</tr>
<tr>
<td class="th">Off type male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_off_type_male" value="<?=$agrd['F_off_type_male']?>" /></td>
<td class="th">Disease observed female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_disease_observed_female" value="<?=$agrd['F_disease_observed_female']?>" /></td>
<td class="th">Disease observed male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_disease_observed_male" value="<?=$agrd['F_disease_observed_male']?>" /></td>
</tr>
<tr>
<td class="th">Male removal date</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_male_removal_date" value="<?=$agrd['F_male_removal_date']?>" /></td>
<td class="th">No of seed fruit</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_number_of_seed_fruit" value="<?=$agrd['F_number_of_seed_fruit']?>" /></td>
<td class="th">No of fruits plant</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_number_of_fruits_plant" value="<?=$agrd['F_number_of_fruits_plant']?>" /></td>
</tr>
<tr>
<td class="th">Total no of plants</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_total_number_of_plants" value="<?=$agrd['F_total_number_of_plants']?>" /></td>
<td class="th">100 seed weight</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_100seed_weight" value="<?=$agrd['F_100seed_weight']?>" /></td>
<td class="th">Estimated yield(Kg)</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="F_estimated_yield" value="<?=$agrd['F_estimated_yield']?>" /></td>
</tr>


<tr style="height:5px;"><td colspan="10"><b>Post Flowering</b></td></tr>
<tr>
<td class="th">Plant population</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_plant_population" value="<?=$agrd['Pf_plant_population']?>" /></td>
<td class="th">Standing Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_standing_ac" value="<?=$agrd['Pf_standing_ac']?>" /></td>
<td class="th">Pld Ac</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_pld_ac" value="<?=$agrd['Pf_pld_ac']?>" /></td>
</tr>
<tr>
<td class="th">Final GPS Measure</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Final_GPS_Measure" value="<?=$agrd['Final_GPS_Measure']?>" /></td>
<td class="th">Off type female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_off_type_female" value="<?=$agrd['Pf_off_type_female']?>" /></td>
<td class="th">Off type male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_off_type_male" value="<?=$agrd['Pf_off_type_male']?>" /></td>

</tr>
<tr>
<td class="th">Disease observed female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_disease_observed_female" value="<?=$agrd['Pf_disease_observed_female']?>" /></td>
<td class="th">Disease observed male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_disease_observed_male" value="<?=$agrd['Pf_disease_observed_male']?>" /></td>
<td class="th">No of seed fruit</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_number_of_seed_fruit" value="<?=$agrd['Pf_number_of_seed_fruit']?>" /></td>

</tr>
<tr>
<td class="th">No of fruits plant</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_number_of_fruits_plant" value="<?=$agrd['Pf_number_of_fruits_plant']?>" /></td>
<td class="th">Total number of_plant</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_total_number_of_plant" value="<?=$agrd['Pf_total_number_of_plant']?>" /></td>
<td class="th">100seed weight</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_100seed_weight" alue="Pf_100seed_weight']?>" /></td>

</tr>
<tr>
<td class="th">Estimated yield</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_estimated_yield" value="<?=$agrd['Pf_estimated_yield']?>" /></td>
<td class="th">Total off type female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_total_off_type_female" value="<?=$agrd['Pf_total_off_type_female']?>" /></td>
<td class="th">Total off type male</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="Pf_total_off_type_male" value="<?=$agrd['Pf_total_off_type_male']?>" /></td>
</tr>

<tr style="height:5px;"><td colspan="10"><b>Harvesting</b></td></tr>
<tr>
<td class="th">Plant_population_female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="H_plant_population_female" value="<?=$agrd['H_plant_population_female']?>" /></td>
<td class="th">Harvesting_start_date</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="H_harvesting_start_date" value="<?=$agrd['H_harvesting_start_date']?>" /></td>
<td class="th">Harvesting_end_date</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="H_harvesting_end_date" value="<?=$agrd['H_harvesting_end_date']?>" /></td>
</tr>
<tr>
<td class="th">Harvesting acrage female</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="H_harvesting_acrage_female" value="<?=$agrd['H_harvesting_acrage_female']?>" /></td>
<td class="th">Final yield(Kg)</td><td style="width:10px;">:</td>
<td><input type="text" class="input" name="H_final_yield" value="<?=$agrd['H_final_yield']?>" /></td>


<tr style="height:5px;"><td></td></tr>



<tr style="height:15px;"><td></td></tr>
<tr>
<td colspan="11" align="center" style="background-color:#80FF80;">
 <input type="submit" name="Chkdta" value="Update" style="width:100px;" />
 &nbsp;&nbsp;
 <input type="submit" name="ChkDeleteAgri" value="Delete" style="width:100px;" disabled="disabled"/>
 &nbsp;&nbsp;
 <?php echo $msg; ?>
</td>
</tr>

</table>
</form>

