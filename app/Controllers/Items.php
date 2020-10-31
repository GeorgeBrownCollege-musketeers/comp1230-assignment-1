<?php

namespace App\Controllers;

class Items extends BaseController
{
	public function index()
	{
		$itemModel = model('App\Models\ItemModel');
		$loginModel = model('App\Models\LoginModel');
		$category = isset($_GET['category']) ? $_GET['category'] : null;
		if ($category) {
			$items = $itemModel->getItemsByCategory($category);
		} else {
			$items = $itemModel->getItems();
		}

		$data = [
			"items" => $items,
			"categories" => $itemModel->getCategories(),
			"user_is_logged_in" => $loginModel->userLoggedIn(),
			"itemModel" => $itemModel
		];
		$this->renderTemplateView(view('items/index.phtml', $data));
	}
}
