 <?php 
 	
     error_reporting(0);
    /*
    ====================================================================================================================
    ====================================================================================================================
       
        this page is for renaming the uploaded images as per the combination of 
        "uploaded id"+"category name"
        to make the uploaded file names unique

    ====================================================================================================================
    ====================================================================================================================
    */





    /*==================================================================================================================
        renaming files and database of     "doc_passbook"       start
    ====================================================================================================================*/

    $pb_png=mysql_query("SELECT * FROM `farmers` where doc_passbook like '%.png%'");
    while($pb_png_data=mysql_fetch_assoc($pb_png)){
        if($pb_png_data['doc_passbook'] != $pb_png_data['fid']."doc_passbook.png"){

            if(rename('files/'.$pb_png_data['doc_passbook'],'files/'.$pb_png_data['fid'].'doc_passbook.png')){
            $updt=mysql_query("update farmers set doc_passbook='".$pb_png_data['fid']."doc_passbook.png' where fid=".$pb_png_data['fid']);
            if($updt){

            //echo "update farmers set doc_passbook='".$pb_png_data['fid']."doc_passbook.png' where fid=".$pb_jpg_data['fid'];
            }
        }
        }
    }

    $pb_jpg=mysql_query("SELECT * FROM `farmers` where doc_passbook like '%.jpg%'");
    while($pb_jpg_data=mysql_fetch_assoc($pb_jpg)){
        if($pb_jpg_data['doc_passbook'] != $pb_jpg_data['fid']."doc_passbook.jpg"){

            if(rename('files/'.$pb_jpg_data['doc_passbook'],'files/'.$pb_jpg_data['fid'].'doc_passbook.jpg')){
            $updt=mysql_query("update farmers set doc_passbook='".$pb_jpg_data['fid']."doc_passbook.jpg' where fid=".$pb_jpg_data['fid']);
            if($updt){

            //echo "update farmers set doc_passbook='".$pb_jpg_data['fid']."doc_passbook.jpg' where fid=".$pb_jpg_data['fid'];
            }
        }
        }
    }

    /*==================================================================================================================
        renaming files and database of     "doc_passbook"       end
    ====================================================================================================================*/





    /*==================================================================================================================
        renaming files and database of     "doc_idproof"       start
    ====================================================================================================================*/

    $id_png=mysql_query("SELECT * FROM `farmers` where doc_idproof like '%.png%'");
    while($id_png_data=mysql_fetch_assoc($id_png)){
        if($id_png_data['doc_idproof'] != $id_png_data['fid']."doc_idproof.png"){

            if(rename('files/'.$id_png_data['doc_idproof'],'files/'.$id_png_data['fid'].'doc_idproof.png')){
            $updt=mysql_query("update farmers set doc_idproof='".$id_png_data['fid']."doc_idproof.png' where fid=".$id_png_data['fid']);
            if($updt){

            //echo "update farmers set doc_idproof='".$id_png_data['fid']."doc_idproof.png' where fid=".$id_png_data['fid'];
            }
        }
        }
    }

    $id_jpg=mysql_query("SELECT * FROM `farmers` where doc_idproof like '%.jpg%'");
    while($id_jpg_data=mysql_fetch_assoc($id_jpg)){
        if($id_jpg_data['doc_idproof'] != $id_jpg_data['fid']."doc_idproof.jpg"){

            if(rename('files/'.$id_jpg_data['doc_idproof'],'files/'.$id_jpg_data['fid'].'doc_idproof.jpg')){
            $updt=mysql_query("update farmers set doc_idproof='".$id_jpg_data['fid']."doc_idproof.jpg' where fid=".$id_jpg_data['fid']);
            if($updt){

            // echo "update farmers set doc_idproof='".$id_jpg_data['fid']."doc_idproof.jpg' where fid=".$id_jpg_data['fid'];
            }
        }
        }
    }

    /*==================================================================================================================
        renaming files and database of     "doc_idproof"       end
    ====================================================================================================================*/



    /*==================================================================================================================
        renaming files and database of     "doc_addproof"       start
    ====================================================================================================================*/

    $add_png=mysql_query("SELECT * FROM `farmers` where doc_addproof like '%.png%'");
    while($add_png_data=mysql_fetch_assoc($add_png)){
        if($add_png_data['doc_addproof'] != $add_png_data['fid']."doc_addproof.png"){

            if(rename('files/'.$add_png_data['doc_addproof'],'files/'.$add_png_data['fid'].'doc_addproof.png')){
            $updt=mysql_query("update farmers set doc_addproof='".$add_png_data['fid']."doc_addproof.png' where fid=".$add_png_data['fid']);
            if($updt){

            //echo "update farmers set doc_addproof='".$add_png_data['fid']."doc_addproof.png' where fid=".$add_png_data['fid'];
            }
        }
        }
    }

    $add_jpg=mysql_query("SELECT * FROM `farmers` where doc_addproof like '%.jpg%'");
    while($add_jpg_data=mysql_fetch_assoc($add_jpg)){
        if($add_jpg_data['doc_addproof'] != $add_jpg_data['fid']."doc_addproof.jpg"){

            if(rename('files/'.$add_jpg_data['doc_addproof'],'files/'.$add_jpg_data['fid'].'doc_addproof.jpg')){
            $updt=mysql_query("update farmers set doc_addproof='".$add_jpg_data['fid']."doc_addproof.jpg' where fid=".$add_jpg_data['fid']);
            if($updt){

            //echo "update farmers set doc_addproof='".$add_jpg_data['fid']."doc_addproof.jpg' where fid=".$add_jpg_data['fid'];
            }
        }
        }
    }


    /*==================================================================================================================
        renaming files and database of     "doc_addproof"       end
    ====================================================================================================================*/



 ?>