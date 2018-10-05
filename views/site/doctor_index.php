<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 17.11.2017
 * Time: 09:52
 */


use yii\helpers\Html;
use kartik\rating\StarRating;


$this->title = 'Wyszukiwanie';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <!--?php
    for ($i = 0; $i < count($result); $i++) {

        echo '<div class="panel panel-default">';
        echo '<div class="panel-body">';
        echo '<div class="row">';

        echo "<div class='col-sm-2'>";
        if ($photo[$i] != '0') {
            echo '<img id="blah" src="uploads/doctor_' . $doctorsIds[$i] . '/' . $photo[$i] . '" style="float: left; height: 140px; width: 110px; object-fit: cover; object-position: center; border-radius: 10%; "/>';
        } else {
            echo '<div class="photo" style="float:left; height: 140px; width: 110px; border: 1px dashed cornflowerblue; background-color: aliceblue; border-radius: 10%; background-size: 100px 100px; background-image: url(icons/add_avatar_small.png);  background-repeat: no-repeat; background-position: center;"></div>';

        }
        echo "</div><div class='col-sm-8'>";

        echo "<div style='color: #337ab7; font-size: 1.7em;'><a href='index.php?r=site/show&id=" . $doctorsIds[$i] . "'>" . $degrees[$i] . " " . $result[$i]->name . " " . $result[$i]->last_name . "</a></div>";

        echo "<div style='color: #777;'>";
        foreach ($categorys[$i] as $category) {
            echo $category . " ";
        }
        echo "</div></br>";

        foreach ($offices[$i] as $office) {
            echo "<span class='glyphicon glyphicon-map-marker' style='float: left; margin-right: 10px; font-size: 1em;' ></span><div style=' font-size: 1em; color: #444;'>" . '   ' . $office->name . ", " . \app\models\City::findOne($office->city_id)->name . ", ul." . $office->street . "</div>";

        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";


            echo "</br>";
    }
    ?!-->
    <?php
    for ($i = 0; $i < count($doctors); $i++) {
        echo '<div class="panel panel-default">';
        echo '<div class="panel-body">';
        echo '<div class="row">';


        echo "<div class='col-sm-2'>";
        if ($photos[$i] != null) {
            echo '<img id="blah" src="uploads/doctor_' . $doctors[$i]->id . '/' . $photos[$i]->name . '" style="float: left; height: 140px; width: 110px; object-fit: cover; object-position: center; border-radius: 10%; "/>';
        } else {
            echo '<div class="photo" style="float:left; height: 140px; width: 110px; border: 1px dashed cornflowerblue; background-color: aliceblue; border-radius: 10%; background-size: 100px 100px; background-image: url(icons/add_avatar_small.png);  background-repeat: no-repeat; background-position: center;"></div>';
        }
        echo '</div>'; //end col

        echo "<div class='col-sm-7'>";
        echo '<div style="float: left; font-size: 25px; margin-right: 30px;">';
        echo Html::a($userDetails[$i] ->name.' '.$userDetails[$i] ->last_name, ['site/show', 'id' => $doctors[$i]->id]);
        echo '</div>';
        if($doctors[$i]->rating != 0)
        echo StarRating::widget([
            'name' => 'rating',
            'value' => $doctors[$i]->rating,
            'pluginOptions' => [
                'displayOnly' => true,
                'size' => 'xs',
                'theme' => 'krajee-svg'
            ]
        ]);

        echo "<div style='margin-bottom: 10px; color: #777; clear: both;'>";
        echo \app\models\MainCategory::findOne($doctors[$i]->main_category_id)->name;
        foreach ($categories[$i] as $category)
            echo ", ".$category->name;
        echo "</div>";

        foreach ($offices[$i] as $office){
            echo "<div style='margin: 5px;'>";
            echo "<span class='glyphicon glyphicon-map-marker' style='margin-right: 10px; color: #737373;'></span>".$office->name.", ". $office->city." ".$office->street."<br>";
            echo "</div>";
        }
        echo '</div>'; //end col

        echo "<div class='col-sm-3'>";
        echo  Html::a("Umów wizytę", ['site/show', 'id' => $doctors[$i]->id],
                [
                    'id' => 'delete-visit',
                    "class" => "btn btn-block btn-primary pull-right",
                    'role' => "button",
                ]);
        echo '</div>'; //end col


        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo \yii\widgets\LinkPager::widget([
        'pagination' => $pagination,
    ]);


    ?>

</div>
