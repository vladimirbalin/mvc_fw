<?php
use app\core\form\Form;
use app\core\View;
use app\models\LoginForm;

/**
 * @var $model LoginForm
 * @var $this View
 */
$this->title = 'Login page';
$form = Form::begin('', "post"); ?>

<div class="row">
    <div class="col-6 mx-auto">
        <div class="card car-body bg-light my-5">
            <h2 class="m-3 text-center">Login page</h2>
        </div>
        <div class="row">
            <?php echo $form->field($model, 'email'); ?>
        </div>
        <div class="row">
            <?php echo $form->field($model, 'password')->passwordField(); ?>
        </div>
        <div class="row">
            <div class="col ">
                <button type="submit" class="btn btn-success w-100">Log in</button>
            </div>
            <div class="col pt-2"><p>Don't have an account? <a href="/register">Create one</a></p></div>
        </div>
    </div>
</div>

<?php Form::end(); ?>
