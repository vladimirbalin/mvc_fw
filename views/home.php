<?php

use app\core\Application;

?>
<h1>Home</h1>
<h3>
    Welcome, <?= Application::isGuest() ?
        "Guest" :
        Application::$app->user->firstname . " " . Application::$app->user->lastname ?>
!</h3>