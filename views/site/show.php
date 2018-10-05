<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 27.11.2017
 * Time: 19:21
 */

use yii\helpers\Html;
use kartik\rating\StarRating;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;


?>
<style>
    .breadcrumb {background-color: whitesmoke;}
    table tr:last-child td:first-child {
        border-bottom-left-radius: 10px;
    }

    table tr:last-child td:last-child {
        border-bottom-right-radius: 10px;
    }
    table, th, td {
        border: 1px solid black;
    }
</style>
<?php

$this->params['breadcrumbs'][] = ['label' => 'Spis lekarzy', 'url' => [ 'index']];
$this->params['breadcrumbs'][] = $userDetails->name . " " . $userDetails->last_name;
?>
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

<link rel="stylesheet" href="starRating/SimpleStarRating.css">
<style>


    td {
        padding: 1em;
    }
    .breadcrumb {background-color: whitesmoke;}


</style>


<div class="hidden" id="paramId"><?= Yii::$app->getRequest()->getQueryParam('id') ?></div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <?php
            echo "<div class='col-lg-2 col-md-3 col-sm-4 col-xs-12 '>";
            if ($photo != null) {
                echo '<a data-fancybox="profilePhoto" href="uploads/doctor_' . $doctor_id . '/' . $photo->name . '"><img src="uploads/doctor_' . $doctor_id . '/' . $photo->name . '" style=" margin-left: 10px; float: left; height: 200px; width: 170px; object-fit: cover;  border-radius: 10%; "/></a>';
            } else {
                echo '<div class="photo" style="float:left; height: 200px; width: 170px; border: 1px dashed cornflowerblue; background-color: aliceblue; border-radius: 10%; background-size: 100px 100px; background-image: url(icons/add_avatar_small.png);  background-repeat: no-repeat; background-position: center;"></div>';
            }
            echo "</div><div class='col-lg-10 col-md-9 col-sm-8 col-xs-12 '>";

            echo
                "<div style=' float: left; color: #000000; font-size: 1.7em; margin-right: 20px;'>" . $userDetails->name . " " . $userDetails->last_name . "</div>";


            echo StarRating::widget([
                'name' => 'rating_35',
                'value' => \app\models\Doctor::findOne($doctor_id)->rating,
                'pluginOptions' => [
                    'displayOnly' => true,
                    'size' => 'xs',
                    'theme' => 'krajee-svg'
                ]
            ]);


            echo "<div style='color: #777;'>";
            foreach ($categorys as $category) {
                echo $category . " ";
            }

            // echo  "<div id='description1' style='color: #0f0f0f; margin-top: 10px; '>".$description1."<span>wiecej</span></div>";
            if ($description2 != null) { //istnieje
                echo "<div id='description1' style='white-space:pre-wrap; color: #0f0f0f; margin-top: 10px; '>" . $description1 . "... <a id='showMore' href='#'>wiecej</a></div>";
                echo "<div  class='hide' id='description2' style='white-space:pre-wrap; color: #0f0f0f; margin-top: 10px; '>" . $description1 . $description2 . " <a id='showLess' href='#'>ukryj</a></div>";
            } else {
                echo "<div id='description1' style='white-space:pre-wrap; color: #0f0f0f; margin-top: 10px; '>" . $description1 . "</div>";
            }
            echo "</div></div>";
            ?>

        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"> Umów wizytę</h3>
    </div>
    <div class="panel-body">


        <?php

        for ($i = 0; $i < count($offices); $i++) {
            echo'<div class="row">';
            echo'<div class="col-md-12">';
            echo "<span class='glyphicon glyphicon-map-marker' style='float: left; margin-right: 10px; font-size: 2em;' ></span><div style=' font-size: 2em; color: #444;'>" . '   ' . $offices[$i]->name . "</div>";
            echo'</div>';
            echo'</div>';
            echo'<div class="row">';
            echo'<div class="col-md-3">';
            echo "<div style=' font-size: 1em; color: #444; margin-left: 40px;'> ul." . $offices[$i]->street . "</div>";
echo "<div style=' font-size: 1em; color: #444; margin-left: 40px;'>" . $offices[$i]->postal_code ." ". $offices[$i]->city."</div>";
echo "<div style=' font-size: 1em; color: #444; margin-left: 40px;'> tel. " . $offices[$i]->phone."</div>";
            echo'</div>';


            echo'<div class="col-md-9">';
           // echo 'Usługi:';
            echo'</div>';
            echo'</div>';
            \yii\widgets\Pjax::begin();
            echo '<hr>';

            echo'<div class="row">';
            echo'<div class="col-md-2">';

            if ($week != null && $week != '0') {
                echo Html::a('<< Poprzedni tydzień', ['site/show', 'id' => $doctor_id, 'week' => $week - 1],
                    [
                        'class' => "btn btn-default ",
                        'role' => "button",
                        'id' => 'next_week',
                    ]);
            }
            echo'</div>';


            if (strtotime($calendars[$i]->valid_from) < time())
                $time = time();
            else $time = strtotime($calendars[$i]->valid_from);
          //  echo '<div class="row">';
            echo '<div class="col-md-8">';
            echo $this->render('_calendar', [
                'calendar' => $calendars[$i],
                "schedule_mon" => $schedule_mon[$i],
                "schedule_tue" => $schedule_tue[$i],
                "schedule_wen" => $schedule_wen[$i],
                "schedule_thu" => $schedule_thu[$i],
                "schedule_fri" => $schedule_fri[$i],
                "schedule_sat" => $schedule_sat[$i],
                "schedule_sun" => $schedule_sun[$i],
                "office_id" => $offices[$i],
                "doctor_id" => $doctor_id,
                "week" => $week,
                "time" => $time,
                "week_visits_date" => $week_visits_date[$i]
            ]);
            echo '</div>';
            echo'<div class="col-md-2">';
            if (strtotime($calendars[$i]->valid_until) >= strtotime('sunday this week', strtotime("+" . $week . " week", strtotime(date("Y-m-d", time()))))) {
                echo Html::a('Następny tydzień >>', ['site/show', 'id' => $doctor_id, 'week' => $week + 1],
                    [
                        'class' => "btn btn-default pull-right",
                        'role' => "button",
                        'id' => 'next_week',
                    ]);
            }
            echo '<div class="row">';
            echo '<div style="background-color: #337ab7; width: 20px; height: 15px; border-radius: 10px; margin-top: 50px;" class="col-md-3"></div><div class="col-md-9" style="margin-top: 47px;"> - wizyty NFZ</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div style="background-color: #5bc0de; width: 20px; height: 15px; border-radius: 10px; margin-top: 10px;" class="col-md-3"></div><div class="col-md-9" style="margin-top: 7px;"> - wizyty prywatne</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            \yii\widgets\Pjax::end();
            echo '<hr style="height:2px;border:none;color:#333;background-color: lightgray;">';
        }
        ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"> Informacje o lekarzu</h3>
    </div>
    <div class="panel-body">
        <div><img src="icons/003-file.png"> <b>Specjalizacje</b>
            <ul>
                <?php foreach ($categorys as $category) {
                    echo "<li>" . $category . "</li> ";
                }
                ?>
            </ul>
        </div>


        <?php
        if ($universities != null) {
            echo '<hr>';
            echo '<div><img src="icons/002-mortarboard.png"> <b>Ukończone szkoły</b>';
            echo '<ul>';
            foreach ($universities as $university) {
                echo "<li>" . $university->name . "</li> ";
            }

            echo '</ul>';
            echo '</div>';

        }
        ?>
        <?php
        if ($diseases != null) {
            echo '<hr>';
            echo '<div><img src="icons/001-stethoscope.png"> <b>Choroby</b>';
            echo '<ul>';
            foreach ($diseases as $disease) {
                echo "<li>" . $disease->name . "</li> ";
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>
        <?php
        if ($certificatesPath != null) {
            echo '<hr>';
            echo '<div><img src="icons/diploma.png"> <b>Certyfikaty</b><br><br>';

            foreach ($certificatesPath as $certificatePath) {
                echo '<a data-fancybox="certificates" href="' . $certificatePath . '"><img src="' . $certificatePath . '" style="margin: 10px; height: 100px; width: 100px; object-fit: cover; object-position: center; border-radius: 10%; "/></a>';
            }
            echo '</div>';
        }
        ?>
    </div>
</div>
<?php
if (!Yii::$app->user->isGuest)
    echo Html::button('Dodaj opinie', ['value' => \yii\helpers\Url::to(['site/add-review']), 'class' => 'btn btn-success btn-block', 'id' => 'modalButton']); ?>

</br>

<?php Pjax::begin(); ?>
<?= Html::a("Refresh", \yii\helpers\Url::to(['site/show', 'id' => Yii::$app->getRequest()->getQueryParam('id')]), ['class' => ' hidden', 'id' => 'refresh']) ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"> Opinie pacjentów </h3>
    </div>
    <div class="panel-body">
        <?php
        if ($patientReview == null) {
            if (Yii::$app->user->isGuest) {
                echo "<div class='text-center'>Nikt nie ocenił jeszcze tego lekarza.</br>
                   Aby dodać opinie muszisz być zalgowany!</br>";
                echo Html::a('Zaloguj', ["user/security/login"], ['class' => 'profile-link']);
                echo "</div>";
            } else {
                echo "<div class='text-center'>Nikt nie ocenił jeszcze tego lekarza.</br>
                    Bądź pierwszym pacjentem, który wystawi mu opinię!</br></br>";
                echo "</div>";
            }
        } else {
            foreach ($patientReview as $review) {
                echo "<hr>";
                echo "<div class='row'>"; //row
                echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="color: grey;">' . \app\models\UserDetails::find()->where(["user_id" => $review->user_id])->one()->name . " " . \app\models\UserDetails::find()->where(["user_id" => $review->user_id])->one()->last_name . "  •  " . $review->created_date . '</div>';
                echo "</div></br>"; //row
                echo "<div class='row'>"; //row
                echo '<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">';
                echo "Kompetencje</br> <span class='rating site' data-default-rating='" . $review->competences . "' disabled></span>";
                echo '</div><div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">';
                echo "Punktualny</br><span class='rating site' data-default-rating='" . $review->punctuality . "' disabled></span>";
                echo '</div><div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">';
                echo "Uprzejmy</br><span class='rating site' data-default-rating='" . $review->kindness . "' disabled></span>";
                echo '</div><div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">';
                echo "Godny polecenia</br><span class='rating site' data-default-rating='" . $review->recommendable . "' disabled></span>";
                echo '</div></div></br>';//end row
                echo "<div class='row'>"; //row
                echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                echo $review->comment;
                echo "</div>";
                echo "</div>";//end row
                //echo '<div class="text-center"></div>';
            }


        }
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $pagination,
        ]);
        ?>
    </div>
</div>
<script src="starRating/SimpleStarRating.js"></script>
<script>
    var ratings = document.getElementsByClassName('rating site');


    for (var i = 0; i < ratings.length; i++) {
        if (ratings[i].children.length < 1) {
            var rate = new SimpleStarRating(ratings[i]);
            ratings[i].addEventListener('rate', function (e) {
                console.log('Rating: ' + e.detail);
            });
        }
    }

</script>


<?php Pjax::end(); ?>

<?php
Modal::begin(['header' => '<h4>Dodaj opinie</h4>',
    'id' => 'modal',
    'size' => 'modal-lg']);

echo "<div id='modalContent'></div>";
Modal::end();
?>
<!------------------------------------------------------------------------->
<!------------------------------------------------------------------------->
<!------------------------------------------------------------------------->
<!------------------------------------------------------------------------->

<div id="test"></div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script>
    $(document).ready(function () {
        $('#showLess').click(function () {
            $("#description1").removeAttr('class');
            $("#description2").attr('class', 'hide');
        });
        $("#showMore").click(function () {
            $("#description2").removeAttr('class');
            $("#description1").attr('class', 'hide');
        });

        $("#modalButton").click(function () {
            $("#modal").modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        })
    });
</script>




