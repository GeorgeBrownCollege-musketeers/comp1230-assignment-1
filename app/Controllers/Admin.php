<?php

namespace App\Controllers;

class admin extends BaseController
{
	public function index()
	{
		$itemModel = model('App\Models\ItemModel');
		$data = [
			"categories" => $itemModel->getCategories()
		];

		$this->renderTemplateView(view('admin/index.phtml', $data));
	}

	public function pages($page = 'index')
	{
		$itemModel = model('App\Models\ItemModel');
		$data = [
			"categories" => $itemModel->getCategories()
		];

		switch ($page) {
			case 'manage_categories':
				$this->renderTemplateView(view('admin/manage_categories.phtml', $data));
				break;
			case 'manage_products':
				$this->renderTemplateView(view('admin/manage_products.phtml', $data));
				break;
			case 'change_password':
				$this->renderTemplateView(view('admin/change_password.phtml', $data));
				break;
			default:
				echo "page not found";
				break;
		}
	}
}
