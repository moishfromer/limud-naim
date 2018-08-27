<?php
session_start();
$id = $_SESSION['user_id'];
$link = mysqli_connect('localhost', 'root', '', 'limudnaim');
mysqli_query($link, 'SET NAMES utf8');
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($link, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $info = mysqli_fetch_assoc($result);
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> Profile</title>
    </head>
    <body>
        <h1> Thanks for signing up!</h1>
        <p>Name: <?= $info['name']; ?></p>
        <p> Email: <?= $info['email']; ?></p>
        <p> Phone: <?= $info['phone']; ?></p>
        <p> Image: <img src="<?= 'images/' . $info['image']; ?>" alt=""></p>
        
        <h2> Pick profile image</h2>
        <div class="images"> 
            
        </div>
    </body>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script>

        var API_KEY = '4174241-deb43267d0b52782dfa0cda9c';
        var URL = "https://pixabay.com/api/?key=" + API_KEY + "&q=" + encodeURIComponent('red roses');
        $.getJSON(URL, function (data) {
            if (parseInt(data.totalHits) > 0)
                $.each(data.hits, function (i, hit) {
                    $('.images').append('<img src="'+hit.previewURL+'"/>');
                });
            else
                console.log('No hits');
        });
    </script>
</html>
