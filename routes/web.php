<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group([
    'middleware' => [
        'guest'
    ]
], function () {
    //Auth
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('/register', 'Auth\RegisterController@register');
});

Route::group([
    'middleware' => [
        'logged'
    ]
], function () {
    Route::get('/', function () {
        //return view('home');
        return redirect('/user/overrides');
    });

    //Auth
    Route::post('/logout', 'Auth\LoginController@logout');

    //User
    Route::get('/user', function () {
        return redirect('/user/profile');
    });
    Route::get('/user/edit', 'UserController@edit');
    Route::put('/user', 'UserController@update');
    Route::get('/user/profile', ['uses' => 'UserController@showProfile', 'as' => 'user.profile']);

    Route::get('/user/overrides', ['uses' => 'UserController@indexOverrides', 'as' => 'user.overrides.index']);
    Route::post('/user/overrides', 'UserController@storeOverride');
    Route::get('/user/overrides/nuevo', 'UserController@nuevoOverride');
    Route::get('/user/overrides/{id}/editar', ['uses' => 'UserController@editOverride', 'as' => 'user.overrides.edit']);
    Route::put('/user/overrides/{id}', ['uses' => 'UserController@updateOverride', 'as' => 'user.overrides.update']);
    Route::delete('/user/overrides/{id}', ['uses' => 'UserController@deleteOverride', 'as' => 'user.overrides.delete']);
    Route::get('/user/overrides/{id}', ['uses' => 'UserController@showOverride', 'as' => 'user.overrides.show']);



    Route::get('/user/jugadores', ['uses' => 'UserController@indexJugadores', 'as' => 'user.jugadores.index']);
    Route::post('/user/jugadores', 'UserController@storeJugador');
    Route::get('/user/jugadores/nuevo', 'UserController@nuevoJugador');
    Route::get('/user/jugadores/{id}/editar', ['uses' => 'UserController@editJugador', 'as' => 'user.jugadores.edit']);
    Route::put('/user/jugadores/{id}', ['uses' => 'UserController@updateJugador', 'as' => 'user.jugadores.update']);
    Route::delete('/user/jugadores/{id}', ['uses' => 'UserController@deleteJugador', 'as' => 'user.jugadores.delete']);
    Route::get('/user/jugadores/{id}', ['uses' => 'UserController@showJugador', 'as' => 'user.jugadores.show']);
});

//User Overrides for player
Route::get('/jugadores/{jugadorId}/recursos/{codes}',['uses' => 'UserController@jugadorRecursos', 'as' => 'user.jugador.recursos']);

//Recursos
Route::get('/recursos', ['as' => 'recursos.index', 'uses' => 'RecursosController@index']);
Route::get('/recursos/{id}/editar', ['as' => 'recursos.edit', 'uses' => 'RecursosController@edit']);
Route::get('/recursos/nuevo', ['as' => 'recursos.create', 'uses' => 'RecursosController@create']);
Route::get('/recursos/{id}', ['as' => 'recursos.show', 'uses' => 'RecursosController@show']);
Route::post('/recursos', ['as' => 'recursos.store', 'uses' => 'RecursosController@store']);
Route::put('/recursos/{id}', ['as' => 'recursos.store', 'uses' => 'RecursosController@update']);
Route::delete('/recursos/{id}', ['as' => 'recursos.delete', 'uses' => 'RecursosController@delete']);