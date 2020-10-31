<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}

	public function renderTemplate($yield) {
		$itemModel = model('App\Models\ItemModel');
		echo view('templates/header.phtml');
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$data = [
			'user_is_logged_in' => $_SESSION['user_logged_in'] ?? false,
			'categories' => $itemModel->getCategories()
		];
		echo view('templates/navbar.phtml', $data);
		echo view($yield);
		echo view('templates/footer.phtml');
	}

	public function renderTemplateView($view) {
		$loginModel = model('App\Models\LoginModel');
		$itemModel = model('App\Models\ItemModel');
		echo view('templates/header.phtml');
		$data = [
			'user_is_logged_in' => $_SESSION['user_logged_in'] ?? false,
			'categories' => $itemModel->getCategories()
		];
		echo view('templates/navbar.phtml', $data);
		echo $view;
		echo view('templates/footer.phtml');
	}
}
