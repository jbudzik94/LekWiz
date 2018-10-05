<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 20.12.2017
 * Time: 22:05
 */

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

$this->title = 'Umawianie wizyty';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="message">

    <?= Yii::$app->session->getFlash('success'); ?>
</div>
<div class="visit-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <!--?php
    print_r($date_arr);
    print_r($time_arr);
    echo $schedule." schedule < time() ".time();
    ?-->
    <div class="panel panel-default">


        <div class="panel-body">
            <div class="row">
                <div class="col-md-5 " style="padding-left: 30px; border-right: solid 1px #eee; padding-right: 100px;">
                    <?php $form = ActiveForm::begin(); ?>


                    <?= $form->field($model, 'patient_name'); ?>
                    <?= $form->field($model, 'patient_last_name'); ?>
                    <?= $form->field($model, 'phone'); ?>
                    <?= $form->field($model, 'service')->widget(Select2::classname(), [
                       // 'data' => \yii\helpers\ArrayHelper::map(\app\models\Service::find()->where(['id' => $services])->all(), 'id', 'name'),
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Service::find()->where(['id' => $services])->all(), 'id', 'NameWithPrice'),
                        'options' => ['placeholder' => 'Wybierz ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false
                        ],
                    ]); ?>
                </div>

                <h3 style="margin-left: 51%;">Informacje o wizycie:</h3>
                <br>

                <div class="col-md-1 col-md-offset-1" style="font-weight: bold;">

                    <p>Lekarz</p>
                    <p>Dzień</p>
                    <p>Godzina</p>
                </div>
                <div class="col-md-3">
                    <p><?= \app\models\UserDetails::find()->where(['user_id' => \app\models\Doctor::findOne($doctor)->user_id])->one()->name ?>
                        <?= \app\models\UserDetails::find()->where(['user_id' => \app\models\Doctor::findOne($doctor)->user_id])->one()->last_name ?>
                    </p>
                    <p>
                        <?= $date; ?>
                    </p>
                    <p>
                        <?= $time; ?>
                    </p>


                </div>

            </div>
            <div class="row">
                <div class="col-md-5">
                    <?= Html::submitButton('Wyślij', ['class' => 'btn btn-block btn-success', 'style' => "  margin-top: 10px;  margin-left: 15px;  width: 77%;"]) ?>

                </div>
            </div>
            <!--hr>
            <h3>Informacje o wizycie</h3>
            <div class="form-group" style=" margin-bottom: 10px; padding-left: 10px;">
                <label class="col-md-3 col-sm-3 col-xs-3" style="float:left;">Lekarz</label>
                <div style="width: 40%;">
                    <!--?= \app\models\UserDetails::find()->where(['user_id' => \app\models\Doctor::findOne($doctor)->user_id])->one()->name ?>
                    <!--?= \app\models\UserDetails::find()->where(['user_id' => \app\models\Doctor::findOne($doctor)->user_id])->one()->last_name ?>

                </div>
            </div>

            <div class="form-group" style=" margin-bottom: 10px; padding-left: 10px;">
                <label class="col-md-3 col-sm-3 col-xs-3" style="float:left;">Dzień</label>
                <div style="width: 40%; margin-left: 284px;">
                    <!--?= $date; ?>
                </div>
            </div>

            <div class="form-group" style=" margin-bottom: 10px; padding-left: 10px;">
                <label class="col-md-3 col-sm-3 col-xs-3" style="float:left;">Godzina</label>
                <div style="width: 40%; margin-left: 284px;">
                    <!--?= $time; ?>
                </div>
            </div>

            <!--?= Html::submitButton('Wyślij', ['class' => 'btn btn-success', 'style' => "margin-top: 10px;"]) ?-->


            <?php $form = \yii\widgets\ActiveForm::end(); ?>
        </div>
    </div>
</div>