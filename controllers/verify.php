<?php
//To verify the email and token
require 'models/user.model.php';
require 'models/mail.model.php';

//check if the data is sent via php:://input
if(empty($_POST)){
    $_POST = json_decode(file_get_contents('php://input'), true);
}

//To ensure that all the data is sent
if (!isset($_POST['email']) || !isset($_POST['token'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Data missing']);
    exit;
}
//To enusre that the user exists
$user = new User();
if(!$user->exists($_POST['email'])){
    http_response_code(400);
    echo json_encode(['error' => 'User does not exist']);
    exit;
}
//check if the user is already verified
$result = $user->isVerified($_POST['email']);
if($result){
    http_response_code(400);
    echo json_encode(['error' => 'User already verified']);
    exit;
}
//To verify the email and token
$result = $user->verify($_POST['email'], $_POST['token']);
if(!$result){
    // http_response_code(400);
    echo json_encode(['message' => 'Verification failed','status'=>'error']);
    exit;
}
else{
    http_response_code(200);
    echo json_encode(['message' => 'Verification successful','status'=>'success']);
    exit;
}
?>