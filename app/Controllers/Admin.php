<?php namespace App\Controllers;

class admin extends BaseController
{
	public function index() {
		$this->renderTemplate('admin/index.phtml');
	}

	public function pages($page='index')
	{
		switch ($page) {
			case 'manage_categories':
				$this->renderTemplate('admin/manage_categories.phtml');
				break;
			case 'manage_products':
				$this->renderTemplate('admin/manage_products.phtml');
				break;
			case 'change_password':
				$this->renderTemplate('admin/change_password.phtml');
				break;
			default:
				echo "page not found";
				break;
		}
	}

}