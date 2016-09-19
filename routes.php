<?php
/**
 * Created by PhpStorm.
 * User: milosmarkovic
 * Date: 9/19/16
 * Time: 10:55 PM
 */

use Illuminate\Routing\Router;

$router->group(['namespace' => 'App\Controllers'], function (Router $router) {
    $router->get('/', ['uses' => 'SiteController@index']);
    $router->get('register', ['uses' => 'SiteController@register']);
    $router->get('login', ['uses' => 'SiteController@login']);
    $router->get('search', ['uses' => 'SiteController@search']);
});


$router->group(['namespace' => 'App\Controllers'], function (Router $router) {
    $router->post('register', ['uses' => 'UserController@register']);
    $router->post('login', ['uses' => 'UserController@login']);
    $router->post('search', ['uses' => 'UserController@searchUser']);
    $router->get('logout', ['uses' => 'UserController@logout']);
});