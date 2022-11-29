<?php

include_once 'dbconfig.php';

?>
<!DOCTYPE html>

<html lang="en-US">
    <head>
        <title>DBMS Project</title>
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
    <center>
    <h1>A Multimodal Art Database</h1></center>
    <br></br>
    <div class = "container">
        <div class = "upfrm">
            <p>
            <a href="upload.php">Upload images to the dataset</a>
</p><p>
            <a href="view.php" >View uploaded images</a></p>
            <p>
            <!-- <a href="train.php">Train AI model</a> -->
</p><p>
            <a href = "predict.php">Image Retrieval Using Multimodal AI</a>
</p>
        <h1> ER Diagram for our project :<h1>
            <img src = '' />
        </div>
    </div>
</body>
</html>
