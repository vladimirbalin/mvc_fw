<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param string $path
     * @param callable|string $callback
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * @param string $path
     * @param callable|string $callback
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            /** @var Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->viewContent($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($view)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $view, $layoutContent);
    }

    protected function layoutContent()
    {
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        } else {
            $layout = Application::$app->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function viewContent($view, $params)
    {
        ob_start();
        if ($params) extract($params);
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}