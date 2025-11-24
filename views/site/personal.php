<div class="row">
    <div class="col-lg-5">

        <?php

        use yii\grid\GridView;
        use yii\helpers\Html;
        use yii\helpers\VarDumper;
        use yii\widgets\ActiveForm;
        use yii\widgets\ListView;

        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'name',
                'email',
                'phone',
            ],
        ]) ?>

        <p class="h3">Документы:</p>

        <?= ListView::widget([
            'dataProvider' => $model,
            'itemOptions' => ['class' => 'item'],
            'itemView' => 'item',
        ]) ?>

        <?= Html::a('Изменить личные данные', 'change', ['class' => 'btn btn-primary']) ?>

    </div>
</div>