<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\RegisterForm $model */

use app\models\DocType;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\JqueryAsset;

$this->title = 'Моя Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
            ]); ?>
            <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'value' => 'v-']) ?>
            <?= $form->field($model, 'surname')->textInput(['autofocus' => true, 'value' => 'v-']) ?>
            <?= $form->field($model, 'patronymic')->textInput(['autofocus' => true, 'value' => 'v-']) ?>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'value' => 'd@f.ruf']) ?>
            <?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'value' => '+99999999999']) ?>
            <?= $form->field($model, 'passport_type_id')->dropDownList(DocType::getDocTypes(),['prompt' => "Выбирите документ", 'value' => 1]) ?>
            
            <?= $form->field($model, 'passport_another', ['options' => ["class" => 'd-none']])->textInput(['autofocus' => true]) ?>
            
            <div class="d-flex gap-3 w-100">
                <?= $form->field($model, 'passport_expire')->textInput(['type' => "date", 'autofocus' => true, "value" => '25.11.2025']) ?>
                <?= $form->field($model, 'passport_number')->textInput(['autofocus' => true, 'value' => '+99999999999']) ?>
            </div>
            <?= $form->field($model, 'password')->passwordInput([ 'value' => '12365512Ee']) ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(['value' => '12365512Ee']) ?>
            <?= $form->field($model, 'rules')->checkbox([]) ?>
            


            <div class="form-group">
                <div>
                    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

    

        </div>
    </
    
    
    <div>
</div>


<?php

$this->registerJsFile('js/register.js', ['depends' => JqueryAsset::class]); ?>
