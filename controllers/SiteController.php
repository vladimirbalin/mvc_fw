<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function home()
    {
        return $this->render('home');
    }

    public function contact(Request $request)
    {
        $contactModel = new ContactForm();

        if($request->isPost()){
            $contactModel->loadData($request->getBody());
            if($contactModel->validate() && $contactModel->send()){
                Application::$app->session->setFlash('success', 'Thank you for contacting us.');
                Application::$app->response->redirect('/');
            }
            return $this->render('contact', ['model' => $contactModel]);
        }
        return $this->render('contact', ['model' => $contactModel]);
    }

}