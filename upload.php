<?php 
   // Include the database configuration file 
   include_once 'dbConfig.php'; 
        
   if(isset($_POST['submit'])){ 
       // File upload configuration 
       $targetDir = "uploads/"; 
       $allowTypes = array('jpg','png','jpeg','gif'); 
        
       $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
       $fileNames = array_filter($_FILES['files']['name']); 
       if(!empty($fileNames)){ 
           foreach($_FILES['files']['name'] as $key=>$val){ 
               // File upload path 
               $fileName = basename($_FILES['files']['name'][$key]); 
               $targetFilePath = $targetDir . $fileName; 
                
               // Check whether file type is valid 
               $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
               if(in_array($fileType, $allowTypes)){ 
                   // Upload file to server 
                   if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){ 
                       // Image db insert sql 
                       $insertValuesSQL .= "('".$fileName."', NOW()),"; 
                   }else{ 
                       $errorUpload .= $_FILES['files']['name'][$key].' | '; 
                   } 
               }else{ 
                   $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
               } 
           } 
            
           // Error message 
           $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):''; 
           $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):''; 
           $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType; 
            
           if(!empty($insertValuesSQL)){ 
               $insertValuesSQL = trim($insertValuesSQL, ','); 
               // Insert image file name into database 
               $insert = $db->query("INSERT INTO images (file_name, uploaded_on) VALUES $insertValuesSQL"); 
               if($insert){ 
                   $statusMsg = "Files are uploaded successfully.".$errorMsg;
                   echo "<script>window.location.href ='index.php'</script>";
               }else{ 
                   $statusMsg = "Sorry, there was an error uploading your file."; 
               } 
           }else{ 
               $statusMsg = "Upload failed! ".$errorMsg; 
           } 
       }else{ 
           $statusMsg = 'Please select a file to upload.'; 
       } 
   } 
    
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title></title>
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
      <!-- Vendor CSS Files -->
      <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
      <link href="style.css" rel="stylesheet">
   </head>
   <body>
      <?php include('header.php');?>
      <div class="container" style="margin-top: 100px">
        <div align="center">
         <form action="upload.php" method="post" enctype="multipart/form-data">
            Select Image Files to Upload:
            <input type="file" name="files[]" class="form-control w-50 mb-4" multiple >
            <input type="submit" name="submit" class="btn btn-primary w-50 mb-4 shadow" value="UPLOAD">
         </form>
        </div>
      </div>
      <?php include('footer.php');?>
   </body>
</html>