<?php namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    function getCredentials(){
        $pathOfFile = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "credentials";
        $credentials = explode(":",file($pathOfFile,FILE_SKIP_EMPTY_LINES)[0]);
        return $credentials;
    }
    function login(){
        session_start();
        $_SESSION["user_logged_in"] = true;
    }
    function userLoggedIn() {
        session_start();
        $loggedIn = $_SESSION["user_logged_in"] ?? false;
        return $loggedIn; 
    }
    function logout() {
        session_start();
        session_destroy();
    }
    
}