<?php

use app\core\Application;
use app\core\Model;
use app\core\View;

/**
 * @var $this View
 * @var $model Model
 */

$this->title = 'Home page';
?>
<div class="text-center my-4">
    <h1>Home</h1>
    <h3>
        Welcome, <?= Application::isGuest() ?
            "Guest" :
            Application::$app->getDisplayName() ?>!</h3>
</div>