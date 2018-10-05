<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 04.01.2018
 * Time: 18:32
 */
use yii\helpers\Html;
$this->params['breadcrumbs'][] = ['label' => 'Wyszukiwanie'];
$this->params['breadcrumbs'][] = "lekarz";

?>

<head>
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script-->
</head>


<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu.php') ?>

    </div>
    <div class="col-md-9">
        <p style="font-size: xx-large; color: #337ab7;">Historia Twoich wizyt</p>
        <?php
        if(count($visits)==0)
            echo '<p>Nie masz żadnycj wizyt w historii.</p>';
        else
        {
            for($i = 0; $i < count($visits); $i++) {
                echo '<div class="panel panel-default" >';
                echo '<div class="panel-heading" >';
                echo '<h3 class="panel-title" >'. $visits[$i]->date .'</h3 >';
                echo '</div >';
                echo '<div class="panel-body row" >';
                echo '<div class="col-md-2 " style="font-size: medium;"> <strong>Godzina:</strong><br>'.  date('G:i', strtotime($visits[$i]->time) ) .'</div>';
                echo "<div class='col-sm-2 '>";
                if ($photos[$i] != '0') {
                    echo '<img id="blah" src="uploads/doctor_' . $doctors[$i]->id . '/' . $photos[$i] . '" style="float: left; height: 110px; width: 90px; object-fit: cover; object-position: center; border-radius: 10%; "/>';
                } else {
                    echo '<div class="photo" style="float:left; height: 110px; width: 90px; border: 1px dashed cornflowerblue; background-color: aliceblue; border-radius: 10%; background-size: 100px 100px; background-image: url(icons/add_avatar_small.png);  background-repeat: no-repeat; background-position: center;"></div>';

                }
                echo "</div>";
                echo '<div class="col-md-3" style="font-size: medium;">'. $users_detail[$i]->name.' '. $users_detail[$i]->last_name.'<br>';
                echo '<div style="color: #777 ">';
                foreach ($categories[$i] as $category){
                    echo \app\models\MainCategory::findOne($category)->name.' ';
                }
                echo '</div>';
                echo '</div>';
                echo '<div class="col-md-3 "><span class="glyphicon glyphicon-map-marker" style="float: left; margin-right: 10px;" ></span><p style="font-size: medium;">'. $offices[$i]->name.'</p>'. $offices[$i]->street .'<br>'. $offices[$i]->postal_code .' '. $offices[$i]->city.'</div>';
                echo '<div class="col-md-2 ">';
                echo '</div>';
                echo '</div>';
                echo '</div>';

            }
        }

        ?>

    </div>
</div>
