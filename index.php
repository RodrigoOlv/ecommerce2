<?php 
session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {//Rota do Index
    
	$page = new Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {//Rota do Admin

	User::verifyLogin();
    
	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function() {//Rota Tela Login

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function(){ //Rota de login

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get("/admin/logout", function(){ //Rota de Logout

	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->run();
