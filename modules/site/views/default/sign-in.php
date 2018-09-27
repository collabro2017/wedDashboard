<div class="col-sm-12 content">
    <div class="header">
        <h2 class="text-center">LOGIN TO A WEDDING</h2>
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">

                <?php

                $form = \yii\widgets\ActiveForm::begin([]);

                echo $form->field($model, 'email')->textInput([
                    'placeholder' => 'EMAIL',
                    'autofocus'   => 'autofocus'
                ])->label(false);

                echo $form->field($model, 'code')->textInput([
                    'placeholder' => 'WEDDING CODE'
                ])->label(false);

                echo \yii\helpers\Html::submitButton('Sign In', [
                    'class' => 'btn btn-submit btn-block'
                ]);

                $form->end();

                ?>

                <br/>

                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-left">
                            <a href="<?= \yii\helpers\Url::to(['/couple/info/index']) ?>"
                               class="color-light">Bride & groom sign in</a>
                        </p>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>