<?php

namespace App\Controllers;

use App\Libraries\Templater;
use App\Models\Querys;
use CodeIgniter\Controller;

class Auth extends Controller
{
	protected $helpers = ['Fb'];
	function __construct()
	{
		$this->templater = new Templater(\Config\Services::request());
		$this->session = \Config\Services::session();
		$this->querys = new Querys();
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
		if ($this->insertarUsuarioFacebook($graphApi, $authResponse)) {
			$userSearched = $this->querys->view_usuarios('select', ['id_api' => md5($authResponse->authResponse->userID)]);
		} else {
			return $this->response->setJSON(array('error' => 'Error al iniciar sesión con Facebook'));
		}

		$this->session->set(array('id_api' => $userSearched[0]['id_api']));
		return $this->response->setJSON(array('exito' => true));
	}
	#authenticate = autentificar al usuario
	public function authenticate()
	{
		#Recibimos parametros username y password
		$username = trim($this->request->getPost('username'));
		$password = $this->request->getPost('password');
		#Bucasmos en la base de datos los 2 datos que nos mando el Login
		$userSearched = $this->querys->view_usuarios('select', ['nombre_usuario' => $username, 'clave' => md5($password)]);
		return var_dump($userSearched);
		#Contamos si $userSearched es ugual a 1 si lo es entendemos que podemos aprobar el inicio de sesion
		if (count($userSearched) == 1) {
			# Agregamos una sesion al navegador
			$this->session->set(array('id_usuario' => $userSearched[0]['id_usuario']));
			# Redireccionamos a la pagina principal
			return redirect()->to(base_url('/'));
		}
		#Si $userSearched no es igual a 1 debemos devolverlo al mismo login 
		else {
			$this->session->destroy();
			return redirect()->to(base_url('/auth/login'));
		}
	}
	public function insertarUsuarioFacebook($graphApi, $authResponse)
	{
		try {
			$idPersona = $this->insertarPersona(
				$graphApi->id,
				[
					'id_api_facebook' => $graphApi->id,
					'nombres' => isset($graphApi->first_name) ? $graphApi->first_name : null,
					'apellidos' => isset($graphApi->last_name) ? $graphApi->last_name : null,
					'fecha_nacimiento' => isset($graphApi->birthday) ? date_format(date_create($graphApi->birthday), "Y-m-d") : null,
					'genero' => isset($graphApi->gender) ? $graphApi->gender : null,
					'tipo' => 'API',
					'url_perfil_facebook' => isset($graphApi->link) ? $graphApi->link : null,
					'url_imagen_facebook' => isset($graphApi->picture->data->url) ? $graphApi->picture->data->url : null
				]
			);

			$idCorreoElectronico = $this->insertarCorreo($idPersona, $graphApi->email);

			$idUsuario = $this->insertarUsuario($idPersona, $authResponse->authResponse->userID);
			$idGrupoUsuario = $this->insertarGrupoUsuario(
				$idUsuario,
				$this->querys->grupo('select', null, ['nombre' => 'VISOR'])[0]['id_grupo'],
				['id_usuario' => $idUsuario, 'id_grupo' => $this->querys->grupo('select', null, ['nombre' => 'VISOR'])[0]['id_grupo']]
			);
			return true;
		} catch (\Exception $e) {
			die($e->getMessage());
			return false;
		}
	}
	public function insertarGrupoUsuario($idUsuario, $idGrupo, $datos)
	{
		$existeGrupoUsuario = $this->querys->grupo_usuario('select', null, ['id_usuario' => $idUsuario, 'id_grupo' => $idGrupo]);
		if (count($existeGrupoUsuario) == 0) {
			return $this->querys->grupo_usuario(
				'insert',
				$datos
			);
		} elseif (count($existeGrupoUsuario) == 1) {
			return $this->querys->grupo_usuario(
				'update',
				$datos,
				['id_usuario' => $idUsuario, 'id_grupo' => $idGrupo]
			);
			return $existeGrupoUsuario[0]['id_grupo_usuario'];
		}
		return false;
	}
	public function insertarUsuario($idPersona, $idApi)
	{
		$existeUsuario = $this->querys->usuario('select', null, ['id_usuario' => $idPersona, 'id_api' => md5($idApi)]);
		if (count($existeUsuario) == 0) {
			return $this->querys->usuario(
				'insert',
				[
					'id_usuario' => $idPersona,
					'id_api' => md5($idApi)
				]
			);
		} elseif (count($existeUsuario) == 1) {
			return $existeUsuario[0]['id_usuario'];
		}
		return false;
	}

	public function insertarCorreo($idPersona, $correo)
	{
		$existeCorreo = count($this->querys->correo_electronico('select', null, ['id_persona' => $idPersona, 'correo' => $correo]));
		if ($existeCorreo == 0) {
			return $this->querys->correo_electronico(
				'insert',
				[
					'id_persona' => $idPersona,
					'correo' => $correo
				]
			);
		}
		return false;
	}

	public function insertarPersona($idApiFacebook, $datos)
	{
		$existePersona = $this->querys->persona('select', null, ['id_api_facebook' => $idApiFacebook]);
		if (count($existePersona) == 0) {
			return $this->querys->persona(
				'insert',
				$datos
			);
		} elseif (count($existePersona) == 1) {
			$this->querys->persona(
				'update',
				$datos,
				['id_api_facebook' => $idApiFacebook]
			);
			return $existePersona[0]['id_persona'];
		}
		return false;
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
