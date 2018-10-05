<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Visit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'calendar_id',
            'user_id',
            'doctor_id',
            'patient_name:ntext',
            // 'patient_last_name:ntext',
            // 'service_id',
            // 'phone',
            // 'date',
            // 'time',
            // 'token',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
