<?php namespace App\Controllers;

class Login extends BaseController
{
	public function index()
	{
		$loginModel = model('App\Models\LoginModel');
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$credentials = $loginModel->getCredentials();
			if($_POST["username"] == $credentials[0] && md5($_POST["password"]) == $credentials[1]){
				header("Location: /admin");
			}
			else{
				echo "Wrong credentials";
			}
		}
		else{
			$this->renderTemplate('login/index.phtml');
		}
	}

}