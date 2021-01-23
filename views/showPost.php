<?php
/**
* @var $model PostModel
 */

use app\models\PostModel;
$post = $model->post;
?>

<div class="row">
    <div class="col-6 mx-auto my-4">
        <a href="/posts" class="btn btn-outline-dark"><i class="bi bi-arrow-left-circle-fill"></i>&nbsp;&nbsp;Back to
            posts</a>
    </div>
</div>
<div class="row">
    <div class="col-6 bg-secondary text-white mx-auto p-2 mb-2">
        Written by <?= $post->firstname ?> on <?= $post->created_at ?>
    </div>
</div>
<div class="row">
    <div class="col-6 mx-auto">
        <p class="fw-bolder"><?=$post->title?></p>
        <p><?= $post->body ?></p>

        <?php if ($post->user_id == $_SESSION['user_id']): ?>
            <a href="/posts/edit/<?= $post->post_id ?>" class="btn btn-dark float-start">Edit</a>
            <form action="/posts/delete/<?=$post->post_id?>" method="post">
                <input type="submit" value="Delete" class="btn btn-danger float-end">
            </form>
        <?php endif; ?>
    </div>
</div>