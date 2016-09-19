<?php
namespace App\Controllers;

require 'vendor/mustache/mustache/src/Mustache/Autoloader.php';

class SiteController
{
    private $view;

    public function __construct()
    {
        \Mustache_Autoloader::register();
        $this->view = new \Mustache_Engine(array(
            'loader' => new \Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/Views', ['extension' => '.html']),
        ));
    }

    public function index()
    {
        return $this->view->render('index');
    }

    public function register()
    {
        return $this->view->render('register');
    }

    public function login()
    {
        return $this->view->render('login');
    }

    public function search()
    {
        return $this->view->render('search');
    }

}