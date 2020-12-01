<?php

namespace App\Controllers;

class admin extends BaseController
{
	public function index()
	{
		$loginModel = model('App\Models\LoginModel');
		if ($loginModel->userLoggedIn()) {
			$this->renderTemplate('admin/index.phtml');
		} else {
			echo "<script>alert('You have to be logged in to see this page!')</script>";
			echo "<script>window.location.href='/login';</script>";
		}
	}

	public function pages($page = 'index')
	{
		$loginModel = model('App\Models\LoginModel');
		if ($loginModel->userLoggedIn()) {
			$itemModel = model('App\Models\ItemModel');
			$data = [
				'items' => $itemModel->getItems(),
				'categories' => $itemModel->getCategories(),
				'itemModel' => $itemModel
			];
			switch ($page) {
				case 'manage_categories':
					$this->renderTemplateView(view('admin/manage_categories.phtml', $data));
					break;
				case 'manage_products':
					$this->renderTemplate('admin/manage_products.phtml');
					break;
				case 'add_product':
					if (!isset($_POST['item_name'])) {
						echo "You must specify a name";
					} else {
						$nameOfPicture = $_FILES['item_image']['tmp_name'];
						$section = explode(".", $_FILES['item_image']['name']);
						$extension = end($section);
						$newNamePicture = $_POST['item_name'] . "." . $extension;
						if (empty($nameOfPicture)) {
							$imagePath = "/img/no-image.png";
						} else {
							$imagePath = "/img/articles/" . $newNamePicture;
						}

						move_uploaded_file($nameOfPicture, "./img/articles/" . $newNamePicture);
						$item = [
							"name" => $_POST['item_name'],
							"category_id" => !empty($_POST['item_category']) ? $_POST['item_category'] : "Not specified",
							"price" => empty($_POST['item_price']) ? "Free" : ($_POST['item_price'] == 0 ? "Free" : $_POST['item_price']),
							"image1" => $imagePath,
							"rating" => !empty($_POST['item_rating']) ? $_POST['item_rating'] : 0,
							"description" => !empty($_POST['item_description']) ? $_POST['item_description'] : "No Description Available",
						];
						$itemModel->addItem($item);
						$this->renderTemplateView(view('admin/item_added.phtml', ["item" => $item]));
					}

					break;
				case 'change_password':
					$this->renderTemplate('admin/change_password.phtml');
					break;
				default:
					echo "page not found";
					break;
			}
		} else {
			echo "<script>alert('You have to be logged in to see this page!')</script>";
			echo "<script>window.location.href='/login';</script>";
		}
	}

	public function rename_category()
	{
		$itemModel = model('App\Models\ItemModel');
		$previousCategory = $_POST['previous_category'] ?? false;
		$newCategory = $_POST['new_category'] ?? false;
		$description = $_POST['description'] ?? false;

		if ($previousCategory && $newCategory) {
			$itemModel->renameCategory($previousCategory, $newCategory, $description);
			echo "<script>window.location.href='/admin/pages/manage_categories';</script>";
		} else {
			echo "You must specify the previous category and the new category name.";
			echo "<script>window.location.href='/admin/pages/manage_categories';</script>";
		}
	}

	public function add_category()
	{
		$itemModel = model('App\Models\ItemModel');

		$name =  $_POST['category_name'] ?? false;
		$description =  $_POST['category_description'] ?? false;

		if ($name && $description) {
			$itemModel->addCategory($name, $description);
			echo "<script>window.location.href='/admin/pages/manage_categories';</script>";
		} else {
			echo "You must specify the previous category and the new category name.";
			echo "<script>window.location.href='/admin/pages/manage_categories';</script>";
		}
	}

	public function delete_item()
	{
		$itemModel = model('App\Models\ItemModel');
		$itemId = $_POST['item_id'] ?? false;
		if ($itemId) {
			$itemModel->deleteItem($itemId);
			// echo "<script>window.location.href='/admin/pages/manage_products';</script>";
		} else {
			echo "You must specify the item_id.";
			echo "<script>window.location.href='/admin/pages/manage_products';</script>";
		}
	}

	public function edit_product()
	{
		$itemModel = model('App\Models\ItemModel');
		$item = [
			"id" => $_POST['item_id'],
			"name" => $_POST['item_name'],
			"category" => !empty($_POST['item_category']) ? $_POST['item_category'] : "Not specified",
			"price" => empty($_POST['item_price']) ? "Free" : ($_POST['item_price'] == 0 ? "Free" : $_POST['item_price']),
			"image" => !empty($_POST['item_image']) ? $_POST['item_image'] : "/img/no-image.png",
			"rating" => !empty($_POST['item_rating']) ? $_POST['item_rating'] : 0,
			"quantity" => !empty($_POST['item_quantity']) ? $_POST['item_quantity'] : 0,
			"description" => !empty($_POST['item_description']) ? $_POST['item_description'] : "No Description Available",
		];
		echo "<script>window.location.href='/admin/pages/manage_products';</script>";
		$itemModel->editItem($item);
	}

	public function change_password()
	{
		$loginModel = model('App\Models\LoginModel');
		$newPassword = $_POST['new_password'] ?? false;

		if ($newPassword) {
			$loginModel->changePassword($newPassword);
			echo "<script>window.location.href='/admin';</script>";
		} else {
			echo "You must specify the new password.";
			echo "<script>window.location.href='/admin/pages/change_password';</script>";
		}
	}

	public function logout()
	{
		$loginModel = model('App\Models\LoginModel');
		$loginModel->logout();
		echo "<script>alert('You closed your session.')</script>";
		echo "<script>window.location.href='/';</script>";
	}
}
