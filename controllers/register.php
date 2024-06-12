<?php
//The controller for the register route
require 'models/user.model.php';
require 'models/mail.model.php';

//check if the data is sent via php:://input
if(empty($_POST)){
    $_POST = json_decode(file_get_contents('php://input'), true);
}

//To ensure that all the data is sent
if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    // http_response_code(400);
    echo json_encode(['message' => 'Data missing','status'=>'error']);
    exit;
}

$user = new User();
//check whether user already exists
if($user->exists($_POST['email'])){
    echo json_encode(['message' => 'User already exists','status'=>'error']);
    exit;
}
$result = $user->register($_POST['name'], $_POST['email'], $_POST['password']);
if(!$result){
    http_response_code(400);
    echo json_encode(['error' => 'Registration failed']);
    exit;
}
else{
    //To send the email to the user with the verification token
    $mail = new Mail();
    $token = $user->token;
    $mailContent=file_get_contents('views/verificationMail.view.php');
    $result = $mail->send($_POST['email'], $token,$mailContent,true);
    if($result){
        http_response_code(200);
        echo json_encode(['message' => 'Registration successful','status'=>'success']);
        exit;
    }
    else{
        http_response_code(400);
        echo json_encode(['error' => 'Email not sent']);
        exit;
    }
}

?>