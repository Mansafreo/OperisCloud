<?php
//Hardest code to write

//To synchronise the data between the server and the client, we need to create a controller that will handle the requests from the client and send the data back to the client. This controller will be called synController.php and will be responsible for handling the requests from the client and sending the data back to the client.

//Import all the models
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
    //Get the name of the file from the data
    $fileName = $data['fileName'];
    //Get the type of the file from the data
    $fileType = $data['fileType'];
    //Check if the file already exists
    if($file->fileExists($userID, $fileName)){
        //If the file already exists,just overwrite it
        $file->deleteFile($userID, $fileName);
        //Delete the file from the server
        unlink($file->filePath);
    }
    //The filepath will be relative to the server
    $filePath = 'uploads/' . $fileName;
    //Get the actual file data from the request
    $fileData = $data['fileData'];
    //The filedata is sent as a buffer like that from the fs.readFile function in nodejs
    //Put the file data in a file
    $fileData = $fileData['data'];
    //Merge the file data which is currently in an array to a string
    $fileData = implode(array_map("chr", $fileData));
    //Save the file to the server
    file_put_contents($filePath, $fileData);
    if($file->addFile($userID, $fileName, $fileType, $filePath)){
        //If the file is successfully added to the database, return a success message
        echo json_encode(['message' => 'File uploaded successfully']);
    }
    else{
        //If the file is not successfully added to the database, return an error message
        echo json_encode(['error' => 'File upload failed']);
    }
}
else{
    //If the request method is not POST, return a 404 error
    http_response_code(404);
    echo json_encode(['error' => 'Page not found']);
    exit;
}