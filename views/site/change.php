<div class="row">
    <div class="col-lg-5">

        <?php

        use yii\helpers\Html;
        use yii\widgets\ActiveForm;

        $form = ActiveForm::begin([
            'id' => 'change-form',
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'phone')->passwordInput() ?>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Изменить данные о себе', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>