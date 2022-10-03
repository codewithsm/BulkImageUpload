<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>BulkImageUpload</title>
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
         <div class="row text-left">
            <?php
               // Include the database configuration file
               include_once 'dbConfig.php';
               
               // Get images from the database
               $query = $db->query("SELECT * FROM images ORDER BY id DESC");
               
               if($query->num_rows > 0){
                   while($row = $query->fetch_assoc()){
                       $imageURL = 'uploads/'.$row["file_name"];
               ?> 
            <div class="col-lg-3 col-md-6 mb-4">
               <img src="
                  <?php echo $imageURL; ?>" alt="" class="img img-responsive trimmed-cover rounded mx-auto d-block w-100"/>
            </div>
            <?php }
               }else{ ?> 
            <p>No image(s) found...</p>
            <?php } ?> 
         </div>
      </div>
      <?php include('footer.php');?> 
   </body>
</html>