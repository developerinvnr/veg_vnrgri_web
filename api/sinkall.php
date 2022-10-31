<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');


 if($_REQUEST['userid'] == '' || $_REQUEST['value'] == '')
 {
   echo json_encode(array( "status" => "100","msg" => "Parameter missing!") );
 }
 elseif($_REQUEST['userid']!= '' || $_REQUEST['value'] == 'sinkall')
 {
    $sqls=mysql_query("select * from view_season where SesId=1"); $ress=mysql_fetch_assoc($sqls);
    $y=date("Y")+1;
  
    /*
    if($ress['Kharif']=='Y'){ $from='2019-04-01'; $to='2019-08-30'; }
    elseif($ress['Rabi']=='Y'){ $from='2019-09-15'; $to='2020-03-30';  }
    else
    {
     $from = date('Y-m-d',strtotime($_REQUEST['dfrom'])); 
     $to = date('Y-m-d',strtotime($_REQUEST['dto']));     
    } 
    */
    
  $sVd=mysql_query("select * from app_version where VersionId=1"); 
  $rVd=mysql_fetch_assoc($sVd); 
  $Kdf=date("Y-m-d",strtotime($rVd['Kharif_From'])); 
  $Kdt=date("Y-m-d",strtotime($rVd['Kharif_To']));
  $Rdf=date("Y-m-d",strtotime($rVd['Rabi_From']));
  $Rdt=date("Y-m-d",strtotime($rVd['Rabi_To']));
  $Sdf=date("Y-m-d",strtotime($rVd['Summer_From']));
  $Sdt=date("Y-m-d",strtotime($rVd['Summer_To']));
  
  if($ress['Kharif']=='Y' AND $ress['Rabi']=='Y'){ $from=$Kdf; $to=$Rdt; }
  elseif($ress['Rabi']=='Y' AND $ress['Summer']=='Y'){ $from=$Rdf; $to=$Sdt; }
  elseif($ress['Summer']=='Y' AND $ress['Kharif']=='Y'){ $from=$Sdf; $to=$Kdt;  }
  else
  {
   $from = date('Y-m-d',strtotime($_REQUEST['dfrom'])); 
   $to = date('Y-m-d',strtotime($_REQUEST['dto']));     
  } 
    
    //$agyearf = (int)date('2020',strtotime($from));
    //$agyeart = (int)date('2021',strtotime($to));
    $agyearf = (int)date('Y',strtotime($from));
    $agyeart = (int)date('Y',strtotime($to));
   
   /*
    $stid= mysql_query("SELECT state_id from user_location ul inner join users u on ul.uid=u.uId where state_id>0 and (ul.uid=".$_REQUEST['userid']." OR u.uReporting=".$_REQUEST['userid'].") group by state_id");
    $dtid= mysql_query("SELECT district_id from user_location ul inner join users u on ul.uid=u.uId where district_id>0 and (ul.uid=".$_REQUEST['userid']." OR u.uReporting=".$_REQUEST['userid'].") group by district_id");
    $ttid= mysql_query("SELECT tahsil_id from user_location ul inner join users u on ul.uid=u.uId where tahsil_id>0 and (ul.uid=".$_REQUEST['userid']." OR u.uReporting=".$_REQUEST['userid'].") group by tahsil_id");
    $vtid= mysql_query("SELECT village_id from user_location ul inner join users u on ul.uid=u.uId where village_id>0 and (ul.uid=".$_REQUEST['userid']." OR u.uReporting=".$_REQUEST['userid'].") group by village_id");
   */
   
   /************* <!--------------------------------------------> ****************/
  /************* <!--------------------------------------------> ****************/
   
   $uchk=mysql_query("SELECT QADept,Qs1,Qs2,Qs3,Qs4,Qs5 from users where uId=".$_REQUEST['userid']); $ruchk=mysql_fetch_assoc($uchk);
   
   if($ruchk['QADept']=='N')
   {
   
    $stid= mysql_query("SELECT state_id from user_location where state_id>0 and sts='A' and uid=".$_REQUEST['userid']);
    $dtid= mysql_query("SELECT district_id from user_location where district_id>0 and sts='A' and uid=".$_REQUEST['userid']);
    $ttid= mysql_query("SELECT tahsil_id from user_location where tahsil_id>0 and sts='A' and uid=".$_REQUEST['userid']);
    $vtid= mysql_query("SELECT village_id from user_location where village_id>0 and sts='A' and uid=".$_REQUEST['userid']);
   
    $rows=mysql_num_rows($stid); $rowd=mysql_num_rows($dtid); 
    $rowt=mysql_num_rows($ttid); $rowv=mysql_num_rows($vtid);
   
     
    if($rowv>0)
    {  
      while($rv=mysql_fetch_array($vtid)){ $array_v[]=$rv['village_id']; } 
      $vv = implode(',', $array_v); $qry='village_id'; $qryy='agr.vi';  
    } 
    else if($rowt>0)
    {  
      while($rt=mysql_fetch_array($ttid)){ $array_t[]=$rt['tahsil_id']; } 
      $vv = implode(',', $array_t); $qry='tahsil_id'; $qryy='agr.ti';
    }
    else if($rowd>0)
    {
      while($rd=mysql_fetch_array($dtid)){ $array_d[]=$rd['district_id']; } 
      $vv = implode(',', $array_d); $qry='distric_id'; $qryy='agr.di';
    }
    else
    {
      while($rs=mysql_fetch_array($stid)){ $array_s[]=$rs['state_id']; } 
      $vv = implode(',', $array_s); $qry='state_id'; $qryy='agr.si';
    }
    
    //$vv = '9,16'; $qry='state_id'; $qryy='agr.si';
  
   } //if($ruchk=='N')
   
   elseif($ruchk['QADept']=='Y')
   {  
      if($ruchk['Qs1']>0){$s1=$ruchk['Qs1'];}else{$s1=0;}
      if($ruchk['Qs2']>0){$s2=$ruchk['Qs2'];}else{$s2=0;}
      if($ruchk['Qs3']>0){$s3=$ruchk['Qs3'];}else{$s3=0;}
      if($ruchk['Qs4']>0){$s4=$ruchk['Qs4'];}else{$s4=0;}
      if($ruchk['Qs5']>0){$s5=$ruchk['Qs5'];}else{$s5=0;}

      $vv = $s1.','.$s2.','.$s3.','.$s4.','.$s5; 
      $qry='state_id'; $qryy='agr.si'; 
   }
     
  /************* <!--------------------------------------------> ****************/
  /************* <!--------------------------------------------> ****************/
 
   /*******************************************************************/
   $farray = array();
   $run_qry=mysql_query("select * from farmers where (".$qry." in (".$vv.") or cr_by='".$_REQUEST['userid']."')"); 
   
   $numF=mysql_num_rows($run_qry);
   ini_set('memory_limit', '-1');
   
   $qry=""; 
   
   if($agyearf<=$agyeart){ $yFrom=$agyearf; $yTo=$agyeart; }
   else{ $yFrom=$agyeart; $yTo=$agyearf; }
   
   for($i=$yFrom; $i <= $yTo; $i++)
   {   
	 $qry.="SELECT agr.*, u.uName, f.tem_fid, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id, c.cropname, c.cropcode, v.VillageName as village_name, t.TahsilName as block_name, d.DictrictName as district_name, s.StateName as state_name FROM `agreement_".$i."` agr, users u, farmers f, organiser o, crop c, village v, tahsil t, distric d, state s where agree_date between '".$from."' and '".$to."' and agr.prod_executive=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and agr.ann_crop=c.cropid and agr.vi=v.VillageId and agr.ti=t.TahsilId and agr.di=d.DictrictId and agr.si=s.StateId and ".$qryy." in (".$vv.")";
	 
	 if($i!=$yTo){ $qry.=' UNION '; }
   }
   ini_set('memory_limit', '-1');
   
   //echo $qry;
   
   $run_qry2=mysql_query($qry); $numA=mysql_num_rows($run_qry2); 
   
   $farray = array(); $aarray = array();
   if($numF>0 OR $numA>0)
   {
     /* Farmer list */
     while($res=mysql_fetch_assoc($run_qry)){ $farray[]=$res; }
	 
	 /* Agree lis */
	 while($res=mysql_fetch_assoc($run_qry2))
     {  
       if($res['ann7_flandid']>0)
	   {
		$fld=mysql_query('SELECT StateName, DictrictName, TahsilName, VillageName FROM farmers_land fl, state s, distric d, tahsil t, village v where fl.StateId=s.StateId AND fl.DictrictId=d.DictrictId AND fl.TahsilId=t.TahsilId AND fl.VillageId=v.VillageId AND flandid='.$res['ann7_flandid']); $rld=mysql_fetch_assoc($fld);
	   }
	   
	   
	   $su=mysql_query("select uName as Exe_name from users where uId=".$res['prod_executive']); $ru=mysql_fetch_assoc($su);
	   
	   
	   $agr_y = substr($res['agree_no'], 0, 4); $lotno = array();
	   if($res['agree_no']>0)
	   {
		$slot=mysql_query("SELECT agree_no,lot_no,noofbag,qty,quality_garde,moisure,dispatch_date,driver_no,lorry_no FROM agreementlot_".$agr_y." where agree_no='".$res['agree_no']."'"); 
		while($rlot=mysql_fetch_assoc($slot))
		{
		 $lotno[]=$rlot;
		}
	   }
	   
	   
	   $RmkDetails = array();
	   $sRmk=mysql_query("select Remark as Remark_Rmk, RmkDate from agreement_remark where agree_no='".$res['agree_no']."' order by RmkDate ASC"); $rowsqchk=mysql_num_rows($sRmk);
	    if($rowsqchk>0)
	    { 
		 while($rRmk=mysql_fetch_assoc($sRmk))
		 {
		  $RmkDetails[]=$rRmk;
		 }
	    }
	    
	    $rr_v = array(); $rr_f = array(); $rr_pf = array();
	   if($res['agree_id']>0)
	   {
	       
	    $sv=mysql_query("SELECT * FROM agreement_vegetative_".$agr_y." where agree_id='".$res['agree_id']."' order by V_update DESC"); 
		while($rv=mysql_fetch_assoc($sv)){ $rr_v[]=$rv; }
		
		$sf=mysql_query("SELECT * FROM agreement_flowering_".$agr_y." where agree_id='".$res['agree_id']."' order by F_update DESC"); 
		while($rf=mysql_fetch_assoc($sf)){ $rr_f[]=$rf; }
		
		$spf=mysql_query("SELECT * FROM agreement_postflowering_".$agr_y." where agree_id='".$res['agree_id']."' order by Pf_update DESC"); 
		while($rpf=mysql_fetch_assoc($spf)){ $rr_pf[]=$rpf; }
	   } 
	   
	   $res['production_executive_name']=$ru;
	   $res['LotDeatils']=$lotno;
	   $res['landdetails']=$rld; 
	   $res['Remark_Details']=$RmkDetails;
	   $res['Vegetative']=$rr_v;
	   $res['Flowering']=$rr_f;
	   $res['Postflowering']=$rr_pf;
	   $aarray[]=$res; 
     } 
	 
     echo json_encode(array( "farmer_list" => $farray,  "agreement_list" => $aarray) ); 
	 
   }
   else
   {
     echo json_encode(array( "data" => "100", "msg" => "Invalid id!") );
   }
   
   
   /*******************************************************************/ 
   
   
     
  
   
   
 
 }
 else 
 {
   echo json_encode(array( "data" => "100", "msg" => "Missing Value!") );
 }

?>









