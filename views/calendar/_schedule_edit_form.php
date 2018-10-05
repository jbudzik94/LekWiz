<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 11.12.2017
 * Time: 18:21
 */


use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\time\TimePicker;

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<!--style>
    table, th, td {
        border: 1px solid black;
    }
</style-->
<script>
    $('document').ready(function () {
        $('#saveChanges').click(function () {
            var scheduleId = $('#scheduleId').text();
            var startHour = $('#w0').val();
            var endHour = $('#w1').val();
            var visitMinutes = $('#visit-minutes').val();
          //  console.log(visitMinutes);
            var services = $('#w2').val();
            var visitType = $('#w3').val();
            var officeId = $("#paramId").text();
            $.ajax({
                url: "index.php?r=calendar/edit-day-item",
                type: "POST",
                data: {
                    scheduleId: scheduleId,
                    day: $("#dayId").text(),
                    startHour: startHour,
                    endHour: endHour,
                    visitMinutes: visitMinutes,
                    services: JSON.stringify(services),
                    visitType: visitType,
                    officeId: officeId
                },
                success: function (result) {
                    console.log("forma przeszłąna changes" + result);
                    $("#refresh" + $("#dayId").text()).click();
                },
                error: function () {
                    alert("Coś poszło nie tak changes");
                }
            });
        });

        $('#deleteDayItem').click(function () {
            var scheduleId = $('#scheduleId').text();

            $.ajax({
                url: "index.php?r=calendar/delete-day-item",
                type: "POST",
                data: {
                    scheduleId: scheduleId
                },
                success: function (result) {
                    console.log("forma przeszłąna delete" + result);
                    $("#refresh" + $("#dayId").text()).click();
                },
                error: function () {
                    alert("Coś poszło nie tak delete");
                }
            });
        });

    });
</script>



<!--?php foreach ($services_id as $id)
    // $id;
echo 'visittype '.$visitType;
    ?-->

<div id="scheduleId" class="hidden"><?= $schedule_id ?></div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title font-weight-bold"><?= "Edytuj plan - ".\app\models\Day::findOne($day_id)->name." ".$schedule_id; ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3">
                <label class="control-label">Godzina rozpoczęcia</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3">
                <?php
                //echo '<label class="control-label">Godzina rozpoczęcia</label>';
                echo TimePicker::widget(['name' => 'start_time',
                    'value'=> \app\models\ScheduleItem::findOne($schedule_id)->start_hour,
                    'pluginOptions' => [
                        'showMeridian' => false
                    ]
                ]);
                ?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3">
                <label class="control-label">Godzina rozpoczęcia</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-5">
                <?php
                //echo '<label class="control-label">Godzina zakończenia</label class="control-label">';
                echo TimePicker::widget(['name' => 'end_time',
                    'value'=> \app\models\ScheduleItem::findOne($schedule_id)->end_hour,
                    'pluginOptions' => [
                        'showMeridian' => false
                    ]
                ]);
                ?>
            </div>
        </div>
        <br>
        <hr>
        <div class="row">

            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-3" style="margin-top: 10px;">
                <label class="control-label">Czas trwania wizyty</label>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <select id="visit-minutes" class="form-control" style="padding-left: 0; padding-right: 0; width: 50px;" >
                    <option value="10">10</option>
                    <option value="12">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                    <option value="35">35</option>
                    <option value="40">40</option>
                    <option value="45">45</option>
                    <option value="50">50</option>
                    <option value="55">55</option>
                    <option value="60">60</option>
                </select>
            </div>
            <div class="col-lg-3  col-md-3 col-sm-4 col-xs-3" style="margin-top: 10px;">
                min
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-3">
                <label class="control-label">Wybierz dostępne usługi</label>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
                <?=
                Select2::widget([
                    'name' => 'services[]',
                    'value' => $services_id,
                    'data' => \yii\helpers\ArrayHelper::map(\app\models\Service::find()->where(['office_id' => $office_id])->all(), 'id', 'name'),
                    // 'value' => \yii\helpers\ArrayHelper::map(\app\models\Service::find()->where(['id' => \yii\helpers\ArrayHelper::map(\app\models\ScheduleItemService::find()->where(['schedule_item_id' => $schedule_id])->all(), 'schedule_item_id', 'service_id')])->all(), 'id', 'id'),
                    // 'value' => \yii\helpers\ArrayHelper::map(\app\models\ScheduleItemService::find()->where(['schedule_item_id' => $schedule_id])->all(), 'schedule_item_id', 'service_id'),
                    // 'value' => [2,3], //id badań
                    'options' => ['placeholder' => 'Wybierz ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true
                    ],
                ]); ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-3">
                <label class="control-label">Wybierz typy wizyt</label>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
                <?=
                Select2::widget([
                    'name' => 'type',
                    'data' => ['NFZ', 'prywatnie'],
                    'value' => $visitType,
                    'hideSearch' => true,
                    'options' => ['placeholder' => 'Wybierz ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="input-group control-group">
                    <?= Html::button('Zapisz Zmiany', ['class' => 'btn btn-success', 'id' => 'saveChanges']) ?>
                </div>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <div class="input-group control-group">
                    <?= Html::button('Usuń', ['class' => 'btn btn-danger', 'id' => 'deleteDayItem',
                        'data-confirm' => 'Jesteś pewien?'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>


</div>


