<?php
/**
 * @var $model Post
 */

use app\core\form\Form;
use app\core\form\TextareaField;
use app\models\Post;

$form = new Form();
$postModel = $model->post;
?>
<div class="col-6 mx-auto my-4">
    <a href="/posts" class="btn btn-outline-dark"><i class="bi bi-arrow-left-circle-fill"></i>&nbsp;&nbsp;Back to
        posts</a>
    <div class="card car-body bg-light my-5">
        <h2 class="my-3 text-center">Update post</h2>
    </div>

    <?php Form::begin('', 'post'); ?>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <?= $form->field($postModel, 'title'); ?>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <?= new TextareaField($postModel, 'body'); ?>
    </div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn btn-success w-100">Update post</button>
        </div>
    </div>
    <?php Form::end(); ?>
</div>