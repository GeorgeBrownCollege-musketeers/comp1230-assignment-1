<?php namespace App\Controllers;

class Login extends BaseController
{
	public function index()
	{
		$loginModel = model('App\Models\LoginModel');
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$credentials = $loginModel->getCredentials();
			if($_POST["username"] == $credentials[0] && md5($_POST["password"]) == $credentials[1]){
				$loginModel->login();
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

	public function logout() {
		$loginModel = model('App\Models\LoginModel');
		$loginModel->logout();
		echo "<script>alert('You closed your session.')</script>";
		echo "<script>window.location.href='/';</script>";
	}

}