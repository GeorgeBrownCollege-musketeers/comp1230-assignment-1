<?php namespace App\Controllers;

class Items extends BaseController
{
	public function index()
	{
		$itemModel = model('App\Models\ItemModel');
		$data = [
			"items" => $itemModel->readItems()
		];
		$this->renderTemplateView(view('items/index.phtml', $data));
	}

}