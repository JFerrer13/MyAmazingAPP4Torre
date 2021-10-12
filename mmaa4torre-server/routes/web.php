<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('getUsers', [
    'as' => 'getUsers', 'uses' => 'UserController@getAll'
]);

$router->post('insertUser', [
    'as' => 'insertUser', 'uses' => 'UserController@insertUser'
]);

$router->get('getUserFromTorre/{user}', [
    'as' => 'getUserFromTorre', 'uses' => 'UserController@getUserFromTorre'
]);

$router->post('searchPeopleFromTorre/{params}', [
    'as' => 'searchPeopleFromTorre', 'uses' => 'UserController@searchPeopleFromTorre'
]);

$router->get('analyzeUsersData', [
    'as' => 'analyzeUsersData', 'uses' => 'UserController@analyzeUsersData'
]);