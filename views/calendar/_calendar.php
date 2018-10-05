<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 12.12.2017
 * Time: 18:07
 */
?>

//Przesyłamy id kalendarza
//schedule_mon
//schedule_tue
//schedule_wen
//...
<link rel="stylesheet" href="starRating/SimpleStarRating.css">
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

    <!--?php
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
            echo Html::a(date('G:i', strtotime($schedule_wen[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_wen[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 3, 'schedule_id' => $schedule_thu[$i]->id]), ['id' => $schedule_wen[$i]->id]);
        } else
            echo '</td><td>';
        if (array_key_exists($i, $schedule_thu)) {
            echo '</td><td class="time">';
            echo Html::a(date('G:i', strtotime($schedule_thu[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_thu[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 4, 'schedule_id' => $schedule_thu[$i]->id]), ['id' => $schedule_thu[$i]->id]);

        } else  echo '</td><td>';

        if (array_key_exists($i, $schedule_fri)) {
            echo '</td><td class="time">';
            echo Html::a(date('G:i', strtotime($schedule_fri[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_fri[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 5, 'schedule_id' => $schedule_fri[$i]->id]), ['id' => $schedule_fri[$i]->id]);


        } else  echo '</td><td>';

        if (array_key_exists($i, $schedule_sat)) {
            echo '</td><td class="time">';
            echo Html::a(date('G:i', strtotime($schedule_sat[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_sat[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 6, 'schedule_id' => $schedule_sat[$i]->id]), ['id' => $schedule_sat[$i]->id]);

        } else  echo '</td><td>';

        if (array_key_exists($i, $schedule_sun)) {
            echo '</td><td class="time">';
            echo Html::a(date('G:i', strtotime($schedule_sun[$i]->start_hour)) . " - " . date('G:i', strtotime($schedule_sun[$i]->end_hour)), \yii\helpers\Url::to(['calendar/settings', 'office_id' => $office_id, 'day_id' => 7, 'schedule_id' => $schedule_sun[$i]->id]), ['id' => $schedule_sun[$i]->id]);

        } else  echo '</td><td>';
        echo '</td><tr>';
    }
    ?-->
    <!--?php echo $calendar->id ?-->


    </tbody>
</table>
<script src="starRating/SimpleStarRating.js"></script>