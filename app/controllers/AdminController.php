<?php

class AdminController extends BaseController {

	private $_titulo = null;
	private $_user = null;
	private $_menu = null;
	private $_messages = null;
	
	public function __construct()
	{
		$this->_titulo = 'Acceso usuarios';
		$this->_menu = 'inicio';
		$this->_messages = array(
			'required'		=> 'Es obligatorio.',
			'email'			=> 'Ingrese su cuenta de email.',
			'string'		=> 'Solo se permite letras.',
			'digits'		=> 'Solo se permite números.',
			'dni.unique'	=> 'El dni ingresado ya está registrado en el sistema.',
			'email.unique'	=> 'El email ingresado ya está registrado en el sistema.',
			'codigo.unique' => 'El código ingresado ya está registrado en el sistema.'
		);
		try
		{
			// Get the current active/logged in user
			$this->_user = Sentry::getUser();
			View::share('user', $this->_user);
			View::share('menu', $this->_menu);
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// User wasn't found, should only happen if the user was deleted
			// when they were already logged in or had a "remember me" cookie set
			// and they were deleted.
		}
	}

	public function getLogin()
	{
		return View::make('login')->with('titulo', $this->_titulo);
	}
	
	public function getLogOut()
	{
		Sentry::logout();
		return Redirect::route('login');
	}
	
	public function postLogin()
	{
		$usuario = Input::get('usuario');
		
		$credentials = array(
			'usuario' => $usuario,
			'password' => Input::get('password')
		);

		try
		{
			$user = Sentry::authenticate($credentials, false);
			if ($user) {
				return Redirect::route('admin.index');
			}
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			return Redirect::route('login')
					->withErrors('Ingrese su usuario.');
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			return Redirect::route('login')
					->withErrors('Ingrese su contraseña.');
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
			return Redirect::route('login')
					->withErrors('Contraseña incorrecta, vuelva a intentar.');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::route('login')
					->withErrors('No se encontró el usuario ['.$usuario.']');
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			return Redirect::route('login')
					->withErrors('Usuario ['.$usuario.'] inactivo, no puede ingresar.');
		}
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
			return Redirect::route('login')
					->withErrors('Usuario ['.$usuario.'] está suspendido.');
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
			return Redirect::route('login')
					->withErrors('El usuario ['.$usuario.'] ha sido baneado.');
		}
		/*catch(\Exception $e)
		{
			return Redirect::route('login')
					->withErrors(array('login' => $e->getMessage()));
		}*/
	}
	
	public function getIndex()
	{
		$this->_titulo = 'Inicio - ';
		return View::make('admin.index')->with('titulo', $this->_titulo);
	}
	
	public function getUsuarios()
	{
		$mensaje = Input::get('mensaje', '');
		$this->_titulo = 'Usuarios - ';
		$this->_menu = 'usuarios';
		$users = Sentry::findAllUsers();
		return View::make('admin.usuario.listar')->with('titulo', $this->_titulo)
											->with('menu', $this->_menu)
											->with('usuarios', $users)
											->with('mensaje', $mensaje);
	}
	
	public function getUsuariosNuevo()
	{
		$mensaje = Input::get('mensaje', '');
		$this->_titulo = 'Usuarios - ';
		$this->_menu = 'usuarios';
		return View::make('admin.usuario.nuevo')->with('titulo', $this->_titulo)
											->with('menu', $this->_menu)
											->with('mensaje', $mensaje);
	}
	
	public function postUsuariosNuevo()
	{
		$mensaje = '';
		try
		{
			$user = Sentry::createUser(array(
				'tipo'			=> Input::get('tipo'),
				'usuario'		=> trim(Input::get('usuario')),
				'password'		=> Input::get('password'),
				'first_name'	=> ucwords(strtolower(trim(Input::get('first_name')))),
				'last_name'		=> ucwords(strtolower(trim(Input::get('last_name')))),
				'dni'			=> trim(Input::get('dni')),
				'email'			=> trim(Input::get('email')),
				'telefono'		=> trim(Input::get('telefono')),
				'direccion'		=> trim(Input::get('direccion')),
				'distrito'		=> Input::get('distrito'),
				'activated'		=> true,
			));
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			$mensaje = 'Ingrese el usuario.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			$mensaje = 'Ingrese el password.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			$mensaje = 'El usuario '. trim(Input::get('usuario')) .' ya existe.';
		}
		
		if ($mensaje != '')
			return Redirect::action('AdminController@getUsuariosNuevo', array('mensaje' => $mensaje));
		else
			return Redirect::action('AdminController@getUsuarios', array('mensaje' => 'Usuario registrado.'));
	}
	
	public function getUsuariosEditar($id)
	{
		$user = Sentry::findUserById($id);
		$mensaje = Input::get('mensaje', '');
		$this->_titulo = 'Usuarios - ';
		$this->_menu = 'usuarios';
		return View::make('admin.usuario.editar')->with('titulo', $this->_titulo)
											->with('menu', $this->_menu)
											->with('mensaje', $mensaje)
											->with('usuario', $user);
	}
	
	public function postUsuariosEditar()
	{
		$mensaje = '';
		try
		{
			$user = Sentry::createUser(array(
				'tipo'			=> Input::get('tipo'),
				'usuario'		=> trim(Input::get('usuario')),
				'password'		=> Input::get('password'),
				'first_name'	=> ucwords(strtolower(trim(Input::get('first_name')))),
				'last_name'		=> ucwords(strtolower(trim(Input::get('last_name')))),
				'dni'			=> trim(Input::get('dni')),
				'email'			=> trim(Input::get('email')),
				'telefono'		=> trim(Input::get('telefono')),
				'direccion'		=> trim(Input::get('direccion')),
				'distrito'		=> Input::get('distrito'),
				'activated'		=> true,
			));
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			$mensaje = 'Ingrese el usuario.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			$mensaje = 'Ingrese el password.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			$mensaje = 'El usuario '. trim(Input::get('usuario')) .' ya existe.';
		}
		
		if ($mensaje != '')
			return Redirect::action('AdminController@getUsuariosNuevo', array('mensaje' => $mensaje));
		else
			return Redirect::action('AdminController@getUsuarios', array('mensaje' => 'Usuario registrado.'));
	}
	
	public function getUsuariosBloquear($id)
	{
		$user = Sentry::findUserById($id);
		$user->activated = false;
		$user->save();
		return Redirect::route('usuarios');
	}
	
	public function getUsuariosActivar($id)
	{
		$user = Sentry::findUserById($id);
		$user->activated = true;
		$user->save();
		return Redirect::route('usuarios');
	}

	public function getPerfil()
	{
		$this->_titulo = 'Mi perfil - ';
		$this->_menu = 'perfil';
		return View::make('admin.usuario.perfil')->with('titulo', $this->_titulo)
										->with('menu', $this->_menu);
	}
	
}