<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 03.11.2017
 * Time: 17:39
 */

//$urlCity = \yii\helpers\Url::to(['city-list']);
$urlCategory = \yii\helpers\Url::to(['category-list']);
//$urlTest = \yii\helpers\Url::to(['test-list']);


use kartik\select2\Select2;
use yii\web\JsExpression;


//$cityDesc = empty($model->city) ? '' : City::findOne($model->city)->name;

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&&region=pl&key=AIzaSyBzRowaMLhYZExP3dnMJBy2P3PWWYzTPu4"></script>

<script>

    function autocompleteLoad() {
        var input = document.getElementById('city');
        var countryRestrict = {'country': 'pl'}; // only Poland
        var options = {
            types: ['(cities)'], // only Cities name
            componentRestrictions: countryRestrict,
        };
        // documentation: developers.google.com/maps/documentation/javascript/reference#Autocomplete
        var autocomplete = new google.maps.places.Autocomplete(input, options);
    }
    google.maps.event.addDomListener(window, 'load', autocompleteLoad);
    $('document').ready(function () {
        function addToUrl(elem, selectNr) {
            if ($(selectNr).val().length != 0) {
                var url = $('#submit-button').attr('href');
                var endIndex = url.search(elem) + elem.length + 1;
                url = url.substring(0, endIndex).concat($(selectNr).val(), url.substring(endIndex + 1, url.length));
                $('#submit-button').attr('href', url);
                console.log(url);
                return url;
            }
        }

         $('#submit-button').click(function () {
            addToUrl("city", "#city");
            addToUrl("category", "#w0");
            addToUrl("name", "#name");
            console.log("miasto " + $('#city').val());
            console.log("specjalizacja " + $('#w0').val());
            console.log("imie " + $('#name').val());
         //   document.getElementById('name').value = "";

         });

    });

</script>
<div class="row">

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        <div class="form-group ">
            <input  class="form-control input-lg" id="name" placeholder="Imię i nazwisko..." autocomplete="off">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        <div class="form-group">
            <input type="text" class="form-control input-lg input-search" id="city" placeholder="Miasto...">
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        <?php
        echo Select2::widget([
            'name' => 'specjalizacja',
            'options' => ['placeholder' => 'Specjalizacja...'],
            'size' => Select2::LARGE,
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 2,
                'ajax' => [
                    'url' => $urlCategory,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(main_category) { return main_category.text; }'),
                'templateSelection' => new JsExpression('function (main_category) { return main_category.text; }'),
            ],
        ]);
        ?>
    </div>




    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
        <a href="index.php?r=site/search&city=0&category=0&name=0" id="submit-button" class="btn  btn-lg" style="color: #4f7cc9; background-color: whitesmoke;"
           role="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Szukaj</a>
    </div>

</div>



