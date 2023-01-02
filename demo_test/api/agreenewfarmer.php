<?php
include '../config.php';
date_default_timezone_set('asia/calcutta');

if($_REQUEST['newexist']!='' && $_REQUEST['agree_no']!='' && $_REQUEST['seeds_acreage']!='' && $_REQUEST['tem_fid']!='')
{

 $yer=substr($_REQUEST['agree_no'], 0, 4);
 
 if($_REQUEST['newexist']=='e')
 {
  $sqlFi=mysql_query("select fid from farmers where tem_fid='".$_POST['tem_fid']."'",$con); $rowFi=mysql_num_rows($sqlFi);
  if($rowFi>0){ $resFi=mysql_fetch_assoc($sqlFi); $fid=$resFi['fid']; }else{ $fid=''; }
  $run_qry=mysql_query("update agreement_".$yer." set trf_newexist='".$_REQUEST['newexist']."', trf_seeds_acreage='".$_REQUEST['seeds_acreage']."', trf_fid='".$fid."', trf_tem_fid='".$_REQUEST['tem_fid']."' where agree_no='".$_REQUEST['agree_no']."'");
  
  if($run_qry)
  {
      echo json_encode(array("data" => "success") );
  }
  
 } 
 elseif($_REQUEST['newexist']=='n')
 {

  if($_POST['fname']!='' && $_POST['contact']!='' && $_POST['UserId']!='')
  {
  
   $sel=mysql_query("select * from farmers where contact_1='".$_POST['contact']."'");
   if(mysql_num_rows($sel) == 0)
   { 
    //$tem_fid=str_replace("T","",$_POST['tem_fid']);
    $tem_fid=$_POST['tem_fid'];
    if($_POST['doc_aadharback']!=''){ $aadharback=$_POST['doc_aadharback']; }else{$aadharback='';}  
    if($_POST['doc_passback']!=''){ $passback=$_POST['doc_passback']; }else{$passback='';}
            
    $ins=mysql_query("INSERT INTO `farmers`( `tem_fid`,`fname`, `contact_1`,`doc_passbook`, doc_passback, `doc_aadhar`, `doc_aadharback`,  `doc_idproof`,`doc_addproof`, `cr_by`, `cr_date`) VALUES ( '".$tem_fid."','".$_POST['fname']."','".$_POST['contact']."','".$_POST['doc_pass']."', '".$passback."', '".$_POST['doc_aadhar']."', '".$aadharback."', '".$_POST['doc_idproof']."','".$_POST['doc_addressproof']."','".$_POST['UserId']."','".date('Y-m-d')."')");
        
     if($ins)
	 {
      $id=mysql_insert_id();
      $run_qry=mysql_query("update agreement_".$yer." set trf_newexist='".$_REQUEST['newexist']."', trf_seeds_acreage='".$_REQUEST['seeds_acreage']."', trf_fid='".$id."', trf_tem_fid='".$_REQUEST['tem_fid']."' where agree_no='".$_REQUEST['agree_no']."'");
	  
	  $extp = substr($_POST['doc_pass'], strrpos($_POST['doc_pass'], '.') + 1);
	  $exta = substr($_POST['doc_aadhar'], strrpos($_POST['doc_aadhar'], '.') + 1);
	  if($_POST['doc_aadharback']!=''){ $exta2 = substr($aadharback, strrpos($aadharback, '.') + 1); }
	  if($_POST['doc_passback']!=''){ $extp2 = substr($passback, strrpos($passback, '.') + 1); }
	  $exti = substr($_POST['doc_idproof'], strrpos($_POST['doc_idproof'], '.') + 1);
	  $extad = substr($_POST['doc_addressproof'], strrpos($_POST['doc_addressproof'], '.') + 1);
	
	  $doc_passbook=$id.'doc_passbook.'.$extp;
	  $doc_aadhar=$id.'doc_aadhar.'.$exta;
	  if($_POST['doc_aadharback']!=''){ $doc2_aadhar=$id.'doc_aadharback.'.$exta2; }
	  if($_POST['doc_passback']!=''){ $doc2_passbook=$id.'doc_passback.'.$extp2; }
	  $doc_idproof=$id.'doc_idproof.'.$exti;
	  $doc_addproof=$id.'doc_addproof.'.$extad;
	
	  if(file_exists("files/".$_POST['doc_pass'])){ $path='files'; }
	  elseif(file_exists("files_2/".$_POST['doc_pass'])){ $path='files_2'; }
	  elseif(file_exists("files_3/".$_POST['doc_pass'])){ $path='files_3'; } 
	  elseif(file_exists("files_4/".$_POST['doc_pass'])){ $path='files_4'; } 
	  elseif(file_exists("files_5/".$_POST['doc_pass'])){ $path='files_5'; }
	  rename('../'.$path.'/'.$_POST['doc_pass'],'../'.$path.'/'.$doc_passbook);
	
	  if(file_exists("files/".$_POST['doc_aadhar'])){ $path2='files'; }
	  elseif(file_exists("files_2/".$_POST['doc_aadhar'])){ $path2='files_2'; }
	  elseif(file_exists("files_3/".$_POST['doc_aadhar'])){ $path2='files_3'; } 
	  elseif(file_exists("files_4/".$_POST['doc_aadhar'])){ $path2='files_4'; } 
	  elseif(file_exists("files_5/".$_POST['doc_aadhar'])){ $path2='files_5'; }
	  rename('../'.$path2.'/'.$_POST['doc_aadhar'],'../'.$path2.'/'.$doc_aadhar);
	
	   if($_POST['doc_aadharback']!='')
	   {
	    if(file_exists("files/".$aadharback)){ $path3='files'; }
	    elseif(file_exists("files_2/".$aadharback)){ $path3='files_2'; }
	    elseif(file_exists("files_3/".$aadharback)){ $path3='files_3'; } 
	    elseif(file_exists("files_4/".$aadharback)){ $path3='files_4'; } 
	    elseif(file_exists("files_5/".$aadharback)){ $path3='files_5'; }
	    rename('../'.$path3.'/'.$aadharback,'../'.$path3.'/'.$doc2_aadhar);
	   } 
	   if($_POST['doc_passback']!='')
	   {
	    if(file_exists("files/".$passback)){ $path4='files'; }
	    elseif(file_exists("files_2/".$passback)){ $path4='files_2'; }
	    elseif(file_exists("files_3/".$passback)){ $path4='files_3'; } 
	    elseif(file_exists("files_4/".$passback)){ $path4='files_4'; } 
	    elseif(file_exists("files_5/".$passback)){ $path4='files_5'; }
	    rename('../'.$path4.'/'.$passback,'../'.$path4.'/'.$doc2_passbook);
	   }
	
	   if(file_exists("files/".$_POST['doc_idproof'])){ $path5='files'; }
	   elseif(file_exists("files_2/".$_POST['doc_idproof'])){ $path5='files_2'; }
	   elseif(file_exists("files_3/".$_POST['doc_idproof'])){ $path5='files_3'; } 
	   elseif(file_exists("files_4/".$_POST['doc_idproof'])){ $path5='files_4'; } 
	   elseif(file_exists("files_5/".$_POST['doc_idproof'])){ $path5='files_5'; }
	   rename('../'.$path5.'/'.$_POST['doc_idproof'],'../'.$path5.'/'.$doc_idproof);
	
	   if(file_exists("files/".$_POST['doc_addressproof'])){ $path6='files'; }
	   elseif(file_exists("files_2/".$_POST['doc_addressproof'])){ $path6='files_2'; }
	   elseif(file_exists("files_3/".$_POST['doc_addressproof'])){ $path6='files_3'; } 
	   elseif(file_exists("files_4/".$_POST['doc_addressproof'])){ $path6='files_4'; } 
	   elseif(file_exists("files_5/".$_POST['doc_addressproof'])){ $path6='files_5'; }
	   rename('../'.$path6.'/'.$_POST['doc_addressproof'],'../'.$path6.'/'.$doc_addproof);
	
	   $updt=mysql_query("UPDATE `farmers` set `doc_passbook`='".$_POST['doc_pass']."', doc_passback='".$passback."', `doc_aadhar`='".$_POST['doc_aadhar']."', `doc_aadharback`='".$aadharback."', `doc_idproof`='".$_POST['doc_idproof']."',`doc_addproof`='".$_POST['doc_addressproof']."' where fid=".$id);
	
	   echo json_encode(array("data" => "success","ContactNo" => $_POST['contact']) );
	
     } //if($ins)
     else
     {
      echo json_encode(array("data" => "error","ContactNo" => $_POST['contact']) ); 
     }
		
   }//if(mysql_num_rows($sel) == 0)
   else
   {
    echo json_encode(array("data" => "Duplicate found","ContactNo" => $_POST['contact']) ); 
   }
    
      
  } //if( $_POST['fname']!='' && $_POST['contact']!='' && $_POST['UserId']!='')
  else
  {
   echo json_encode(array("data" => "Value Missing!","ContactNo" => $_POST['contact']) );
  }

 }//elseif($_POST['newexist']=='n')

} //if($_POST['newexist']!='' && $_POST['agree_no']!='' && $_POST['seeds_acreage']!='' && $_POST['tem_fid']!='')
else
{
 echo json_encode(array("data" => "Value Missing!","ContactNo" => $_POST['contact']) );
}
?>
