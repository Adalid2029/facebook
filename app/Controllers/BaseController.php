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

use App\Libraries\Templater;
use CodeIgniter\Controller;
use App\Models\AuthModel;

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */

	protected $helpers = ['Fb', 'url'];
	public $session = null;
	public $templater = null;
	public $authModel = null;
	protected $user = null;
	protected $data = array();
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->templater = new Templater(\Config\Services::request());
		$this->authModel = new AuthModel();
	}
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		$this->user = authenticated();
		if (!$this->user) {
			return $this->response->redirect(base_url('/auth/login'));
		}
		$this->data['user'] = $this->user;

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}
}
