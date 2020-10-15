<?php namespace App\Controllers;

class Search extends BaseController
{
	public function index()
	{
        
        $search = isset($_GET['s']) ? $_GET['s'] : null;
        echo $search;
		$this->renderTemplate('search/index.phtml');
	}

}