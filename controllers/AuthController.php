<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isPost()) {
            return 'Handle submitted data login page';
        }
        return $this->render('login');
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