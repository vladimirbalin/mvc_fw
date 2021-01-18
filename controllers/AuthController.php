<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->isPost()){
            return 'Handle submitted data login page';
        }
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $User = new User();

        if($request->isPost()){
            $User->loadData($request->getBody());
            if($User->validate() && $User->save()){
                return 'Success';
            }
            return $this->render('register', ['model' => $User]);
        }

        return $this->render('register', ['model' => $User]);
    }
}