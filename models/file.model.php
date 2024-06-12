<?php

// The file model which extends the database model
require_once 'models/database.model.php';

class File extends Database {
    public $filePath;

    public function __construct() {
        parent::__construct();
    }

    // Method to insert a new file record
    public function addFile($userID, $fileName, $fileType, $filePath) {
        $sql = "INSERT INTO Files (userID, fileName, fileType, filePath) VALUES (?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param('isss', $userID, $fileName, $fileType, $filePath);
        //Execute the query
        return $stmt->execute();
    }

    // Method to delete a file record by fileID
    public function deleteFile($userID, $fileName) {
        $sql = "DELETE FROM Files WHERE userID = ? AND fileName = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param('is', $userID, $fileName);
        return $stmt->execute();
    }

    // Method to get a file by its ID
    public function getFileByID($fileID) {
        $sql = "SELECT * FROM Files WHERE fileID = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param('i', $fileID);
        $stmt->execute();
        $result = $stmt->get_result();
        $results=[];
        while($row = $result->fetch_assoc()){
            $results[] = $row;
        }
        return $results;
    }

    //Get files by UserID
    public function getFilesByUserID($userID) {
        $sql = "SELECT * FROM Files WHERE userID = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param('i', $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $results=[];
        while($row = $result->fetch_assoc()){
            $results[] = $row;
        }
        return $results;
    }

    //Check whether a given file for a given user exists
    public function fileExists($userID, $fileName) {
        $sql = "SELECT * FROM Files WHERE userID = ? AND fileName = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param('is', $userID, $fileName);
        $stmt->execute();
        $result = $stmt->get_result();
        //set the file path if the file exists
        if($result->num_rows > 0){
            $file = $result->fetch_assoc();
            $this->filePath = $file['filePath'];
        }
        return $result->num_rows > 0;
    }
}

?>
