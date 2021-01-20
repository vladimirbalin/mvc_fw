<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginModel = new LoginForm();
        if ($request->isPost()) {
            $loginModel->loadData($request->getBody());
            if ($loginModel->validate() && $loginModel->login()) {
                Application::$app->session->setFlash('success', 'Login successfully');
                Application::$app->response->redirect('/');
            }
            return $this->render('login', ['model' => $loginModel]);
        }
        return $this->render('login', ['model' => $loginModel]);
    }

    public function logout()
    {
        Application::$app->logout();
        Application::$app->response->redirect('/');
    }
    public function register(Request $request)
    {
        $userModel = new User();

        if ($request->isPost()) {
            $userModel->loadData($request->getBody());
            if ($userModel->validate() && $userModel->save()) {
                Application::$app->session->setFlash('success', 'Registration completed successfully');
                Application::$app->response->redirect('/');
            }
            return $this->render('register', ['model' => $userModel]);
        }

        return $this->render('register', ['model' => $userModel]);
    }
}