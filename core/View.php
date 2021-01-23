<?php


namespace app\core;


class View
{
    public string $title = '';

    public function renderView($view, $params = [])
    {
        $viewContent = $this->viewContent($view, $params);
        $layoutContent = $this->layoutContent();
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