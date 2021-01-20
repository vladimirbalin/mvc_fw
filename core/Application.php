<?php

namespace app\core;

use app\models\User;

class Application
{
    public ?User $user = null;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Controller $controller;
    public Session $session;
    public static Application $app;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->db = new Database($config['db']);

        if ($this->session->get('user')) {
            $this->user = $_SESSION['user'];
        }
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(User $user)
    {
        $this->user = $user;
//        $primaryKey = $user->primaryKey();
//        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $user);
    }

    public function logout()
    {
        $this->session->unset('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

}