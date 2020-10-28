<?php

namespace App\Controllers;

class Login extends BaseController
{
	public function index()
	{
		$loginModel = model('App\Models\LoginModel');
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$credentials = $loginModel->getCredentials();
			if(array_key_exists($_POST["username"],$credentials) && md5($_POST["password"]) == $credentials[$_POST['username']]){
				$loginModel->login($_POST["username"]);
				echo "Redirecting to Admin Page...";
				echo "<script>window.location.href='/admin';</script>";
			}
			else{
				echo "<script>alert('Wrong Credentials, please try again')</script>";
				echo "<script>window.location.href='/login';</script>";
			}
		}
		else{
			$this->renderTemplate('login/index.phtml');
		}
	}
}
