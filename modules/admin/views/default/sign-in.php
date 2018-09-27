<?php

use yii\bootstrap\ActiveForm;

?>

<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin() ?>

                <h1>Login Form</h1>
                <div>
                    <?= $form->field($model, 'email')->textInput()->label(false) ?>
                </div>
                <div>
                    <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
                </div>
                <div>
                    <button type="submit" class="btn btn-default submit">Log in</button>
                </div>
                <?php ActiveForm::end() ?>
            </section>
        </div>
    </div>
</div>