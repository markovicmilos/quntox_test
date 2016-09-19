<?php
/**
 * Created by PhpStorm.
 * User: milosmarkovic
 * Date: 9/19/16
 * Time: 10:43 PM
 */

require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Database\Capsule\Manager as Capsule;

$events = new Dispatcher(new Container);

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'quantox',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$router = new Router($events);
require_once 'routes.php';
$request = Request::capture();

$response = $router->dispatch($request);
$response->send();