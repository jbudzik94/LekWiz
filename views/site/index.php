<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\IndexSearch */

//$url = \yii\helpers\Url::to(['city-list']);

//use kartik\select2\Select2;
//use yii\web\JsExpression;
//use app\models\City;
$this->title = 'My Yii Application';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

?>
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script-->


<style>
    .top-buffer {
        margin-top: 50px;
    }

    .white {
        color: white;
    }

    h1.white {
        color: white;
    }

    .top-buffer-description {
        margin-top: 50px;
    }

</style>


<div class="container-fluid">
    <div style="background-color: #679CCB; margin-left: -140px; margin-right: -140px; padding-bottom: 30px; margin-top: -50px;">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4 top-buffer">
                <h1 class="white text-center">Najlepsi lekarze dla Ciebie</h1>

            </div>
        </div>
        <div class="row text-center top-buffer">
            <!--div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 white">
                <span class="glyphicon glyphicon-search" style="font-size: 4em;"></span>
                <br><br>Wyszukaj lekarza
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 " style="color: #fff;"><span
                        class="glyphicon glyphicon-chevron-right" style="font-size: 3em;"></span></div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 white">
                <span class="glyphicon glyphicon-calendar" style="font-size: 4em;"></span>
                <br><br>Zarezerwuj termin
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 " style="color: #fff;"><span
                        class="glyphicon glyphicon-chevron-right" style="font-size: 3em;"></span></div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 white">
                <span class="glyphicon glyphicon-home" style="font-size: 4em;"></span>
                <br><br>Idź na wizytę
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 "></div-->
            <div style="color: white; font-size: medium;">
                Wyszukaj specjaliste w swojej okolicy...
            </div>
        </div>
        <div class="row top-buffer">
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-2">
                <?php echo $this->render('_search'); ?>

                <!--?php
                $form = ActiveForm::begin();
                echo $form->field($model, 'name')->widget(Select2::classname(), [
                //  'initValueText' => $cityDesc, // set the initial display text
                'options' => ['placeholder' => 'Wyszukaj miasto...'],
                'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                'errorLoading' => new JsExpression("function () { return 'Wyszukiwanie...'; }"),
                ],
                'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
                ]);
                ActiveForm::end();
                ?-->

            </div>
        </div>
    </div>
    <div class="row top-buffer-description">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
            <div class="row">
                <div class="col-md-10 col-md-offset-1"
                     style="background-color: white; border-radius: 15px; padding: 20px;">
                    <span class="glyphicon glyphicon-search d-inline-block pagination-centered"
                          style="font-size: 2em; display: inline-block; vertical-align: middle;"></span>
                    <span class="pagination-centered "
                          style="display: inline-block; vertical-align: middle; margin-left: 10px; font-size: medium;">Wyszukaj lekarza</span>
                    <div   style="margin-top: 20px;">
                        Wyszukaj lekarza lub specjalistów. Przeglądaj opinie innych pacjentów.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
            <div class="row">
                <div class="col-md-10 col-md-offset-1"
                     style="background-color: white; border-radius: 15px; padding: 20px;">
                    <span class="glyphicon glyphicon-calendar d-inline-block pagination-centered"
                          style="font-size: 2em; display: inline-block; vertical-align: middle;"></span>
                    <span class="pagination-centered"
                          style="display: inline-block; vertical-align: middle; margin-left: 10px; font-size: medium;">Zarezerwuj termin</span>
                    <div  style="margin-top: 20px;">
                        Wybierz odpowiadający Ci termin, podaj swoje dane, potwierdź... i to wszystko.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
            <div class="row">
                <div class="col-md-10 col-md-offset-1"
                     style="background-color: white; border-radius: 15px; padding: 20px;">
                    <span class="glyphicon glyphicon-home d-inline-block pagination-centered"
                          style="font-size: 2em; display: inline-block; vertical-align: middle;"></span>
                    <span class="pagination-centered"
                          style="display: inline-block; vertical-align: middle; margin-left: 10px; font-size: medium;">Idź na wizytę</span>
                    <div  style="margin-top: 20px;">
                        Możesz w każdej chwili przejrzeć listę umówionych wizyt.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
            <div class="row">
                <div class="col-md-10 col-md-offset-1"
                     style="background-color: white; border-radius: 15px; padding: 20px;">
                    <span class="glyphicon glyphicon-piggy-bank d-inline-block pagination-centered"
                          style="font-size: 2em; display: inline-block; vertical-align: middle;"></span>
                    <span class="pagination-centered" style="display: inline-block; vertical-align: middle; margin-left: 10px; font-size: medium;">  Usługa jest bezpłatna</span>
                    <div  style="margin-top: 20px;">
                       // Korzystanie z serwisu LekWiz jest dla pacjentów zupełnie bezpłatne.

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
