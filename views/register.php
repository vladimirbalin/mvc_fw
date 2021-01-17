<?php use app\core\form\Form; ?>
<h1>Create an account</h1>
<?php $form = Form::begin('', "post"); ?>

<div class="row">
    <?php echo $form->field($model, 'firstname'); ?>
    <?php echo $form->field($model, 'lastname'); ?>
</div>
<div class="row">
    <?php echo $form->field($model, 'email'); ?>
</div>
<div class="row">
    <?php echo $form->field($model, 'password')->passwordField(); ?>
</div>
<div class="row">
    <?php echo $form->field($model, 'passwordConfirm')->passwordField(); ?>
</div>


<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end(); ?>


<!--<form action="" method="post">-->
<!--    <div class="row">-->
<!--        <div class="col">-->
<!--            <div class="mb-3">-->
<!--                <label>First name</label>-->
<!--                <input type="text" class="form-control --><? //= ($model->errors['firstName'] ? 'is-invalid' : '') ?><!--"-->
<!--                       name="firstName"-->
<!--                       value="--><? //= $model->firstName ?? null ?><!--">-->
<!--                <div class="invalid-feedback">-->
<!--                    --><?php //foreach ($model->errors['firstName'] as $msg) {
//                        echo $msg . "<br>";
//                    } ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col">-->
<!--            <div class="mb-3">-->
<!--                <label>Last name</label>-->
<!--                <input type="text" class="form-control" name="lastName" value="--><? //= $model->lastName ?? null ?><!--">-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="mb-3">-->
<!--        <label>Email</label>-->
<!--        <input type="text" class="form-control" name="email" value="--><? //= $model->email ?? null ?><!--">-->
<!--    </div>-->
<!--    <div class="mb-3">-->
<!--        <label>Password</label>-->
<!--        <input type="password" class="form-control" name="password">-->
<!--    </div>-->
<!--    <div class="mb-3">-->
<!--        <label>Confirm password</label>-->
<!--        <input type="password" class="form-control" name="passwordConfirm">-->
<!--    </div>-->
<!--    <button type="submit" class="btn btn-primary">Submit</button>-->
<!--</form>-->