<?php

namespace App\Controllers;

use App\Models\ItemModel;

class Home extends BaseController
{
	public function index()
	{
		$maintenanceModel = model('App\Models\MaintenanceModel');
		if ($maintenanceModel->isUnderMaintenance()) {
			return view('maintenance/index.phtml', ["message"=> $maintenanceModel->getMessage()]);
		} else {
			$itemModel = model('App\Models\ItemModel');
			$data = [
				"categories" => $itemModel->getCategories(),
				"items" => $itemModel->getItems()
			];
			return $this->renderTemplateView(view('home/index.phtml', $data));
		}
	}

	//--------------------------------------------------------------------

}
