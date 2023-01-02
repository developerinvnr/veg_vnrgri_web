<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');

if($_REQUEST['userid']!= '' && $_REQUEST['agree_no']!='' && $_REQUEST['agree_id']!='' && $_REQUEST['value']=='agreeupdate')
{
 
 $yer=substr($_REQUEST['agree_no'], 0, 4);
 
 if($_REQUEST['SubValue']=='SowingMale')
 {
   $run_qry=mysql_query("update agreement_".$yer." set S_sowing_method_male='".$_REQUEST['S_sowing_method_male']."', S_foundation_male_lot='".$_REQUEST['S_foundation_male_lot']."', S_numberof_treys_male='".$_REQUEST['S_numberof_treys_male']."', S_nursery_sowingdate_male='".date("Y-m-d",strtotime($_REQUEST['S_nursery_sowingdate_male']))."', S_seed_qty_male='".$_REQUEST['S_seed_qty_male']."', S_numberof_cell_male='".$_REQUEST['S_numberof_cell_male']."', S_MRemark='".$_REQUEST['S_Remark']."', S_MEntryDate='".date("Y-m-d")."', S_entrydate='".date("Y-m-d")."' where agree_no='".$_REQUEST['agree_no']."'");
 }
 
 else if($_REQUEST['SubValue']=='SowingFemale')
 {
   $run_qry=mysql_query("update agreement_".$yer." set S_sowing_method_female='".$_REQUEST['S_sowing_method_female']."', S_foundation_female_lot='".$_REQUEST['S_foundation_female_lot']."', S_numberof_treys_female='".$_REQUEST['S_numberof_treys_female']."', S_nursery_sowingdate_female='".date("Y-m-d",strtotime($_REQUEST['S_nursery_sowingdate_female']))."', S_seed_qty_female='".$_REQUEST['S_seed_qty_female']."', S_numberof_cell_female='".$_REQUEST['S_numberof_cell_female']."', S_FRemark='".$_REQUEST['S_FRemark']."', S_FEntryDate='".date("Y-m-d")."', S_entrydate='".date("Y-m-d")."' where agree_no='".$_REQUEST['agree_no']."'");
 }
 
 else if($_REQUEST['SubValue']=='Germination')
 {
   $run_qry=mysql_query("update agreement_".$yer." set S_ObsvtionDate_male='".date("Y-m-d",strtotime($_REQUEST['S_ObsvtionDate_male']))."', S_ObsvtionDate_female='".date("Y-m-d",strtotime($_REQUEST['S_ObsvtionDate_female']))."', S_germ_per_male='".$_REQUEST['S_germ_per_male']."', S_germ_per_female='".$_REQUEST['S_germ_per_female']."', S_Ger_EntryDate='".date("Y-m-d")."' where agree_no='".$_REQUEST['agree_no']."'");
 }
 
 else if($_REQUEST['SubValue']=='Transplanting')
 {
   $run_qry=mysql_query("update agreement_".$yer." set T_date_female='".date("Y-m-d",strtotime($_REQUEST['T_date_female']))."', T_acrage_female='".$_REQUEST['T_acrage_female']."', T_spacing_rr_no_female='".$_REQUEST['T_spacing_rr_no_female']."', T_spacing_pp_no_female='".$_REQUEST['T_spacing_pp_no_female']."', T_plant_population_female='".$_REQUEST['T_plant_population_female']."', T_date_male='".date("Y-m-d",strtotime($_REQUEST['T_date_male']))."', T_acrage_male='".$_REQUEST['T_acrage_male']."', T_spacing_rr_no_male='".$_REQUEST['T_spacing_rr_no_male']."', T_spacing_pp_no_male='".$_REQUEST['T_spacing_pp_no_male']."', T_plant_population_male='".$_REQUEST['T_plant_population_male']."', T_total_standing_ac='".$_REQUEST['T_total_standing_ac']."', T_entrydate='".date("Y-m-d",strtotime($_REQUEST['T_entrydate']))."', L_location_long='".$_REQUEST['L_location_long']."', L_location_lat='".$_REQUEST['L_location_lat']."', L_location_add='".$_REQUEST['L_location_add']."', Location1='".$_REQUEST['L_location_lat']."', Location2='".$_REQUEST['L_location_long']."', L_entrydate='".date("Y-m-d")."', T_Remark='".$_REQUEST['T_Remark']."' where agree_no='".$_REQUEST['agree_no']."'");
 }
 
 else if($_REQUEST['SubValue']=='Vegetative')
 {
   $run_qry=mysql_query("update agreement_".$yer." set V_sown_transp_ac='".$_REQUEST['V_sown_transp_ac']."', V_gps_ac='".$_REQUEST['V_gps_ac']."', V_giff_ac='".$_REQUEST['V_giff_ac']."', V_pld_ac='".$_REQUEST['V_pld_ac']."', V_Diff_ac='".$_REQUEST['V_Diff_ac']."', V_off_type_female='".$_REQUEST['V_off_type_female']."', V_off_type_male='".$_REQUEST['V_off_type_male']."', V_disease_observed_female='".$_REQUEST['V_disease_observed_female']."', V_disease_observed_male='".$_REQUEST['V_disease_observed_male']."', V_entrydate='".date("Y-m-d")."', V_Remark='".$_REQUEST['V_Remark']."' where agree_no='".$_REQUEST['agree_no']."'");  
 }

 
 else if($_REQUEST['SubValue']=='Flower')
 {
   $run_qry=mysql_query("update agreement_".$yer." set F_flowering_start_date_female='".date("Y-m-d",strtotime($_REQUEST['F_flowering_start_date_female']))."', F_flowering_start_date_male='".date("Y-m-d",strtotime($_REQUEST['F_flowering_start_date_male']))."', F_crossing_start_date='".date("Y-m-d",strtotime($_REQUEST['F_crossing_start_date']))."', F_crossing_end_date='".date("Y-m-d",strtotime($_REQUEST['F_crossing_end_date']))."', F_plant_population='".$_REQUEST['F_plant_population']."', F_pld_ac='".$_REQUEST['F_pld_ac']."', F_standing_ac='".$_REQUEST['F_standing_ac']."', GPS_Measure='".$_REQUEST['GPS_Measure']."', F_off_type_female='".$_REQUEST['F_off_type_female']."', F_off_type_male='".$_REQUEST['F_off_type_male']."', F_disease_observed_female='".$_REQUEST['F_disease_observed_female']."', F_disease_observed_male='".$_REQUEST['F_disease_observed_male']."', F_male_removal_date='".date("Y-m-d",strtotime($_REQUEST['F_male_removal_date']))."', F_number_of_seed_fruit='".$_REQUEST['F_number_of_seed_fruit']."', F_number_of_fruits_plant='".$_REQUEST['F_number_of_fruits_plant']."', F_total_number_of_plants='".$_REQUEST['F_total_number_of_plants']."', F_100seed_weight='".$_REQUEST['F_100seed_weight']."', F_estimated_yield='".$_REQUEST['F_estimated_yield']."', F_Remark='".$_REQUEST['F_Remark']."', F_entrydate='".date("Y-m-d",strtotime($_REQUEST['F_entrydate']))."' where agree_no='".$_REQUEST['agree_no']."'");   
 }
 
 else if($_REQUEST['SubValue']=='PostFlower')
 {
     
   $run_qry=mysql_query("update agreement_".$yer." set Pf_plant_population='".$_REQUEST['Pf_plant_population']."', Pf_pld_ac='".$_REQUEST['Pf_pld_ac']."', Pf_standing_ac='".$_REQUEST['Pf_standing_ac']."', Final_GPS_Measure='".$_REQUEST['Final_GPS_Measure']."', Pf_off_type_female='".$_REQUEST['Pf_off_type_female']."', Pf_off_type_male='".$_REQUEST['Pf_off_type_male']."', Pf_disease_observed_female='".$_REQUEST['Pf_disease_observed_female']."', Pf_disease_observed_male='".$_REQUEST['Pf_disease_observed_male']."', Pf_number_of_seed_fruit='".$_REQUEST['Pf_number_of_seed_fruit']."', Pf_number_of_fruits_plant='".$_REQUEST['Pf_number_of_fruits_plant']."', Pf_total_number_of_plant='".$_REQUEST['Pf_total_number_of_plant']."', Pf_100seed_weight='".$_REQUEST['Pf_100seed_weight']."', Pf_estimated_yield='".$_REQUEST['Pf_estimated_yield']."', Pf_total_off_type_female='".$_REQUEST['Pf_total_off_type_female']."', Pf_total_off_type_male='".$_REQUEST['Pf_total_off_type_male']."', Pf_Remark='".$_REQUEST['Pf_Remark']."', Pf_entrydate='".date("Y-m-d")."' where agree_no='".$_REQUEST['agree_no']."'"); 
      
 }
  
 else if($_REQUEST['SubValue']=='Harvesting')
 {
   $run_qry=mysql_query("update agreement_".$yer." set H_plant_population_female='".$_REQUEST['H_plant_population_female']."', H_harvesting_start_date='".date("Y-m-d",strtotime($_REQUEST['H_harvesting_start_date']))."',  H_harvesting_end_date='".date("Y-m-d",strtotime($_REQUEST['H_harvesting_end_date']))."', H_harvesting_acrage_female='".$_REQUEST['H_harvesting_acrage_female']."', H_final_yield='".$_REQUEST['H_final_yield']."', H_Remark='".$_REQUEST['H_Remark']."', H_entrydate='".date("Y-m-d")."' where agree_no='".$_REQUEST['agree_no']."'");
 }
 
 else if($_REQUEST['SubValue']=='Dispatch')
 {
   
   //print_r(json_decode($_REQUEST['LotDetails'])); 
        
   $LotDetails = json_decode($_REQUEST['LotDetails']);   
   
   //echo json_encode(array(data=>$LotDetails));
   
   if(count($LotDetails)>0)
   { 
     for($i=0; $i<count($LotDetails); $i++)
	 { 
	   $run_qry_up = mysql_query("update agreementlot_".$yer." set quality_garde = '".$LotDetails[$i]->quality_garde."', qty='".$LotDetails[$i]->qty."' ,moisure = '".$LotDetails[$i]->moisure."', upby='".$_REQUEST['userid']."', noofbag='".$LotDetails[$i]->noofbag."', dispatch_date='".date("Y-m-d",strtotime($LotDetails[$i]->dispatch_date))."', lorry_no='".$LotDetails[$i]->lorry_no."', driver_no='".$LotDetails[$i]->driver_no."', crdate='".date('Y-m-d')."' where agree_no='".$LotDetails[$i]->agree_no."' and lot_no = '".$LotDetails[$i]->lot_no."'");
	   
	 }
   } 
   
   if($run_qry_up){ $run_qry=mysql_query("update agreement_".$yer." set D_entrydate='".date("Y-m-d")."' where agree_no='".$_REQUEST['agree_no']."'"); }
    
 }
 
 else if($_REQUEST['SubValue']=='Incidence' || $_REQUEST['Remark_Rmk']!='')
 {
   $run_qry=mysql_query("update agreement_".$yer." set Remark_Rmk='".$_REQUEST['Remark_Rmk']."' where agree_no='".$_REQUEST['agree_no']."'");
 }
 
 /******************* Remark **************/
  if($_REQUEST['Remark_Rmk']!='')
  {
     $sqchk=mysql_query("select * from agreement_remark where agree_no='".$_REQUEST['agree_no']."' and RmkDate='".date("Y-m-d")."'"); 
     $rowsqchk=mysql_num_rows($sqchk);
     if($rowsqchk>0)
     {
      $run_qry=mysql_query("update agreement_remark set Remark='".$_REQUEST['Remark_Rmk']."' where agree_no='".$_REQUEST['agree_no']."' and RmkDate='".date("Y-m-d")."'");
     }
     else
     {
      $run_qry=mysql_query("insert into agreement_remark(agree_no,Remark,RmkDate,crdate) values('".$_REQUEST['agree_no']."', '".$_REQUEST['Remark_Rmk']."', '".date("Y-m-d")."', '".date("Y-m-d")."')");  
     }    
  }
 /******************* Remark **************/
 
 /******************************** Extra table open *********************/
  //vegetative
  if($_REQUEST['V_excellent_cond_ac']!='')
  {
    $sel=mysql_query("select * from agreement_vegetative_".$yer." where V_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); $row=mysql_num_rows($sel);  
	if($row==0)
	{
	    
	 $run_qry=mysql_query("insert into agreement_vegetative_".$yer."(agree_id, V_excellent_cond_ac, V_good_cond_ac, V_average_cond_ac, V_poor_cond_ac, V_update) values ('".$_REQUEST['agree_id']."', '".$_REQUEST['V_excellent_cond_ac']."', '".$_REQUEST['V_good_cond_ac']."', '".$_REQUEST['V_average_cond_ac']."', '".$_REQUEST['V_poor_cond_ac']."', '".date("Y-m-d")."')"); 
	}
	else
	{
	 $run_qry=mysql_query("update agreement_vegetative_".$yer." set V_excellent_cond_ac='".$_REQUEST['V_excellent_cond_ac']."', V_good_cond_ac='".$_REQUEST['V_good_cond_ac']."', V_average_cond_ac='".$_REQUEST['V_average_cond_ac']."', V_poor_cond_ac='".$_REQUEST['V_poor_cond_ac']."' where V_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); 
	}
  }
  
  //flowering
  if($_REQUEST['F_excellent_cond_ac']!='')
  {
    $sel=mysql_query("select * from agreement_flowering_".$yer." where F_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); $row=mysql_num_rows($sel);  
	if($row==0)
	{
	    
	    
	 $run_qry=mysql_query("insert into agreement_flowering_".$yer."(agree_id, F_excellent_cond_ac, F_good_cond_ac, F_average_cond_ac, F_poor_cond_ac, F_update) values ('".$_REQUEST['agree_id']."', '".$_REQUEST['F_excellent_cond_ac']."', '".$_REQUEST['F_good_cond_ac']."', '".$_REQUEST['F_average_cond_ac']."', '".$_REQUEST['F_poor_cond_ac']."', '".date("Y-m-d")."')"); 
	}
	else
	{
	 $run_qry=mysql_query("update agreement_flowering_".$yer." set F_excellent_cond_ac='".$_REQUEST['F_excellent_cond_ac']."', F_good_cond_ac='".$_REQUEST['F_good_cond_ac']."', F_average_cond_ac='".$_REQUEST['F_average_cond_ac']."', F_poor_cond_ac='".$_REQUEST['F_poor_cond_ac']."' where F_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); 
	}  
  }
  
  //post_flowering
  if($_REQUEST['Pf_excellent_cond_ac']!='')
  {
    $sel=mysql_query("select * from agreement_postflowering_".$yer." where Pf_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); $row=mysql_num_rows($sel);  
	if($row==0)
	{
	    
	 $run_qry=mysql_query("insert into agreement_postflowering_".$yer."(agree_id, Pf_excellent_cond_ac, Pf_good_cond_ac, Pf_average_cond_ac, Pf_poor_cond_ac, Pf_update) values ('".$_REQUEST['agree_id']."', '".$_REQUEST['Pf_excellent_cond_ac']."', '".$_REQUEST['Pf_good_cond_ac']."', '".$_REQUEST['Pf_average_cond_ac']."', '".$_REQUEST['Pf_poor_cond_ac']."', '".date("Y-m-d")."')"); 
	}
	else
	{
	 $run_qry=mysql_query("update agreement_postflowering_".$yer." set Pf_excellent_cond_ac='".$_REQUEST['Pf_excellent_cond_ac']."', Pf_good_cond_ac='".$_REQUEST['Pf_good_cond_ac']."', Pf_average_cond_ac='".$_REQUEST['Pf_average_cond_ac']."', Pf_poor_cond_ac='".$_REQUEST['Pf_poor_cond_ac']."' where Pf_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); 
	}     
  }
  
  
  //harvesting
  if($_REQUEST['H_excellent_cond_ac']!='')
  {
    $sel=mysql_query("select * from agreement_harvesting_".$yer." where H_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); $row=mysql_num_rows($sel);  
	if($row==0)
	{
	 $run_qry=mysql_query("insert into agreement_harvesting_".$yer."(agree_id, H_excellent_cond_ac, H_good_cond_ac, H_average_cond_ac, H_poor_cond_ac, H_update) values ('".$_REQUEST['agree_id']."', '".$_REQUEST['H_excellent_cond_ac']."', '".$_REQUEST['H_good_cond_ac']."', '".$_REQUEST['H_average_cond_ac']."', '".$_REQUEST['H_poor_cond_ac']."', '".date("Y-m-d")."')"); 
	}
	else
	{
	 $run_qry=mysql_query("update agreement_harvesting_".$yer." set H_excellent_cond_ac='".$_REQUEST['H_excellent_cond_ac']."', H_good_cond_ac='".$_REQUEST['H_good_cond_ac']."', H_average_cond_ac='".$_REQUEST['H_average_cond_ac']."', H_poor_cond_ac='".$_REQUEST['H_poor_cond_ac']."' where H_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); 
	}
  }
  
 /******************************** Extra table close *********************/ 
 
  if($run_qry)
  {
   echo json_encode(array( "code" => "300", "msg" => "data update successfully!", "agree_no" => $_REQUEST['agree_no']) );
  }
  else
  {
   echo json_encode(array( "code" => "100", "msg" => "Error occour!") );
  }
 

}
else
{
 echo json_encode(array( "status" => "100","msg" => "Parameter missing!") );
}


?>








<?php /*
include '../config.php';
date_default_timezone_set('asia/calcutta');

if($_REQUEST['userid']!= '' && $_REQUEST['agree_no']!='' && $_REQUEST['agree_id']!='' && $_REQUEST['value'] == 'agreeupdate')
{

  $yer=substr($_REQUEST['agree_no'], 0, 4);
  
  if($_REQUEST['GPSMeasure']>0)
  { 
   $sq=mysql_query("select ann_crop, ann_ophyb, ann_prodcode from agreement_".$yer." where agree_no='".$_REQUEST['agree_no']."'");
   $rq=mysql_fetch_assoc($sq);
   $sql=mysql_query("select estimated_yield from master_fsqc_transaction where cropid=".$rq['ann_crop']." AND production_code='".$rq['ann_prodcode']."' AND type='".$rq['ann_ophyb']."'"); $res=mysql_fetch_assoc($sql);
   if($res['estimated_yield']!=''){ $EstimateYeild=$res['estimated_yield']*$_REQUEST['GPSMeasure']; }
   else{ $EstimateYeild=''; }
  }
  else{ $EstimateYeild=''; }
  
  if(isset($_REQUEST['S_foundation_female_lot']) OR isset($_REQUEST['S_foundation_male_lot']))
  {
      
      
 $run_qry=mysql_query("update agreement_".$yer." set L_location_long='".$_REQUEST['L_location_long']."', L_location_lat='".$_REQUEST['L_location_lat']."', L_location_add='".$_REQUEST['L_location_add']."', L_entrydate='".date("Y-m-d")."', S_foundation_female_lot='".$_REQUEST['S_foundation_female_lot']."', S_foundation_male_lot='".$_REQUEST['S_foundation_male_lot']."', S_nursery_sowingdate_female='".date("Y-m-d",strtotime($_REQUEST['S_nursery_sowingdate_female']))."', S_seed_qty_female='".$_REQUEST['S_seed_qty_female']."', S_sowing_method_female='".$_REQUEST['S_sowing_method_female']."', S_numberof_cell_female='".$_REQUEST['S_numberof_cell_female']."', S_numberof_treys_female='".$_REQUEST['S_numberof_treys_female']."', S_germ_per_female='".$_REQUEST['S_germ_per_female']."', S_nursery_sowingdate_male='".date("Y-m-d",strtotime($_REQUEST['S_nursery_sowingdate_male']))."', S_seed_qty_male='".$_REQUEST['S_seed_qty_male']."', S_sowing_method_male='".$_REQUEST['S_sowing_method_male']."', S_numberof_cell_male='".$_REQUEST['S_numberof_cell_male']."', S_numberof_treys_male='".$_REQUEST['S_numberof_treys_male']."', S_germ_per_male='".$_REQUEST['S_germ_per_male']."', S_entrydate='".date("Y-m-d")."', T_date_female='".date("Y-m-d",strtotime($_REQUEST['T_date_female']))."', T_acrage_female='".$_REQUEST['T_acrage_female']."', T_spacing_rr_no_female='".$_REQUEST['T_spacing_rr_no_female']."', T_spacing_pp_no_female='".$_REQUEST['T_spacing_pp_no_female']."', T_plant_population_female='".$_REQUEST['T_plant_population_female']."', T_date_male='".date("Y-m-d",strtotime($_REQUEST['T_date_male']))."', T_acrage_male='".$_REQUEST['T_acrage_male']."', T_spacing_rr_no_male='".$_REQUEST['T_spacing_rr_no_male']."', T_spacing_pp_no_male='".$_REQUEST['T_spacing_pp_no_male']."', T_plant_population_male='".$_REQUEST['T_plant_population_male']."', T_total_standing_ac='".$_REQUEST['T_total_standing_ac']."', T_entrydate='".date("Y-m-d",strtotime($_REQUEST['T_entrydate']))."', V_sown_transp_ac='".$_REQUEST['V_sown_transp_ac']."', V_gps_ac='".$_REQUEST['V_gps_ac']."', V_giff_ac='".$_REQUEST['V_giff_ac']."', V_pld_ac='".$_REQUEST['V_pld_ac']."', V_off_type_female='".$_REQUEST['V_off_type_female']."', V_off_type_male='".$_REQUEST['V_off_type_male']."', V_disease_observed_female='".$_REQUEST['V_disease_observed_female']."', V_disease_observed_male='".$_REQUEST['V_disease_observed_male']."', V_entrydate='".date("Y-m-d")."', V_excellent_cond_ac='".$_REQUEST['V_excellent_cond_ac']."', V_good_cond_ac='".$_REQUEST['V_good_cond_ac']."', V_average_cond_ac='".$_REQUEST['V_average_cond_ac']."', V_poor_cond_ac='".$_REQUEST['V_poor_cond_ac']."', S_Remark='".$_REQUEST['S_Remark']."', T_Remark='".$_REQUEST['T_Remark']."', V_Remark='".$_REQUEST['V_Remark']."', F_Remark='".$_REQUEST['F_Remark']."', Pf_Remark='".$_REQUEST['Pf_Remark']."', H_Remark='".$_REQUEST['H_Remark']."', Pld_Remark='".$_REQUEST['Pld_Remark']."' where agree_no='".$_REQUEST['agree_no']."'");  
  }
  
  if(isset($_REQUEST['F_flowering_start_date_female']) OR isset($_REQUEST['F_flowering_start_date_male']))
  {
  $run_qry=mysql_query("update agreement_".$yer." set F_flowering_start_date_female='".date("Y-m-d",strtotime($_REQUEST['F_flowering_start_date_female']))."', F_flowering_start_date_male='".date("Y-m-d",strtotime($_REQUEST['F_flowering_start_date_male']))."', F_crossing_start_date='".date("Y-m-d",strtotime($_REQUEST['F_crossing_start_date']))."', F_crossing_end_date='".date("Y-m-d",strtotime($_REQUEST['F_crossing_end_date']))."', F_plant_population='".$_REQUEST['F_plant_population']."', F_pld_ac='".$_REQUEST['F_pld_ac']."', F_standing_ac='".$_REQUEST['F_standing_ac']."', F_off_type_female='".$_REQUEST['F_off_type_female']."', F_off_type_male='".$_REQUEST['F_off_type_male']."', F_disease_observed_female='".$_REQUEST['F_disease_observed_female']."', F_disease_observed_male='".$_REQUEST['F_disease_observed_male']."', F_male_removal_date='".date("Y-m-d",strtotime($_REQUEST['F_male_removal_date']))."', F_number_of_seed_fruit='".$_REQUEST['F_number_of_seed_fruit']."', F_number_of_fruits_plant='".$_REQUEST['F_number_of_fruits_plant']."', F_total_number_of_plants='".$_REQUEST['F_total_number_of_plants']."', F_100seed_weight='".$_REQUEST['F_100seed_weight']."', F_estimated_yield='".$_REQUEST['F_estimated_yield']."', F_entrydate='".date("Y-m-d",strtotime($_REQUEST['F_entrydate']))."', F_excellent_cond_ac='".$_REQUEST['F_excellent_cond_ac']."',  F_good_cond_ac='".$_REQUEST['F_good_cond_ac']."', F_average_cond_ac='".$_REQUEST['F_average_cond_ac']."', F_poor_cond_ac='".$_REQUEST['F_poor_cond_ac']."', Pf_plant_population='".$_REQUEST['Pf_plant_population']."', Pf_pld_ac='".$_REQUEST['Pf_pld_ac']."', Pf_standing_ac='".$_REQUEST['Pf_standing_ac']."', Pf_off_type_female='".$_REQUEST['Pf_off_type_female']."', Pf_off_type_male='".$_REQUEST['Pf_off_type_male']."', Pf_disease_observed_female='".$_REQUEST['Pf_disease_observed_female']."', Pf_disease_observed_male='".$_REQUEST['Pf_disease_observed_male']."', Pf_number_of_seed_fruit='".$_REQUEST['Pf_number_of_seed_fruit']."', Pf_number_of_fruits_plant='".$_REQUEST['Pf_number_of_fruits_plant']."', Pf_total_number_of_plant='".$_REQUEST['Pf_total_number_of_plant']."', Pf_100seed_weight='".$_REQUEST['Pf_100seed_weight']."', Pf_estimated_yield='".$_REQUEST['Pf_estimated_yield']."', Pf_total_off_type_female='".$_REQUEST['Pf_total_off_type_female']."', Pf_total_off_type_male='".$_REQUEST['Pf_total_off_type_male']."', Pf_entrydate='".date("Y-m-d")."', Pf_excellent_cond_ac='".$_REQUEST['Pf_excellent_cond_ac']."', Pf_good_cond_ac='".$_REQUEST['Pf_good_cond_ac']."', Pf_average_cond_ac='".$_REQUEST['Pf_average_cond_ac']."', Pf_poor_cond_ac='".$_REQUEST['Pf_poor_cond_ac']."', GPS_Measure='".$_REQUEST['GPS_Measure']."', PLD_Acr='".$_REQUEST['PLD_Acr']."', Final_GPS_Measure='".$_REQUEST['Final_GPS_Measure']."', H_plant_population_female='".$_REQUEST['H_plant_population_female']."', H_harvesting_start_date='".date("Y-m-d",strtotime($_REQUEST['H_harvesting_start_date']))."',  H_harvesting_end_date='".date("Y-m-d",strtotime($_REQUEST['H_harvesting_end_date']))."', H_harvesting_acrage_female='".$_REQUEST['H_harvesting_acrage_female']."', H_final_yield='".$_REQUEST['H_final_yield']."', H_entrydate='".date("Y-m-d")."', D_lot_no='".$_REQUEST['D_lot_no']."', D_dispatch_date='".date("Y-m-d",strtotime($_REQUEST['D_dispatch_date']))."', D_dispatch_nof_gunny_leno_bag='".$_REQUEST['D_dispatch_nof_gunny_leno_bag']."', D_dispatch_qty_inkg='".$_REQUEST['D_dispatch_qty_inkg']."', D_dispatch_lorryno='".$_REQUEST['D_dispatch_lorryno']."', D_dispatch_driver_mobile='".$_REQUEST['D_dispatch_driver_mobile']."', D_dispatch_moisture_per='".$_REQUEST['D_dispatch_moisture_per']."', D_quality_grade='".$_REQUEST['D_quality_grade']."', D_remark='".$_REQUEST['D_remark']."', D_entrydate='".date("Y-m-d")."', anyremark='".$_REQUEST['anyremark']."' where agree_no='".$_REQUEST['agree_no']."'");
  }
  
 /******************************** Extra table open *********************
  //vegetative
  if($_REQUEST['V_excellent_cond_ac']!='')
  {
    $sel=mysql_query("select * from agreement_vegetative_".$yer." where V_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); $row=mysql_num_rows($sel);  
	if($row==0)
	{
	    
	 $run_qry=mysql_query("insert into agreement_vegetative_".$yer."(agree_id, V_excellent_cond_ac, V_good_cond_ac, V_average_cond_ac, V_poor_cond_ac, V_update) values ('".$_REQUEST['agree_id']."', '".$_REQUEST['V_excellent_cond_ac']."', '".$_REQUEST['V_good_cond_ac']."', '".$_REQUEST['V_average_cond_ac']."', '".$_REQUEST['V_poor_cond_ac']."', '".date("Y-m-d")."')"); 
	}
	else
	{
	 $run_qry=mysql_query("update agreement_vegetative_".$yer." set V_excellent_cond_ac='".$_REQUEST['V_excellent_cond_ac']."', V_good_cond_ac='".$_REQUEST['V_good_cond_ac']."', V_average_cond_ac='".$_REQUEST['V_average_cond_ac']."', V_poor_cond_ac='".$_REQUEST['V_poor_cond_ac']."' where V_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); 
	}
  }
  
  //flowering
  if($_REQUEST['F_excellent_cond_ac']!='')
  {
    $sel=mysql_query("select * from agreement_flowering_".$yer." where F_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); $row=mysql_num_rows($sel);  
	if($row==0)
	{
	    
	    
	 $run_qry=mysql_query("insert into agreement_flowering_".$yer."(agree_id, F_excellent_cond_ac, F_good_cond_ac, F_average_cond_ac, F_poor_cond_ac, F_update) values ('".$_REQUEST['agree_id']."', '".$_REQUEST['F_excellent_cond_ac']."', '".$_REQUEST['F_good_cond_ac']."', '".$_REQUEST['F_average_cond_ac']."', '".$_REQUEST['F_poor_cond_ac']."', '".date("Y-m-d")."')"); 
	}
	else
	{
	 $run_qry=mysql_query("update agreement_flowering_".$yer." set F_excellent_cond_ac='".$_REQUEST['F_excellent_cond_ac']."', F_good_cond_ac='".$_REQUEST['F_good_cond_ac']."', F_average_cond_ac='".$_REQUEST['F_average_cond_ac']."', F_poor_cond_ac='".$_REQUEST['F_poor_cond_ac']."' where F_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); 
	}  
  }
  
  //post_flowering
  if($_REQUEST['Pf_excellent_cond_ac']!='')
  {
    $sel=mysql_query("select * from agreement_post_flowering_".$yer." where Pf_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); $row=mysql_num_rows($sel);  
	if($row==0)
	{
	    
	 $run_qry=mysql_query("insert into agreement_postflowering_".$yer."(agree_id, Pf_excellent_cond_ac, Pf_good_cond_ac, Pf_average_cond_ac, Pf_poor_cond_ac, Pf_update) values ('".$_REQUEST['agree_id']."', '".$_REQUEST['Pf_excellent_cond_ac']."', '".$_REQUEST['Pf_good_cond_ac']."', '".$_REQUEST['Pf_average_cond_ac']."', '".$_REQUEST['Pf_poor_cond_ac']."', '".date("Y-m-d")."')"); 
	}
	else
	{
	 $run_qry=mysql_query("update agreement_postflowering_".$yer." set Pf_excellent_cond_ac='".$_REQUEST['Pf_excellent_cond_ac']."', Pf_good_cond_ac='".$_REQUEST['Pf_good_cond_ac']."', Pf_average_cond_ac='".$_REQUEST['Pf_average_cond_ac']."', Pf_poor_cond_ac='".$_REQUEST['Pf_poor_cond_ac']."' where Pf_update='".date("Y-m-d")."' and agree_id=".$_REQUEST['agree_id']); 
	}     
  }
/******************************** Extra table close *********************


  if($_REQUEST['Remark_Rmk']!='')
  {
     $sqchk=mysql_query("select * from agreement_remark where agree_no='".$_REQUEST['agree_no']."' and RmkDate='".date("Y-m-d")."'"); 
     $rowsqchk=mysql_num_rows($sqchk);
     if($rowsqchk>0)
     {
      $run_qry=mysql_query("update agreement_remark set Remark='".$_REQUEST['Remark_Rmk']."' where agree_no='".$_REQUEST['agree_no']."' and RmkDate='".date("Y-m-d")."'");
     }
     else
     {
      $run_qry=mysql_query("insert into agreement_remark(agree_no,Remark,RmkDate,crdate) values('".$_REQUEST['agree_no']."', '".$_REQUEST['Remark_Rmk']."', '".date("Y-m-d")."', '".date("Y-m-d")."')");  
     } 
      
  }


  if($run_qry)
  {
      
      $LotDetails = json_decode($_REQUEST['LotDeatils']);
      
	     if(count($LotDetails)>0){
		  for($i=0; $i<count($LotDetails); $i++){
		$run_qry_up = mysql_query("update agreementlot_".$yer." set quality_garde = '".$LotDetails[$i]->quality_garde."', qty='".$LotDetails[$i]->qty."' ,moisure = '".$LotDetails[$i]->moisure."', upby='".$_REQUEST['userid']."', noofbag='".$LotDetails[$i]->noofbag."', dispatch_date='".$LotDetails[$i]->dispatch_date."', lorry_no='".$LotDetails[$i]->lorry_no."', driver_no='".$LotDetails[$i]->driver_no."', crdate='".date('Y-m-d')."' where agree_no='".$LotDetails[$i]->agree_no."' and lot_no = '".$LotDetails[$i]->lot_no."'");
		  }
	  }
	  
      
   echo json_encode(array( "code" => "300", "msg" => "data update successfully!", "agree_no" => $_REQUEST['agree_no']) );
  }
  else
  {
   echo json_encode(array( "code" => "100", "msg" => "Error occour!") );
  }
}

else
{
 echo json_encode(array( "status" => "100","msg" => "Parameter missing!") );
}

*/
?>