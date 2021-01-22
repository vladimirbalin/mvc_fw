<?php

namespace app\core;

use app\models\User;

class Application
{
    public string $layout = 'main';
    public static string $ROOT_DIR;
    public ?User $user;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public ?Controller $controller = null;
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

        $primaryValue = $this->session->get('user');
        if ($primaryValue = $this->session->get('user')) {
            $primaryKey = User::primaryKey();
            $this->user = User::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
//        var_dump($this);

    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->router->renderView('_errorPage', ['exception' => $e]);
        }
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
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
    }

    public function logout()
    {
        $this->user = null;
        $this->session->unset('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

}