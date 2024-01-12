<?php

require_once 'vendor/autoload.php'; 

use MyApp\Routes\Route;
use MyApp\Model\CategoryModel;

$router = new Route();
$categoryModel = new CategoryModel();


// Define routes for Dashmin
$router->post('/admin/add-category', function ($data) use ($categoryModel) {
    // Your logic for adding a category...
});


$router->get('/', function() {
    header('Location: View/auth/signup.php'); 
    exit;
});
$router->get('/admin/dashmin', function() {
    header('Location: View/admin/dashmin.php'); 
    exit;
});
$router->get('/wiki/list', function() {
    header('Location: View/user/wiki.php'); 
    exit;
});
$router->get('/wiki/detail', function() {
    header('Location: View/user/wikiDetail.php'); 
    exit;
});
$router->get('/wiki/signup', function() {
    header('Location: View/auth/signup.php'); 
    exit;
});
$router->get('/wiki/login', function() {
    header('Location: View/auth/login.php'); 
    exit;
});

// Handle the request
$router->handleRequest();

