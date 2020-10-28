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
			'items' => $itemModel->getItems(),
			'categories' => $itemModel->getCategories()
		];
		switch ($page) {
			case 'manage_categories':
				$this->renderTemplateView(view('admin/manage_categories.phtml', $data));
				break;
			case 'manage_products':
				$this->renderTemplateView(view('admin/manage_products.phtml', $data));
				break;
			case 'add_product':
				if (!isset($_POST['item_name'])) {
					echo "You must specify a name";
				} else {
					$item = [
						"name" => $_POST['item_name'],
						"category" => !empty($_POST['item_category']) ? $_POST['item_category'] : "Not specified",
						"price" => !empty($_POST['item_price']) ? $_POST['item_price'] : 0,
						"image" => !empty($_POST['item_image']) ? $_POST['item_image'] : "/img/no-image.png",
						"rating" => !empty($_POST['item_rating']) ? $_POST['item_rating'] : 0,
						"quantity" => !empty($_POST['item_quantity']) ? $_POST['item_quantity'] : 0,
					];
					$itemModel->addItem($item);
					$this->renderTemplateView(view('admin/item_added.phtml', ["item" => $item]));
				}

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
