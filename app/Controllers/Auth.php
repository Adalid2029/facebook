<?php

namespace App\Controllers;

use App\Libraries\Templater;
use App\Models\AuthModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
	protected $helpers = ['Fb'];
	function __construct()
	{
		$this->templater = new Templater(\Config\Services::request());
		$this->authModel = new AuthModel();
		$this->session = \Config\Services::session();
	}
	public function index()
	{
		return redirect()->to(base_url('/auth/login'));
	}

	public function login()
	{
		if (authenticated()) {
			return redirect()->to(base_url('/'));
		} else {
			$this->templater->login();
		}
	}

	public function authenticateFacebook()
	{
		$graphApi = json_decode($this->request->getPost('graphApi'));
		$authResponse = json_decode($this->request->getPost('authResponse'));
		return var_dump($authResponse->authResponse->userID);
		$userSearched = $this->authModel->where(array('id_api' => md5($authResponse->userID)))->findAll();
	}
	#authenticate = autentificar al usuario
	public function authenticate()
	{
		#Recibimos parametros username y password
		$username = trim($this->request->getPost('username'));
		$password = $this->request->getPost('password');
		#Bucasmos en la base de datos los 2 datos que nos mando el Login
		$userSearched = $this->authModel->where(array('nombre_usuario' => $username, 'clave' => md5($password)))->findAll();

		#Contamos si $userSearched es ugual a 1 si lo es entendemos que podemos aprobar el inicio de sesion
		if (count($userSearched) == 1) {
			# Agregamos una sesion al navegador
			$this->session->set(array('id_user' => $userSearched[0]['id_user']));
			# Redireccionamos a la pagina principal
			return redirect()->to(base_url('/'));
		}
		#Si $userSearched no es igual a 1 debemos devolverlo al mismo login 
		else {
			$this->session->destroy();
			return redirect()->to(base_url('/auth/login'));
		}
	}

	public function finish()
	{
		#Si existiese una sesion la eliminamos
		$this->session->destroy();
		#Redireccionamos de nuevo hacia el Login
		return redirect()->to(base_url('/auth/login'));
	}

	public function fields_sign_up()
	{
		return view('sign_up');
	}
}
