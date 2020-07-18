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
use Mpdf\Mpdf;

use CodeIgniter\Controller;
use App\Models\AuthModel;
use App\Models\DataPoliticModel;
use App\Models\Comentario;
use App\Models\Publicacion;
use App\Models\Persona;
use App\Models\Querys;
use Sentiment\Analyzer;
use Statickidz\GoogleTranslate;


class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */

	protected $helpers = ['Fb', 'url', 'simple_html_dom'];
	public $session = null;
	public $templater = null;
	public $authModel = null;
	public $dataPoliticModel = null;
	public $publicacion = null;
	public $comentario = null;
	public $persona = null;
	public $querys = null;
	public $mpdf = null;
	public $analyzer = null;
	public $trans = null;


	protected $user = null;
	protected $data = array();
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->templater = new Templater(\Config\Services::request());
		$this->mpdf = new Mpdf(['format' => 'Legal', 'mode' => 'utf-8']);

		$this->authModel = new AuthModel();
		$this->dataPoliticModel = new DataPoliticModel();
		$this->publicacion = new Publicacion();
		$this->comentario = new Comentario();
		$this->persona = new Persona();
		$this->querys = new Querys();
		$this->analyzer = new Analyzer();
		$this->trans = new GoogleTranslate();
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
