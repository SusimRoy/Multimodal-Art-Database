<?php 
// Include the database configuration file  
require_once 'dbconfig.php'; 
 
// If file upload form is submitted 
$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    $status = 'error'; 
    $targetDir = "uploads/";
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
        $targetFilePath = $targetDir . $fileName;
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $key = $_FILES["image"]["name"];
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
            $imgContent = $_FILES['image']['name']; 
            #$imgContent = addslashes(file_get_contents($image)); 
            $author = $_REQUEST['author'];
            $title = $_REQUEST['title'];
            $school = $_REQUEST['school'];
            $technique = $_REQUEST['technique'];
            $genre = $_REQUEST['genre'];
            $time_frame = $_REQUEST['time_Frame'];
            }
            else{
                $errorUpload .= $_FILES['files']['name'][$key].' | '; 
            }

         
            // Insert image content into database 
            $insert = $db->query("INSERT into painting (img_file, author, title) VALUES ('$imgContent','$author','$title')");
            $insert1 = $db->query("INSERT into intricacies (img_file, school, technique) VALUES ('$imgContent','$school','$technique')"); 
            $insert2 = $db->query("INSERT into contemporary (img_file, genre, time_frame) VALUES ('$imgContent','$genre','$time_frame')");  
             
            if($insert and $insert1 and $insert2){ 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully."; 
            }else{ 
                $statusMsg = "File upload failed, please try again."; 
            }  
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
} 
 
// Display status message 
?>

<!DOCTYPE html>

<html lang="en-US">
    <head>
        <title>Upload Images</title>
        <meta charset = "utf-8">
        <style>
        p {text-align: center;}
        div {text-align: center;}
        </style>

        <!-- <link rel = "stylesheet" href="css/style.css"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            body {
  padding: 25px;
  background-color: black;
  color: lightgrey;
  font-size: 25px;
}
        </style>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <div class = "container">
        <h1>Upload Images to Database </h1>
        <br></br>
        <a href="index.php">Go back to homepage</a>
<br></br>
        <div class = "gallery">
        <?php if(!empty($statusMsg)){ ?>
                <p class="status-msg"><?php echo $statusMsg;?></p>
                <?php } ?>
            <form action="" method="post" enctype="multipart/form-data">
            <p>
            <label for="Author Name">Author Name:</label>
            <input type="text" name="author" id="Author Name">
            </p>
            <p>
            <label for="Title of Painting">Title of Painting:</label>
                <input type="text" name="title" id="Title of Painting">
            </p>
            <p>
            <label for="School">School:</label>
                <input type="text" name="school" id="School ">
            </p>
            <p>
            <label for="Technique">Technique:</label>
                <input type="text" name="technique" id="Technique">
            </p>
            <p>
            <label for="Time_Frame">Time Frame:</label>
                <input type="text" name="time_Frame" id="Time_Frame">
            </p>
            <p>
            <label for="Genre">Genre:</label>
                <input type="text" name="genre" id="Genre">
            </p>
            <label>Select Image File to Upload:</label>
            <p>
            <input type="file" name="image">
            </p>
            <input type="submit" name="submit" value="UPLOAD">

            </form>
            </div>
        </div>
    </body>
</html>
