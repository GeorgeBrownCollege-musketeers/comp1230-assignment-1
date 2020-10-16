<?php

namespace App\Controllers;

class Items extends BaseController
{
	public function index()
	{
		$itemModel = model('App\Models\ItemModel');
		$category = isset($_GET['category']) ? $_GET['category'] : null;
		if ($category) {
			$items = $itemModel->getItemsByCategory($category);
		} else {
			$items = $itemModel->getItems();
		}

		$data = [
			"items" => $items,
			"categories" => $itemModel->getCategories()
		];
		$this->renderTemplateView(view('items/index.phtml', $data));
	}
}
