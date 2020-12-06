<?php namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    function getCredentials() {
        $query = $this->db->query("SELECT * FROM members");
        $results = $query->getResult();
        $credentials = [];

        foreach ($results as $credential) {
            $credentials[$credential->username] = $credential->password;
        }


        return $credentials;
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
        $this->db->table('members')->where('username',$username)->update(['password'=>md5($newPassword)]);
	}
}