<?php

namespace App\Controllers;

class Login extends BaseController
{
	public function index()
	{
		$itemModel = model('App\Models\ItemModel');
		$data = [
			'categories' => $itemModel->getCategories()
		];
		$this->renderTemplateView(view('login/index.phtml', $data));
	}
}
