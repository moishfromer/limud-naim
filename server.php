<?php
session_start();
require 'vendor/autoload.php';

if (isset($_POST['submit'])) {
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
    $image = basename($_FILES["image"]["name"]);
    $target_dir = "images/";
    $target_file = $target_dir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $link = mysqli_connect('localhost', 'root', '', 'limudnaim');
    mysqli_query($link, 'SET NAMES utf8');
    $query = "INSERT INTO users VALUES(DEFAULT,'$name','$email','$phone','$image')";
    $result = mysqli_query($link, $query);
    if ($result && mysqli_affected_rows($link) == 1) {
        $_SESSION['user_id'] = mysqli_insert_id($link);
    }


    try {
        $mandrill = new Mandrill('jqGXT4rHdAf5gAXkkpIwJg');
        $message = array(
            'html' => '<p>thanks for signing up</p>',
            'text' => 'thanks for signing up',
            'subject' => 'limud naim signup',
            'from_email' => 'admin@limudnaim.co.il',
            'from_name' => 'admin',
            'to' => array(
                array(
                    'email' => "$email",
                    'name' => "$name",
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => 'message.reply@example.com'),
            'important' => false,
            
        );
        $async = false;
        $ip_pool = 'Main Pool';
        $send_at = '2017-05-05 11:22:22';
        $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        print_r($result);
        /*
          Array
          (
          [0] => Array
          (
          [email] => recipient.email@example.com
          [status] => sent
          [reject_reason] => hard-bounce
          [_id] => abc123abc123abc123abc123abc123
          )

          )
         */
    } catch (Mandrill_Error $e) {
        // Mandrill errors are thrown as exceptions
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
        throw $e;
    }
    header('location:profile.php');
}
https://pixabay.com/api/videos/?key=4174241-deb43267d0b52782dfa0cda9c&q=yellow+flowers