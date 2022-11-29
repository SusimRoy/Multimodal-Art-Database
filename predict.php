<?php
error_reporting(E_ERROR | E_PARSE);
$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    $status = 'error'; 
    $targetDir = "src/queries/";
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileName = '1.jpg';
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
        $targetFilePath = $targetDir . $fileName;
         
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            // $key = $_FILES["image"]["name"];
            // $key = '1.jpg';
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
                $command1 = escapeshellcmd('C:\xampp\htdocs\SemArt\src');
                $output1 = shell_exec($command1);
                // $command2 = escapeshellcmd('conda list');
                // $output2 = shell_exec($command2);
                // echo 'h1';
                // echo "<pre>$output2</pre>";
                $command2 = escapeshellcmd('C:/Users/susim/anaconda3/envs/dbms/python.exe c:/xampp/htdocs/SemArt/src/retrieve.py');
                $output2 = shell_exec($command2);
                // echo "<pre>$output2</pre>";
                $json = file_get_contents('sample.json');
                $json_data = json_decode($json,true);
                foreach($json_data['images'] as $field){
                    $imageURL = './SemArt/Images'.$field;
                }
            }
            else{
                $errorUpload .= $_FILES['files']['name'][$key].' | '; 
            }
            }
            else{ 
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
            } 
       }
       else{ 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
    }
?>

<!DOCTYPE html>

<html lang="en-US">
    <head>
        <title>Retrieve Images</title>
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
        <h1>Retrieve Images from Database using Multimodal AI</h1>
        <br></br>
        <a href="index.php">Go back to homepage</a>
        <br></br>
        <div class = "gallery">
                <?php if(!empty($statusMsg)){ ?>
                        <p class="status-msg"><?php echo $statusMsg;?></p>
                        <?php } ?>
                    <form action="" method="post" enctype="multipart/form-data">
                    <label>Select Image File to Upload:</label>
                    <br></br>
                    <p>
                    <input type="file" name="image">
                    <br></br>
                    </p>
                    <input type="submit" name="submit" value="Upload">
                    <br></br>
                    </form>
                    <?php foreach($json_data['images'] as $key=>$field){
                        $imageURL = 'SemArt/Images/'.$field; 
                     ?>
                    <!-- <label><?php echo $json_data['text'][$key]; ?></label> -->
                    <center>
                        <figure>
                    <img src="<?php echo $imageURL; ?>" alt="" height=500 width=500 align="middle"/> 
                    <figcaption><?php echo $json_data['text'][$key]; ?></figcaption>
                    </figure>
                    </center>
                    <?php } ?>
                </div> 
            </div>
        </div>
    </body>
</html>