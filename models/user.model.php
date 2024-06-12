<?php

//The user model which extends the database model
require_once 'models/database.model.php';

class User extends Database {
    public $token;
    public $userID;
    public $name;
    public $email;

    public function __construct() {
        parent::__construct();
    }
    public function register($name, $email, $password) {
        //hash the password
        $password = md5($password);
        $sql = "INSERT INTO users (name, email,password) VALUES ('$name', '$email','$password')";
        //If the query is successful, create a token
        $result=$this->query($sql);
        if ($result === TRUE) {
            $this->token = $this->createVerificationToken($email);
            $token = $this->token;
            //update the token in the database
            $sql = "UPDATE users SET verificationToken = '$token' WHERE email = '$email'";
            if($this->query($sql) === TRUE){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    //To login a user
    public function login($email, $password) {
        //hash the password
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result=$this->query($sql);
        if ($result->num_rows > 0) {
            //set the user properties
            $row = $result->fetch_assoc();
            $this->userID = $row['userID'];
            $this->name = $row['name'];
            $this->email = $row['email'];
            return true;
        }
        else{
            return false;
        }
    }

    //To verify the email and token
    public function verify($email, $token) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND verificationToken = '$token'";
        $result=$this->query($sql);
        if ($result->num_rows > 0) {
            $sql = "UPDATE users SET verified = 1 WHERE email = '$email'";
            if($this->query($sql) === TRUE){
                return true;
                //Delete the token
                $sql = "UPDATE users SET verificationToken = '' WHERE email = '$email'";
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    //Check if a given email is already verified
    public function isVerified($email) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND verified = 1";
        $result=$this->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
    }

    //To check whether a user exists
    public function exists($email) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        //check if the user exists
        $result=$this->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
    }

    private function createVerificationToken($email) {
        $token = md5($email . time());
        return $token;
    }

    public function getUser($email) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result=$this->query($sql);
        //set the user properties
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->userID = $row['userID'];
            $this->name = $row['name'];
            $this->email = $row['email'];
        }
    }
}