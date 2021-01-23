<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {
        $loginModel = new LoginForm();
        if ($request->isPost()) {
            $loginModel->loadData($request->getBody());
            if ($loginModel->validate() && $loginModel->login()) {
                Application::$app->session->setFlash('success', 'Login successfully');
                $response->redirect('/');
            }
        }
        return $this->render('login', ['model' => $loginModel]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function register(Request $request, Response $response)
    {
        $userModel = new User();

        if ($request->isPost()) {
            $userModel->loadData($request->getBody());
            if ($userModel->validate() && $userModel->save()) {
                Application::$app->session->setFlash('success', 'Registration completed successfully, you can log in now.');
                $response->redirect('/login');
            }
        }
        return $this->render('register', ['model' => $userModel]);
    }

    public function profile()
    {
        return $this->render('profile');
    }
}