<?php
//A file to get all backed up data from the server
//File for sync down
require_once 'models/user.model.php';
require_once 'models/file.model.php';

//Create a new instance of the User and File models
$user = new User();
$file = new File();

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
    //check if the user exists
    if(!$user->exists($email)){
        //If the user does not exist, return an error message
        echo json_encode(['error' => 'User does not exist']);
        exit;
    }
    //Get the user ID from the data
    $user->getUser($data['email']);
    $userID = $user->userID;
    //Get all the files for the user
    $files = $file->getFilesByUserID($userID);
    $downloadedFiles = [];
    //Loop through the files and add the file data to the files array
    foreach($files as $file){
        //Get the file data
        $fileData = file_get_contents($file['filePath']);
        //The file data is sent as a buffer like that from the fs.readFile function in nodejs
        //Put the file data in a buffer
        $fileData = array_map("ord", str_split($fileData));
        //Get the file type
        $fileType = $file['fileType'];
        //Add the file data to the files array
        $downloadedFiles[] = [
            'fileName' => $file['fileName'],
            'fileType' => $fileType,
            'fileData' => $fileData
        ];
    }
    //Return the files
    echo json_encode(["data"=>$downloadedFiles,'message' => 'Files downloaded successfully','status'=>'success']);
}
else{
    //If the request method is not POST, return an error message
    echo json_encode(['error' => 'Invalid request method','status'=>'error','message'=>'Invalid request method']);
}