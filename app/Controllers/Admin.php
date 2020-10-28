<?php namespace App\Controllers;

class admin extends BaseController
{
	public function index() {
		$loginModel = model('App\Models\LoginModel');
		if ($loginModel->userLoggedIn()) {
			$this->renderTemplate('admin/index.phtml');
		} else {
			echo "<script>alert('You have to be logged in to see this page!')</script>";
			echo "<script>window.location.href='/login';</script>";
		}
		
	}

	public function pages($page='index')
	{
		$loginModel = model('App\Models\LoginModel');
		if ($loginModel->userLoggedIn()) {
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
					$this->renderTemplate('admin/manage_products.phtml');
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

	public function rename_category() {
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
	public function delete_item() {
		$itemModel = model('App\Models\ItemModel');
		$itemId = $_POST['item_id'] ?? false;
		if ($itemId) {
			$itemModel->deleteItem($itemId);
			echo "<script>window.location.href='/admin/pages/manage_products';</script>";
		} else {
			echo "You must specify the item_id.";
			echo "<script>window.location.href='/admin/pages/manage_products';</script>";
		}
	}
	public function change_password() {
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

	public function logout() {
		$loginModel = model('App\Models\LoginModel');
		$loginModel->logout();
		echo "<script>alert('You closed your session.')</script>";
		echo "<script>window.location.href='/';</script>";
	}
}