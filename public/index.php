<?php
require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\PostsController;
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/profile', [AuthController::class, 'profile']);

$app->router->get('/posts', [PostsController::class, 'all']);
$app->router->get('/posts/show', [PostsController::class, 'exact']);
$app->router->get('/posts/add', [PostsController::class, 'add']);
$app->router->post('/posts/add', [PostsController::class, 'add']);
$app->router->get('/posts/update', [PostsController::class, 'update']);
$app->router->post('/posts/update', [PostsController::class, 'update']);
$app->router->post('/posts/delete', [PostsController::class, 'delete']);


$app->run();