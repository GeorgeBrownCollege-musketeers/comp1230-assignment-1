<?php namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    function getCredentials() {
		$credentialsPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "credentials";
        $csv = [];

		$handle = fopen($credentialsPath , "r");
		while (($data = fgets($handle)) !== FALSE) {
			$csv[explode(":", $data)[0]] = explode(":", $data)[1]; 
		}
        return $csv;
	}
    function login($username){
        session_start();
        $_SESSION["user_logged_in"] = true;
        $_SESSION["username"] = $username;
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

    public function changePassword($newPassword) {
        session_start();
		$username = $_SESSION['username'];
		$credentialsPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "credentials";
		$loginModel = model('App\Models\LoginModel');
        $credentials = $loginModel->getCredentials();
		
		$credentials[$username] = md5($newPassword);

		$credentialsFile = fopen($credentialsPath, "w");

		$credentialsTxt = "";
		foreach($credentials as $user=>$password) {
			$credentialsTxt .= $user . ":" . $password;
		}	
		fwrite($credentialsFile, $credentialsTxt);
		fclose($credentialsFile);
	}
}