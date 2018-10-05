<?php

use kartik\rating\StarRating;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>

<link rel="stylesheet" href="starRating/SimpleStarRating.css">
<style>

    table {
        display: inline-block;
    }

    td {
       + padding: 1em;
    }

    .golden {
        color: #ee0;
        background-color: #444;
    }

    .big-red {
        color: #f11;
        font-size: 50px;
    }
</style>


<div class="panel-body">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="competences">

           Kompetencje</br><span class="rating form"></span>
        </div>



        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="punctuality">

            Punktualność</br> <span class="rating form"></span>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 " id="kindness">

            Uprzejmy </br> <span class="rating form"></span>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 " id="recommendable">

            Godny polecenia </br> <span class="rating form"></span>
        </div>


    </div>
    <!--?php echo $form->field($patientReviewForm, 'comment')->textarea(['rows' => '6', 'style'=>"resize: vertical;"]);?>
    <!--?php echo $form->field($patientReviewForm, 'doctor_id', ['value'=> 13] );?>//->hiddenInput()->label(false);?-->
    <!--?php echo $form->field($patientReviewForm, 'doctor_id')->hiddenInput(['value'=> Yii::$app->getRequest()->getQueryParam('id')])->label(false); ?!-->
   <br>
    <div id="divComment" class="form-group">
            <textarea placeholder="Tutaj napisz swoją opinie..." style="resize: vertical;" class="form-control"
                      id="comment" rows="3"></textarea>
    </div>
    <!--?= \yii\helpers\Html::input('submit', '0', "dodaj"); ?-->
    <!--?= \yii\helpers\Html::submitButton("Dodaj opinie", [ 'class' => 'btn btn-primary']); ?-->
    <?php echo \yii\helpers\Html::submitButton("Dodaj opinie", ['class' => 'btn btn-primary', 'id' => 'submit']); ?>
</div>

<script src="starRating/SimpleStarRating.js"></script>
<script>

    var ratingss = document.getElementsByClassName('rating form');
    var recommendable = '0';
    var kindness = '0';
    var competences = '0';
    var punctuality  = '0';


    console.log(ratingss);
    for (var i = 0; i < ratingss.length; i++) {
        var r = new SimpleStarRating(ratingss[i]);

    }
    ratingss[0].addEventListener('rate', function (e) {
        console.log('Rating: [0] competences' + e.detail);
         competences = e.detail;
    });
    ratingss[1].addEventListener('rate', function (e) {
        console.log('Rating: [1] punctuality' + e.detail);
        kindness = e.detail;
    });
    ratingss[2].addEventListener('rate', function (e) {
        console.log('Rating: [2] kindness' + e.detail);
        punctuality = e.detail;
    });
    ratingss[3].addEventListener('rate', function (e) {
        console.log('Rating: [3] recomendable' + e.detail);
        recommendable = e.detail;
    });

    $('#submit').on('click', function () {
        console.log("submit form");
        var doctor_id = $("#paramId").text();
        var comment = $("#comment").val();
        var competencesStr = competences.toString();
        var kindnessStr = kindness.toString();
        var punctualityStr = punctuality.toString();
        var recommendableStr = recommendable.toString();
        if(competencesStr == 0 || kindnessStr == 0 || punctualityStr == 0 || recommendableStr ==0 ){
            alert("Oceń wszystkie aspekty lekarza"+ comment.length);
        }
        else if(comment.length < 100 && comment.length >400){
            alert("Tekst powinien zawierać pomiędzy 100 a 400 znaków")
        }
        else {


            $.ajax({
                url: "index.php?r=site/save-review",
                type: "POST",
                data: {
                    doctor_id: doctor_id,
                    competences: competencesStr,
                    kindness: kindnessStr,
                    kindness: kindnessStr,
                    punctuality: punctualityStr,
                    recommendable: recommendableStr,
                    comment: comment
                },
                success: function (result) {
                    $("#refresh").click();
                    $("#modal").modal('hide');
                    console.log("forma przeszłąna" + result);
                },
                error: function () {
                    alert("Coś poszło nie tak");
                }
            });
        }
    });
</script>
