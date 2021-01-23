<?php


namespace app\controllers;


use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\core\Response;
use app\models\PostModel;

class PostsController extends Controller
{
    public function posts()
    {
        $postsModel = new PostModel();
        $postsModel->getAllPosts();
        return $this->render('posts', ['model' => $postsModel]);
    }

    public function show(Request $request, Response $response, $params = [])
    {
        if(!isset($params['id'])){
            $response->setStatusCode(404);
            throw new NotFoundException();
        }
        $postsModel = new PostModel();
        $postsModel->getPost($params['id']);
        return $this->render('showPost', ['model' => $postsModel]);
    }
}