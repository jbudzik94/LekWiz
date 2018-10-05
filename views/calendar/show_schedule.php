<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 05.01.2018
 * Time: 15:19
 */
?>

<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 09.10.2017
 * Time: 16:54
 */

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;


$this->title = Yii::t('user', 'Gabinety i usługi');
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if (Yii::$app->session->hasFlash('reserved')) {
    echo '<div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
        Yii::$app->session->getFlash('reserved') .
        '</div>';
}
?>

<head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="dataPicker/css/datepicker.css">
    <style>

        tr:nth-child(even) {background-color: #f2f2f2;}
        .delete:hover {
            color: #710909;
        }

        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: #e5e5e5;
        }
    </style>
</head>


<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu.php', ['item' => $item]) ?>
    </div>
    <div class="col-md-9">
        <div class=" row">
            <div class="col-lg-3 col-md-4 col-sm-4" style="margin-top: 8px;">
                <label for="usr">Harmonogram z dnia: </label>
            </div>
            <div class="col-lg-2 col-md- col-sm-3">
                <div class="form-group">


                    <input type="text" class="form-control" style="font-size: medium;" value="" id="dpd1">
                </div>
            </div>
        </div>

        <?php Pjax::begin(); ?>

        <a href="" class="hidden" id="day-link"></a>

        <?php
        if (count($exceptional_visits) != 0) {

            echo '<table class="table table-hover table-striped"  style = "border: 1px solid #ddd">';
            echo '<thead>';
            echo '<tr class="warning">';
            echo '<th class="col-md-8" colspan="3">Wizyty z tej tabeli zostały ustalone przed zmianą grafiku, mogą one nie pokrywać się z aktualnym grafikiem.</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($exceptional_visits as $exceptional_visit) {


                echo '<tr>';
                echo '<td class="col-md-2">' . date('G:i', strtotime($exceptional_visit->time)) . '</td>';
                echo '<td class="col-md-7"><b>' . $exceptional_visit->patient_name . ' ' . $exceptional_visit->patient_last_name . '</b> tel. '. $exceptional_visit->phone.'<br>' . $exceptional_visit->service. ' w miejscu: ' . \app\models\Office::findOne(\app\models\Calendar::findOne($exceptional_visit->calendar_id)->office_id)->name . '</td>';
                echo '<td class="col-md-2">' . Html::a("Odwołaj wizytę", ['calendar/cancel-visit', 'id' => $exceptional_visit->id, 'day' => $exceptional_visit->date],
                        [
                            'id' => 'delete-visit',
                            "class" => "btn btn-danger pull-right",
                            'role' => "button",
                            'data-confirm' => 'Jesteś pewien, że chcesz odwołać wizytę dnia ' . $exceptional_visit->date . ' o godzinie ' . date('G:i', strtotime($exceptional_visit->time)) . '?',
                        ]) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        ?>


        <?php


        if ($info == 'dzień nie przeminął') {

            if (count($time_arr['time']) == 0 && count($visits) == 0) {

                echo '<div style="display: table; height: 200px;  width: 100%; overflow: hidden;">';
                echo '<div style="display: table-cell; vertical-align: middle;">';
                echo '<div>';
                echo '<p style=" color: #337ab7; text-align: center;">Nie masz ustalonego grafiku na ten dzień.</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                echo ' <table class="table table-hover table-striped" style="border: 1px solid #ddd;">
            <thead>
            <tr class="active">
                <th class="col-md-1" colspan="3">Godzina</th>
            </tr>
            </thead>
            <tbody>';

                for ($i = 0; $i < count($time_arr['time']); $i++) {
                    echo '<tr>';
                    echo '<td class="col-md-2">' . $time_arr['time'][$i] . ' - ' . date('G:i', strtotime("+" . $time_arr['schedule']['minutes'][$i] . " minutes", strtotime($time_arr['time'][$i]))) . '</td>';
                    if (false !== $key = array_search($time_arr['time'][$i], $visits_time)) {

                        echo '<td class="col-md-7"><b>' . $visits[$key]->patient_name . ' ' . $visits[$key]->patient_last_name .'</b> tel. '. $visits[$key]->phone.'<br>' . $visits[$key]->service .' w miejscu: ' .\app\models\Office::findOne(\app\models\Calendar::findOne($visits[$key]->calendar_id)->office_id)->name. '</td>';
                        if (strtotime($day . ' ' . $time_arr['time'][$i]) >= time())
                            echo '<td class="col-md-2">' . Html::a("Odwołaj wizytę", ['calendar/cancel-visit', 'id' => $visits[$key]->id, 'day' => $visits[$key]->date],
                                    [
                                        'id' => 'delete-visit',
                                        "class" => "btn btn-danger pull-right",
                                        'role' => "button",
                                        'data-confirm' => 'Jesteś pewien, że chcesz odwołać wizytę dnia ' . $visits[$key]->date . ' o godzinie ' . date('G:i', strtotime($visits[$key]->time)) . '?',
                                    ]);
                        else echo '<td class="col-md-2">';
                        echo '</td>';

                    } else {
                        echo '<td class="col-md-7"></td>';
                        if (strtotime($day . ' ' . $time_arr['time'][$i]) >= time()) {
                            echo '<td class="col-md-2">';
                            echo Html::button('Dopisz pacjenta', ['value' => \yii\helpers\Url::to(['calendar/append-patient', 'time' => $time_arr['time'][$i], 'date' => $day, 'schedule_id' => $time_arr['schedule']['id'][$i]]),
                                'class' => 'btn btn-success btn-block btn-modal', 'id' => 'modalButton']);
                        } else echo '<td class="col-md-2">';
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                echo '  </tbody>
        </table>';
            }
        } else { //dzień przeminął
            if (count($visits) != 0) {
                echo ' <table class="table table-hover table-striped" style="border: 1px solid #ddd;">
            <thead>
            <tr>
                <th class="col-md-1" colspan="3">Godzina</th>
            </tr>
            </thead>
            <tbody>';
                foreach ($visits as $visit) {
                    echo '<tr class="table-striped">';
                    echo '<td class="col-md-2">' . date('G:i', strtotime($visit->time)) . '</td>';


                    echo '<td class="col-md-7">' . $visit->patient_name . ' ' . $visit->patient_last_name . '<br>' . $visit->service . ' ' . \app\models\Office::findOne(\app\models\Calendar::findOne($visit->calendar_id)->office_id)->id . '</td>';

                    echo '<td class="col-md-2">';
                    echo '</td>';

                }
                echo '  </tbody>
        </table>';
            } else{ //dzień przemiął i nie ma wizyt
                echo '<div style="display: table; height: 200px;  width: 100%; overflow: hidden;">';
                echo '<div style="display: table-cell; vertical-align: middle;">';
                echo '<div>';
                echo '<p style=" color: #337ab7; text-align: center;">Brak zaplanowanych wizyt w tym dniu.</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>


        <script>

            $(".btn-modal").click(function () {
                $("#modal").modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
            });

        </script>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php

Modal::begin(['header' => '<h4>Dopisz pacjenta</h4>',
    'id' => 'modal',
    'size' => 'modal-lg']);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<script src="dataPicker/js/bootstrap-datepicker.js"></script>
<script>
    var checkin = $('#dpd1').datepicker({
        weekStart: 1,
        onRender: function () {
            var url_string = window.location.href;
            var url = new URL(url_string);
            var param = url.searchParams.get("day");
            if (param == null) {
                param = new Date().toJSON().slice(0, 10);
            }
            $('#dpd1').attr('value', param);
        }
    }).on('changeDate', function (ev) {
        console.log("pierasz data");
        checkin.hide();
        $("#day-link").attr('href', "index.php?r=calendar/show-schedule&day=" + $('#dpd1').val());// +  );
        $("#day-link").click();

    }).data('datepicker');
    $( "#dpd1" ).datepicker({
        firstDay: 1
    });
</script>

