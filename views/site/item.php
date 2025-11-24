<?php

use app\models\DocType;
use yii\helpers\VarDumper;

// VarDumper::dump($model->attributes, 10, true); die;

?>

<div class="border p-3 m-3">
    <div>
        Название документа <?= DocType::getTitle($model->passport_type_id) ?>
    </div>
    <div>
        Действует до <?= $model->passport_expire ?>
    </div>
    <div>
        Номер <?= $model->passport_number ?>
    </div>
</div>