<?php namespace App\Controllers;

class Items extends BaseController
{
	public function index()
	{
		$this->renderTemplate('items/index.phtml');
	}

}