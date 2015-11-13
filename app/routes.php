<?php

Route::get('/', function()
{
	return View::make('hello');
});

// ingresa usuario admin
// ruta de prueba
Route::get('/crea-usuario', 'HomeController@creaUsuario');

// inicio de rutas para el admin

// login
Route::get('/', array('as' => 'login', 'uses' => 'AdminController@getLogin'));
Route::post('/login', array('uses' => 'AdminController@postLogin'));

// rutas agrupadas para admin
// filtro para auth
Route::group(array('before' => 'auth.admin'), function()
{
	Route::get('/admin', array('as' => 'admin.index', 'uses' => 'AdminController@getIndex'));
	Route::get('/admin/salir', array('as' => 'logout', 'uses' => 'AdminController@getLogOut'));
	Route::get('/admin/perfil-usuario', array('as' => 'perfil', 'uses' => 'AdminController@getPerfil'));
	
	Route::get('/admin/usuarios', array('as' => 'usuarios', 'uses' => 'AdminController@getUsuarios'));
	Route::get('/admin/usuarios/nuevo', array('as' => 'usuariosNuevo', 'uses' => 'AdminController@getUsuariosNuevo'));
	Route::post('/admin/usuarios/nuevo', array('uses' => 'AdminController@postUsuariosNuevo'));
	Route::get('/admin/usuarios/editar/{id}', array('uses' => 'AdminController@getUsuariosEditar'));
	Route::post('/admin/usuarios/editar', array('uses' => 'AdminController@postUsuariosEditar'));
	Route::get('/admin/usuarios/bloquear/{id}', array('uses' => 'AdminController@getUsuariosBloquear'));
	Route::get('/admin/usuarios/activar/{id}', array('uses' => 'AdminController@getUsuariosActivar'));
	
	Route::get('/admin/listar-pedidos', array('as' => 'pedidos', 'uses' => 'PedidosController@getPedidos'));
	Route::get('/admin/paginas/inicio', array('uses' => 'AdminController@getPaginasInicio'));
	
	Route::get('/admin/importar-datos', array('as' => 'stock', 'uses' => 'ProductosController@getStock'));
	Route::post('/admin/stock', array('uses' => 'ProductosController@postStock'));
});

// filtro auth
Route::filter('auth.admin', function()
{
	if (!Sentry::check()) {
		return Redirect::route('login');
	}
});

// ajax
Route::post('/ubigeo', array('as' => 'ubigeo', 'uses' => 'UbigeoController@postDistrito'));
