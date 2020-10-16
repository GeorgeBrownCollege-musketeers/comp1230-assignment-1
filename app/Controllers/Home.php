<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$itemModel = model('App\Models\ItemModel');
		$data = [
			"categories" => $itemModel->getCategories()
		];
		return $this->renderTemplateView(view('home/index.phtml', $data));
	}

	//--------------------------------------------------------------------

}
