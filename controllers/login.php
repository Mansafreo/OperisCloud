<?php

//File for login
require_once 'models/user.model.php';

//Create a new instance of the User model
$user = new User();

//Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //check if the data is sent via php:://input
    if(empty($_POST)){
        $_POST = json_decode(file_get_contents('php://input'), true);
    }
    //check if the data is empty
    if(empty($_POST)){
        //If the data is empty, return an error message
        echo json_encode(['error' => 'No data sent']);
        exit;
    }   
    $data = $_POST;//Get the data from the request
    $email = $data['email'];//Get the email from the data
    $password = $data['password'];//Get the password from the data
    //check if the user exists
    if(!$user->exists($email)){
        //If the user does not exist, return an error message
        echo json_encode(['message' => 'Invalid email or password','status'=>'error']);
        exit;
    }
    //Login the user
    if($user->login($email, $password)){
        //If the user exists, return a success message
        $userData=[
            'userID'=>$user->userID,
            'name'=>$user->name,
            'email'=>$user->email
        ];
        echo json_encode(['message' => 'Login successful','data'=>$userData,'status'=>'success']);
    }
    else{
        //If the user does not exist, return an error message
        echo json_encode(['message' => 'Invalid email or password','status'=>'error']);
    }
}
else{
    //If the request method is not POST, return an error message
    echo json_encode(['message' => 'Invalid request method','status'=>'error']);
}