<?php

namespace App\Controllers;

class Search extends BaseController
{
	public function index()
	{
		$itemModel = model('App\Models\ItemModel');
		$items = $itemModel->getItems();
		$search = isset($_GET['s']) ? $_GET['s'] : null;
		if ($search) {
			$resultSet = [];
			foreach ($items as $item) {
				if (strpos(strtolower($item['name']), strtolower($search)) !== false || strpos(strtolower($item['description']), strtolower($search)) !== false) {
					$resultSet[] = $item;
				}
			}
			$data = [
				'items' => $resultSet,
				'search' => $search,
				'categories' => $itemModel->getCategories()
			];
			$this->renderTemplateView(view('search/search_result.phtml', $data));
		} else {
			$data = [
				'categories' => $itemModel->getCategories()
			];
			$this->renderTemplateView(view('search/index.phtml', $data));
		}
	}
}
