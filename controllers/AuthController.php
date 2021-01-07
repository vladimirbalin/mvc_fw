<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->layout = 'auth';
        if($request->isPost()){
            return 'Handle submitted data login page';
        }
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $this->layout = 'auth';
        if($request->isPost()){
            return 'Handle submitted data';
        }
        return $this->render('register');
    }
}