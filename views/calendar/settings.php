<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 07.12.2017
 * Time: 15:57
 */

use yii\widgets\Pjax;
use yii\helpers\Html;

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="dataPicker/css/datepicker.css">
<style>
    td.time {
        font-size: small;
    }

</style>

<?php
$this->title = 'Kalendarz';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hidden" id="paramId"><?= $office_id ?></div>
<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu.php', ['item' => $item]) ?>
    </div>
    <div class="col-md-9">
        <div class=" row">
            <div class="col-lg-3 col-md-4 col-sm-4" style="margin-top: 8px;">
                <label for="usr" >Kalendarz obowiązuje od</label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="form-group">
                   <?= '<input type="text" class="form-control" style="font-size: medium;" value="'.$valid_from.'" id="dpd1">' ?>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1" style="margin-top: 8px;">
                <label for="usr">do</label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="form-group">
                  <?=  '<input type="text" class="form-control" style="font-size: medium;"  value="'.$valid_until.'" id="dpd2">' ?>
                </div>
            </div>

        </div>

        <?php Pjax::begin(); ?>
        <div class="hidden" id="dayId"><?= $day_id ?></div>


        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Grafik</h3>
            </div>
            <div class="panel-body">
                <table class="table" style="text-align: center;">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="text-align: center; width: 14%">Poniedziałek</th>
                        <th scope="col" style="text-align: center; width: 14%">Wtorek</th>
                        <th scope="col" style="text-align: center; width: 14%">Środa</th>
                        <th scope="col" style="text-align: center; width: 14%">Czwartek</th>
                        <th scope="col" style="text-align: center; width: 14%">Piątek</th>
                        <th scope="col" style="text-align: center; width: 14%">Sobota</th>
                        <th scope="col" style="text-align: center; width: 14%">Niedziela</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <?= Html::a("Dodaj", \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 1]), ['id' => 'refresh1', "class" => "btn btn-primary", 'role' => "button"]) ?>

                        </td>
                        <td>
                            <?= Html::a("Dodaj", \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 2]), ['id' => 'refresh2', "class" => "btn btn-primary", 'role' => "button"]) ?>

                        </td>
                        <td>
                            <?= Html::a("Dodaj", \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 3]), ['id' => 'refresh3', "class" => "btn btn-primary", 'role' => "button"]) ?>
                        </td>
                        <td>
                            <?= Html::a("Dodaj", \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 4]), ['id' => 'refresh4', "class" => "btn btn-primary", 'role' => "button"]) ?>

                        </td>
                        <td>
                            <?= Html::a("Dodaj", \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 5]), ['id' => 'refresh5', "class" => "btn btn-primary", 'role' => "button"]) ?>

                        </td>
                        <td>
                            <?= Html::a("Dodaj", \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 6]), ['id' => 'refresh6', "class" => "btn btn-primary", 'role' => "button"]) ?>

                        </td>
                        <td>
                            <?= Html::a("Dodaj", \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 7]), ['id' => 'refresh7', "class" => "btn btn-primary", 'role' => "button"]) ?>

                        </td>
                    </tr>


                    <?php
                    for ($i = 0; $i < $max; $i++) {
                        if (array_key_exists($i, $schedule_mon)) {
                            echo '<tr><td class="time">';
                            echo Html::a(date('G:i', strtotime($schedule_mon[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_mon[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 1, 'schedule_id' => $schedule_mon[$i]->id]), ['id' => $schedule_mon[$i]->id]);
                        } else  echo '</td><td>';
                        if (array_key_exists($i, $schedule_tue)) {
                            echo '</td><td class="time">';
                            echo Html::a(date('G:i', strtotime($schedule_tue[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_tue[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 2, 'schedule_id' => $schedule_tue[$i]->id]), ['id' => $schedule_tue[$i]->id]);
                        } else
                            echo '</td><td>';
                        if (array_key_exists($i, $schedule_wen)) {
                            echo '</td><td class="time">';
                            echo Html::a(date('G:i', strtotime($schedule_wen[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_wen[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 3, 'schedule_id' => $schedule_wen[$i]->id]), ['id' => $schedule_wen[$i]->id, 'title'=>"Edytuj"]);
                        } else
                            echo '</td><td>';
                        if (array_key_exists($i, $schedule_thu)) {
                            echo '</td><td class="time">';
                            echo Html::a(date('G:i', strtotime($schedule_thu[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_thu[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 4, 'schedule_id' => $schedule_thu[$i]->id]), ['id' => $schedule_thu[$i]->id, 'title'=>"Edytuj"]);

                        } else  echo '</td><td>';

                        if (array_key_exists($i, $schedule_fri)) {
                            echo '</td><td class="time">';
                            echo Html::a(date('G:i', strtotime($schedule_fri[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_fri[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 5, 'schedule_id' => $schedule_fri[$i]->id]), ['id' => $schedule_fri[$i]->id, 'title'=>"Edytuj"]);


                        } else  echo '</td><td>';

                        if (array_key_exists($i, $schedule_sat)) {
                            echo '</td><td class="time">';
                            echo Html::a(date('G:i', strtotime($schedule_sat[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_sat[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 6, 'schedule_id' => $schedule_sat[$i]->id]), ['id' => $schedule_sat[$i]->id, 'title'=>"Edytuj"]);

                        } else  echo '</td><td>';

                        if (array_key_exists($i, $schedule_sun)) {
                            echo '</td><td class="time">';
                            echo Html::a(date('G:i', strtotime($schedule_sun[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_sun[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 7, 'schedule_id' => $schedule_sun[$i]->id]), ['id' => $schedule_sun[$i]->id, 'title'=>"Edytuj"]);

                        } else  echo '</td><td>';
                        echo '</td><tr>';
                    }
                    ?>


                    </tbody>
                </table>

            </div>
        </div>
        <!--?= "schedule_idd " . $schedule_id ?-->
        <?php if ($schedule_id != null) {
            echo $this->render('_schedule_edit_form', ['office_id' => $office_id, 'day_id' => $day_id, 'schedule_id' => $schedule_id, 'services_id' => $services_id, 'visitType' => $visitType]);
        } else if ($day_id != null) {
            echo $this->render('_settings_form', ['office_id' => $office_id, 'day_id' => $day_id]);
        }
        ?>
        <?php Pjax::end(); ?>

    </div>
</div>
<script src="dataPicker/js/bootstrap-datepicker.js"></script>

<script>

    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);


    var checkin = $('#dpd1').datepicker({
        weekStart: 1,
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate());
            checkout.setValue(newDate);
            console.log("pierasz data");
        }
        checkin.hide();
       // $('#dpd2')[0].focus();
        save();
    }).data('datepicker');

    var checkout = $('#dpd2').datepicker({
        weekStart: 1,
        onRender: function (date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        checkout.hide();
        console.log("druga data");
        //save
        save();
    }).data('datepicker');

    function save() {
        var officeId = $("#paramId").text();
        $.ajax({
            url: "index.php?r=calendar/save-date",
            type: "POST",
            data: {
                officeId: officeId,
                startDay: $('#dpd1').val(),
                endDay: $('#dpd2').val(),
                //services: JSON.stringify(servicearr)
            },
            success: function (result) {
                console.log("forma przeszłąna" + result);
            },
            error: function () {
                alert("Coś poszło nie tak");
            }
        });
    }
</script>


