<?php

namespace App\Controllers;

use App\Models\ItemModel;

class Home extends BaseController
{
	public function index()
	{
		$itemModel = model('App\Models\ItemModel');
		$data = [
			"categories" => $itemModel->getCategories(),
			"items" => $itemModel->getItems()
		];
		return $this->renderTemplateView(view('home/index.phtml', $data));
	}

	//--------------------------------------------------------------------

}
