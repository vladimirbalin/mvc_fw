<?php

use app\core\form\Form;
use app\core\form\TextareaField;
use app\core\View;

/**
 * @var $model
 * @var $this View
 */
$this->title = 'Contact us';
$form = Form::begin('', "post"); ?>

    <div class="row">
        <div class="col-6 mx-auto">
            <div class="card car-body bg-light my-5">
                <h2 class="m-3 text-center">Contact us</h2>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo $form->field($model, 'subject'); ?>
                </div>
            </div>
            <div class="row">
                <?php echo $form->field($model, 'email'); ?>
            </div>
            <div class="row">
                <?php echo new TextareaField($model, 'body'); ?>
            </div>

            <div class="row">
                <div class="col ">
                    <button type="submit" class="btn btn-success w-100">Send</button>
                </div>
            </div>
        </div>
    </div>


<?php Form::end(); ?>