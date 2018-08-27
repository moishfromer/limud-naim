<?php

$ch = curl_init('https://pixabay.com/api/?key=4174241-deb43267d0b52782dfa0cda9c&q=yellow+flowers');  
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_HEADER, false); 

curl_setopt($ch, CURLOPT_POST, true);
$response = json_decode( curl_exec($ch) );
curl_close($ch);
$images = [];
if( $response){
  
  foreach($response as $row){
    
    $images[] = $row;
    
  }
  
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="server.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name</label><br> 
            <input type="text" name="name" id="name">
            <br> <br> 
            <label for="email">Email</label><br> 
            <input type="email" name="email" id="email">
            <br> <br> 
            <label for="phone">Phone</label><br> 
            <input type="tel" name="phone" id="phone">
            <br> <br> 
            <label for="image">Image</label><br> 
            <input type="file" name="image" id="image">
            <br> <br> 
            <h2>Or pick profile image from one of these</h2>
            <div class="images"> 
                <?php foreach ($images[1] as $image): ?>
                    <img src="<?= $image->previewURL ?>" alt="">
                <?php endforeach; ?>
            </div>
            <input type="submit" name="submit">
        </form>
    </body>
</html>
