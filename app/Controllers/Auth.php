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

	public function authenticate()
	{
		$username = trim($this->request->getPost('username'));
		$password = $this->request->getPost('password');
		$userSearched = $this->authModel->where(array('username' => $username, 'pass' => md5($password)))->findAll();

		if (count($userSearched) == 1) {
			$this->session->set(array('id_user' => $userSearched[0]['id_user']));
			return redirect()->to(base_url('/'));
		} else {
			(new Auth)->finish();
		}
	}

	public function finish()
	{
		$this->session->destroy();
		return redirect()->to(base_url('/auth/login'));
	}

	public function fields_sign_up()
	{
		return view('sign_up');
	}
}
