<?php 
// Include the database configuration file  
require_once 'dbconfig.php'; 
 
// Get image data from database 
$result = $db->query("SELECT img_file FROM contemporary LIMIT 50"); 
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
        <h1>Retrieved Images from Database </h1>
        <br></br>
        <a href="index.php">Go back to homepage</a>
        <br></br>
        <div class = "gallery">
            <?php if($result->num_rows > 0){ ?> 
                <div class="img-box"> 
                    <?php while($row = $result->fetch_assoc()){ 
                        $imageURL = 'uploads/'.$row["img_file"];
                        ?>
                        <img src="<?php echo $imageURL; ?>" alt=""/> 
                    <?php } ?> 
                </div> 
            <?php }else{ ?> 
                <p class="status error">Image(s) not found...</p> 
            <?php } ?>
            </div>
        </div>
    </body>
</html>