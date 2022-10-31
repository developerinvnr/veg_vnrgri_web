<?php
  
    $file_path = "../files/";
     
    $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
        
        // chmod($file_path,0755);

        
        echo json_encode(array( "imgname" => $_FILES['uploaded_file']['name']) );

    } else{
        
        echo json_encode(array( "imgname" => "fail--".$_FILES['uploaded_file']['name']) );

    }
    
    
 ?>