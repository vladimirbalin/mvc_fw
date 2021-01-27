<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\core\Response;
use app\models\Post;

class PostsController extends Controller
{

    public function all()
    {
        $postsModel = new Post();
        $postsModel->getAllPosts();
        return $this->render('posts', ['model' => $postsModel]);
    }

    public function exact(Request $request, Response $response, $params = [])
    {
        if (!isset($params['id'])) {
            $response->setStatusCode(404);
            throw new NotFoundException();
        }
        $postsModel = new Post();
        $postsModel->getPost($params['id']);
        return $this->render('showPost', ['model' => $postsModel]);
    }

    public function add(Request $request, Response $response)
    {
        $postsModel = new Post();
        if ($request->isPost()) {
            $postsModel->loadData($request->getBody());

            if ($postsModel->validate() && $postsModel->addPost()) {
                Application::$app->session->setFlash("success", "Post successfully added");
                $response->redirect('/posts');
            }
        }
        return $this->render('addPost', ['model' => $postsModel]);
    }

    public function update(Request $request, Response $response, $params = [])
    {
        $postsModel = new Post();
        $postsModel->getPost($params['id']);
        if ($request->isPost()) {
            $postsModel->loadData($request->getBody());
            if ($postsModel->validate() && $postsModel->updatePost($params['id'])) {
                Application::$app->session->setFlash("success", "Post successfully updated");
                $response->redirect('/posts');
            }
        }
        return $this->render('updatePost', ['model' => $postsModel]);
    }

    public function delete(Request $request, Response $response, $params = [])
    {
        $postsModel = new Post();
        $postsModel->getPost($params['id']);
        if ($request->isPost()) {
            if ($postsModel->deletePost($params['id'])) {
                Application::$app->session->setFlash("success", "Post successfully deleted");
            }
            $response->redirect('/posts');
        }
        return $this->render('showPost', ['model' => $postsModel]);
    }

}