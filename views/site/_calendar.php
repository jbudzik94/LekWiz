<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 12.12.2017
 * Time: 18:07
 */

use \yii\helpers\Html;

?>

<!--//Przesyłamy id kalendarza
//schedule_mon
//schedule_tue
//schedule_wen
//...-->
<link rel="stylesheet" href="starRating/SimpleStarRating.css">
<style>
    .disabled{
        background-color: lightgray;
        color: white;
        text-decoration: line-through;
    }


</style>


<table class="table table-bordered" style="text-align: center;  margin: 0 auto;">

    <thead class="thead-dark">
    <tr>
        <th scope="col" style="text-align: center; width: 14%">
            <div>Poniedziałek</div>
            <div><?= $date_mon = date("Y-m-d", strtotime('monday this week', strtotime("+" . $week . " week",  $time))); ?></div>
        </th> <!-- tutaj nie time tylko valid_from-->
        <th scope="col" style="text-align: center; width: 14%">
            <div>Wtorek</div>
            <div><?= $date_tue = date("Y-m-d", strtotime('tuesday this week', strtotime("+" . $week . " week", $time))); ?></div>
        </th>
        <th scope="col" style="text-align: center; width: 14%">
            <div>Środa</div>
            <div><?= $date_wen = date("Y-m-d", strtotime('wednesday this week', strtotime("+" . $week . " week",$time))); ?></div>
        </th>
        <th scope="col" style="text-align: center; width: 14%">
            <div>Czwartek</div>
            <div><?= $date_thu = date("Y-m-d", strtotime('thursday this week', strtotime("+" . $week . " week",  $time))); ?></div>
        </th>
        <th scope="col" style="text-align: center; width: 14%">
            <div>Piątek</div>
            <div><?= $date_fri = date("Y-m-d", strtotime('friday this week', strtotime("+" . $week . " week",  $time))); ?></div>
        </th>
        <th scope="col" style="text-align: center; width: 14%">
            <div>Sobota</div>
            <div><?= $date_sat = date("Y-m-d", strtotime('saturday this week', strtotime("+" . $week . " week", $time))); ?></div>
        </th>
        <th scope="col" style="text-align: center; width: 14%">
            <div>Niedziela</div>
            <div><?= $date_sun = date("Y-m-d", strtotime('sunday this week', strtotime("+" . $week . " week", $time))); ?></div>
        </th>
    </tr>
    </thead>
    <tbody>

    <tr style="height: 300px;">
        <td>
            <?php
            $today =  strtotime('yesterday');
         $mon = strtotime($date_mon);
         $tue= strtotime($date_tue);
         $wen= strtotime($date_wen);
         $thu= strtotime($date_thu);
         $fri= strtotime($date_fri);
         $sat= strtotime($date_sat);
         $sun= strtotime($date_sun);
            /*
                       if($today < $mon)
                           echo "today jest mniejsze od monday";
                       else
                           echo "today jest większe od monday";
            */

            for ($i = 0; $i < count($schedule_mon); $i++) {
                //if ($date_mon >= date('Y-m-d',time()) && strtotime($date_mon) >= strtotime($calendar->valid_from) && strtotime($date_mon) <= strtotime($calendar->valid_until)) {
                if ( strtotime($date_mon) >= strtotime($calendar->valid_from) && strtotime($date_mon) <= strtotime($calendar->valid_until)) {

                        for ($j = strtotime($schedule_mon[$i]->start_hour); $j < strtotime($schedule_mon[$i]->end_hour); $j = strtotime("+" . $schedule_mon[$i]->visit_minutes . " minutes", $j)) {
                            if ( $today >= $mon || in_array(date('G:i', $j), $week_visits_date[0])  || ($date_mon== date('Y-m-d', time()) && $j < time()) )
                                $class = "btn btn-xs disabled";
                            else {
                                if ($schedule_mon[$i]->visit_type == 1)
                                    $class = "btn btn-info btn-xs";
                                else
                                    $class = "btn btn-primary btn-xs";
                            }
                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_mon, 'time' => date('G:i', $j), 'schedule' => $schedule_mon[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' => $class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%"
                                ]) . '<br>';
                        }
                }
            }
            ?>
        </td>
        <td>
            <?php
            for ($i = 0; $i < count($schedule_tue); $i++) {
                if (strtotime($date_tue) >= strtotime($calendar->valid_from) && strtotime($date_tue) <= strtotime($calendar->valid_until)) {
                        for ($j = strtotime($schedule_tue[$i]->start_hour); $j < strtotime($schedule_tue[$i]->end_hour); $j = strtotime("+" . $schedule_tue[$i]->visit_minutes . " minutes", $j)) {
                            if ( $today >= $tue || in_array(date('G:i', $j), $week_visits_date[1]) || ($date_tue == date('Y-m-d', time()) && $j < time()))
                                $class = "btn btn-xs disabled";
                            else {
                                if ($schedule_tue[$i]->visit_type == 1)
                                    $class = "btn btn-info btn-xs";
                                else
                                    $class = "btn btn-primary btn-xs";
                            }
                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_tue, 'time' => date('G:i', $j), 'schedule' => $schedule_tue[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' => $class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%"
                                ]) . '<br>';
                        }

                }
            }
            ?>
        </td>
        <td>
            <?php
            for ($i = 0; $i < count($schedule_wen); $i++) {
                if (strtotime($date_wen) >= strtotime($calendar->valid_from) && strtotime($date_wen) <= strtotime($calendar->valid_until)) {

                    //if ($schedule_wen[$i]->visit_type == 1) {
                        for ($j = strtotime($schedule_wen[$i]->start_hour); $j < strtotime($schedule_wen[$i]->end_hour); $j = strtotime("+" . $schedule_wen[$i]->visit_minutes . " minutes", $j)) {

                            if ($today >= $wen || in_array(date('G:i', $j), $week_visits_date[2]) || ($date_wen== date('Y-m-d', time()) && $j < time()))
                                $class = "btn btn-xs disabled";
                            else {
                                if ($schedule_wen[$i]->visit_type == 1)
                                    $class = "btn btn-info btn-xs";
                                else
                                    $class = "btn btn-primary btn-xs";
                            }
                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_wen, 'time' => date('G:i', $j), 'schedule' => $schedule_wen[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' =>$class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%"
                                ]) . '<br>';
                        }

                }
            }
            ?>
        </td>
        <td>
            <?php
            for ($i = 0; $i < count($schedule_thu); $i++) {
                if (strtotime($date_thu) >= strtotime($calendar->valid_from) && strtotime($date_thu) <= strtotime($calendar->valid_until)) {

                  //  echo $godzina = date('G:i',time() );
                    //echo $dzien = date('Y-m-d',time());
                     //{
                        for ($j = strtotime($schedule_thu[$i]->start_hour); $j < strtotime($schedule_thu[$i]->end_hour); $j = strtotime("+" . $schedule_thu[$i]->visit_minutes . " minutes", $j)) {
                            if ($today >= $thu || in_array(date('G:i', $j), $week_visits_date[3]) || ($date_thu == date('Y-m-d', time()) && $j < time()))
                                $class = "btn btn-xs disabled";
                            else {
                                if ($schedule_thu[$i]->visit_type == 1)
                                    $class = "btn btn-info btn-xs";
                                else
                                    $class = "btn btn-primary btn-xs";
                            }
                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_thu, 'time' => date('G:i', $j), 'schedule' => $schedule_thu[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' => $class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%"
                                ]) . '<br>';
                        }

                }
            }
            ?>
        </td>
        <td>
            <?php
            for ($i = 0; $i < count($schedule_fri); $i++) {
                if (strtotime($date_fri) >= strtotime($calendar->valid_from) && strtotime($date_fri) <= strtotime($calendar->valid_until)) {
                    //if ($schedule_fri[$i]->visit_type == 1) {

                        for ($j = strtotime($schedule_fri[$i]->start_hour); $j < strtotime($schedule_fri[$i]->end_hour); $j = strtotime("+" . $schedule_fri[$i]->visit_minutes . " minutes", $j)) {

                            if ( in_array(date('G:i', $j), $week_visits_date[4]) || ($date_fri == date('Y-m-d', time()) && $j < time()) || $today >= $fri )
                                $class = "btn btn-xs disabled";
                            else
                                $class = "btn btn-info btn-xs";
                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_fri, 'time' => date('G:i', $j), 'schedule' => $schedule_fri[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' => $class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%"
                                ]) . '<br>';
                        }
                    /*} else {
                        for ($j = strtotime($schedule_fri[$i]->start_hour); $j < strtotime($schedule_fri[$i]->end_hour); $j = strtotime("+" . $schedule_fri[$i]->visit_minutes . " minutes", $j)) {
                            if (in_array(date('G:i', $j), $week_visits_date[4]) || ($date_fri == date('Y-m-d', time()) && $j < time()))
                                $class = "btn  btn-xs disabled";
                            else
                                $class = "btn btn-primary btn-xs";
                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_fri, 'time' => date('G:i', $j), 'schedule' => $schedule_fri[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' => $class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%"
                                ]) . '<br>';
                        }
                    }*/
                }
            }
            ?>
        </td>
        <td>
            <?php
            for ($i = 0; $i < count($schedule_sat); $i++) {
                if (strtotime($date_sat) >= strtotime($calendar->valid_from) && strtotime($date_sat) <= strtotime($calendar->valid_until)) {
                    //if ($schedule_sat[$i]->visit_type == 1) {

                        for ($j = strtotime($schedule_sat[$i]->start_hour); $j < strtotime($schedule_sat[$i]->end_hour); $j = strtotime("+" . $schedule_sat[$i]->visit_minutes . " minutes", $j)) {
                            if ($today >= $sat || in_array(date('G:i', $j), $week_visits_date[5]) || (($date_sat == date('Y-m-d', time()) && $j < time())))
                                $class = "btn  btn-xs disabled";
                            else {
                                if ($schedule_sat[$i]->visit_type == 1)
                                    $class = "btn btn-info btn-xs";
                                else
                                    $class = "btn btn-primary btn-xs";
                            }

                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_sat, 'time' => date('G:i', $j), 'schedule' => $schedule_sat[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' => $class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%"
                                ]) . '<br>';
                        }
                   /* } else {
                        for ($j = strtotime($schedule_sat[$i]->start_hour); $j < strtotime($schedule_sat[$i]->end_hour); $j = strtotime("+" . $schedule_sat[$i]->visit_minutes . " minutes", $j)) {
                            if (in_array(date('G:i', $j), $week_visits_date[5]) || ($date_sat== date('Y-m-d', time()) && $j < time()))
                                $class = "btn  btn-xs disabled";
                            else
                                $class = "btn btn-primary btn-xs";

                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_sat, 'time' => date('G:i', $j), 'schedule' => $schedule_sat[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' => $class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%"
                                ]) . '<br>';
                        }
                    }*/
                }
            }
            ?>
        </td>
        <td>
            <?php
            for ($i = 0; $i < count($schedule_sun); $i++) {
                if (strtotime($date_sun) >= strtotime($calendar->valid_from) && strtotime($date_sun) <= strtotime($calendar->valid_until)) {
                   // if ($schedule_sun[$i]->visit_type == 1) {
                        for ($j = strtotime($schedule_sun[$i]->start_hour); $j < strtotime($schedule_sun[$i]->end_hour); $j = strtotime("+" . $schedule_sun[$i]->visit_minutes . " minutes", $j)) {
                            if ( $today >= $sun || in_array(date('G:i', $j), $week_visits_date[6]) || ($date_sun == date('Y-m-d', time()) && $j < time()))
                                $class = "btn btn-xs disabled";
                            else {
                                if ($schedule_sun[$i]->visit_type == 1)
                                    $class = "btn btn-info btn-xs";
                                else
                                    $class = "btn btn-primary btn-xs";
                            }

                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_sun, 'time' => date('G:i', $j), 'schedule' => $schedule_sun[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' => $class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%; "
                                ]) . '<br>';
                        }
                   /* } else {
                        for ($j = strtotime($schedule_sun[$i]->start_hour); $j < strtotime($schedule_sun[$i]->end_hour); $j = strtotime("+" . $schedule_sun[$i]->visit_minutes . " minutes", $j)) {
                            if (in_array(date('G:i', $j), $week_visits_date[6]) || ($date_sun == date('Y-m-d', time()) && $j < time()))
                                $class = "btn  btn-xs disabled";
                            else
                                $class = "btn btn-primary btn-xs";

                            echo Html::a(date('G:i', $j), \yii\helpers\Url::to(['visit/make-appointment', 'date' => $date_sun, 'time' => date('G:i', $j), 'schedule' => $schedule_sun[$i]->id]), [
                                    'id' => 'delete-visit',
                                    'class' => $class,
                                    'role' => "button",
                                    'style' => "margin: 2px; width: 80%"
                                ]) . '<br>';

                        }
                    } */
                }
            }
            ?>
        </td>

    </tr>


    </tbody>
</table>
<!--?= "week in calendar " . $week; ?-->
<!--script src="starRating/SimpleStarRating.js"></script-->