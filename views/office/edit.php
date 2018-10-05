<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 30.10.2017
 * Time: 12:53
 */

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php

$this->title = 'Gabinety i usługi';
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->session->hasFlash('office-edit')) {
    echo '<div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
        Yii::$app->session->getFlash('office-edit') .
        '</div>';
}

?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&&region=pl&key=AIzaSyBzRowaMLhYZExP3dnMJBy2P3PWWYzTPu4"></script>

    <?= "<script>" ?>
    <?= 'var office_id = ' . json_encode($id, JSON_PRETTY_PRINT) . ';' ?>
    <?= "</script>" ?>

    <script>
        function autocompleteLoad() {
            var input = document.getElementById('addofficeform-city');
            var countryRestrict = {'country': 'pl'}; // only Poland
            var options = {
                types: ['(cities)'], // only Cities name
                componentRestrictions: countryRestrict,

            };
            // documentation: developers.google.com/maps/documentation/javascript/reference#Autocomplete
            var autocomplete = new google.maps.places.Autocomplete(input, options);
        }

        google.maps.event.addDomListener(window, 'load', autocompleteLoad);
        $(document).ready(function() {

            /*var clickedOrPressed = function() {
console.log("clicked or press function");
                var empty = true;
                if ($('div.field-addofficeform-street').hasClass('has-error') != true && $('div.field-addofficeform-postalcode').hasClass('has-error')!= true && $('div.field-addofficeform-name').hasClass('has-error')!= true && $('div.field-addofficeform-city').hasClass('has-error')!= true ) {
                    empty = false;
                    console.log('wszystko jest ok');
                }else
                    setTimeout(clickedOrPressed, 500);

                if (empty) {
                    $('#next1').attr('disabled', 'disabled');
                } else {
                    $('#next1').removeAttr('disabled');
                }
            };*/
           // $(document).keypress(clickedOrPressed);

         //   $(document).click(clickedOrPressed);





            var service = new Array();
            var servicearr = new Array();
            var servicePrice = new Array();
            var servicePricearr = new Array();
            //var existedService = new Array();
            //var existedServicearr = new Array();
           // var existedServicePrice = new Array();
         //   var existedServicePricearr = new Array();
            var toRemove = new Array();
            var toRemovearr = new Array();
            var name;
            var street;
            var postalCode;
            var city;
            $('.submit-button').click(function () {

                service =  $('input[name ="AddOfficeForm[servicesName][]"]');
                servicePrice =  $('input[name ="AddOfficeForm[servicesPrice][]"]');
             //   existedService =  $('input[name ="AddOfficeForm[servicesName][]"]');
               // existedServicePrice =  $('input[name ="AddOfficeForm[servicesPrice][]"]');
                name =  $('input[name ="AddOfficeForm[name]"]').val();
                street =  $('input[name ="AddOfficeForm[street]"]').val();
                postalCode =  $('input[name ="AddOfficeForm[postalCode]"]').val();
                city =  $('input[name ="AddOfficeForm[city]"]').val();
             //   console.clear();

             /*   existedService.each(function() {
                    console.log("service z pętli: "+$(this).attr('id'));
                    existedServicearr.push($(this).attr('id'));
                });
                servicearr.pop();

                existedServicePrice.each(function() {
                    console.log("servPrice z pętli" + $(this).attr('id'));
                    existedServicePricearr.push($(this).attr('id'));
                });
                existedServicePricearr.pop();
                */

                service.each(function() {
                    console.log("service z pętli: "+$(this).val());
                    servicearr.push($(this).val());
                });
                servicearr.pop();

                servicePrice.each(function() {
                    console.log("servPrice z pętli" + $(this).val());
                    servicePricearr.push($(this).val());
                });
                servicePricearr.pop();

/*                toRemove.each(function() {
                    console.log("servPrice z pętli" + $(this).val());
                    toRemovearr.push($(this).val());
                });
                toRemovearr.pop();
*/
                console.log("office_id "+ office_id);

                console.log("servicePrice size "+ servicePrice.size());
                console.log("service size "+service.size());
                console.log("servicePriceArr size "+ servicePricearr.length);
                console.log("service sizeArr "+servicearr.length);
                console.log(postalCode);
                console.log(toRemove);
                console.log(servicePricearr);
                console.log(city);
                console.log(street);
                for(var i = 0; i < servicePricearr.length; i++){
                    console.log("servicePricearr["+i+"]"+servicePricearr[i]);
                }

           $.post('index.php?r=office/edit&id=' + office_id,
           // $.post('/basic3/web/index.php?r=office/index',// + office_id,
                    {
                        servicesName: JSON.stringify(servicearr),
                        servicesPrice: JSON.stringify(servicePricearr),
                        toRemove: JSON.stringify(toRemove),
                        //existedServicesName: JSON.stringify(existedServicearr),
                        //existedServicesPrice: JSON.stringify(existedServicePricearr),
                        name: name,
                        street: street,
                        city: city,
                        postalCode: postalCode
                    }
                    // function (data, status) {
                    // alert(data);
                    // $('#info' ).html( '<div class="alert alert-success alert-dismissable">' +
                    //   '  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                    //  '  Dane zostały zaktualizowane.' +
                    // '' '</div>' );
                )
            });


            //here first get the contents of the div with name class copy-fields and add it to after "after-add-more" div class.

            var i =1;
            $(".add-more-services").click(function(){
                var html = $(".copy-fields-services").html();
                $(".after-add-more-services").after(html);
            });

            //here it will remove the current value of the remove button which has been pressed
            $("body").on("click",".remove",function(){
                $(this).parents(".group-input").remove();
               //console.log( $(this).parent(".group-input").attr("id").text());
            });

            $("body").on("click", ".remove", function () {
                $(this).parents(".control-group").remove();
            });
            $("body").on("click", ".remove-existed", function () {
                $(this).parents(".control-group").remove();
                console.log($(this).parents(".control-group")[0].getAttribute("id"));
                toRemove.push($(this).parents(".control-group")[0].getAttribute("id"));

            });

        });
    </script>

    <style>
        div.empty-certificate {
            cursor: pointer;
            background-image: url(icons/add.png);
            height: 120px;
            width: 120px;
            background-size: 50px 50px;
            background-repeat: no-repeat;
            background-position: center;
            border: 1px dashed cornflowerblue;
            background-color: aliceblue;
            border-radius: 10%;
        }
        div.certificate {
            cursor: auto;
            position: relative;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            height: 120px;
            width: 120px;
            border: 1px dashed cornflowerblue;
            border-radius: 10%;
        }

    </style>


</head>

<?php
$this->title = 'Offices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">


        <!--Lokalizacja -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Lokalizacja</h3>
            </div>
            <div class="panel-body">
                <div id="location">
                    <?php $form = ActiveForm::begin(['id' => 'form-add-office',
                        'action'=>'/index.php?r=user/settings/add-office-standard',
                        'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($model, 'name')->textInput(['value' =>$office->name]) ?>
                    <?= $form->field($model, 'street')->textInput(['value' =>$office->street]) ?>
                    <?= $form->field($model, 'postalCode')->textInput(['value' =>$office->postal_code]) ?>
                    <?= $form->field($model, 'city')->textInput(['value' =>$office->city]) ?>



                </div>

            </div>

        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Cennik</h3>
            </div>
            <div class="panel-body">
                <div id="price-list">
                    <div class="input-group control-group after-add-more-services">
                        <?= Html::button('Dodaj', ['class' => 'btn btn-success add-more-services']) ?>
                    </div>
                    <!---------div class="group-input"  style="margin-top:10px; overflow: hidden; width: 100%; ">
                        <div id="service-name" style="width: 400px; float:left; margin: 0;">
                            <!-------?= $form->field($model, 'servicesName[]')->textInput(['maxlength' => 255, 'style' => 'width: 80%;', 'placeholder' => "Nazwa usługi", 'value' => $service->name])->label(false); ?>
                        </div>
                        <div id="service-price" style="width: 300px;  margin-right: 0; float:left; ">
                            <!----?= $form->field($model, 'servicesPrice[]')->textInput(['maxlength' => 255, 'style' => 'width: 20%;', 'placeholder' => "Cena" ])->label(false); ?>
                        </div>
                        <div class="input-group" style="width: 90px;  margin: 0; float:left;">
                            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                        </div>
                    </div------>
                    <?php
                    foreach ($services as $servicee) {
                        echo '<div id='.$servicee->id.' class="control-group input-group" style="margin-top:10px">
                                <div id="service-name" style="width: 400px; float:left; margin: 0;">';
                        echo $form->field($model, 'existedServicesName[]')->textInput(['maxlength' => 255, 'style' => 'width: 80%;', 'placeholder' => "Nazwa usługi", 'value' => $servicee->name ])->label(false);
                        echo    '</div>
                                <div id="service-price" style="width: 300px;  margin-right: 0; float:left; ">';
                        echo $form->field($model, 'existedServicesPrice[]')->textInput(['maxlength' => 255, 'style' => 'width: 20%;', 'placeholder' => "Cena", 'value' => $servicee->price ])->label(false);
                        echo    '</div>
                                    <div class="input-group" style="width: 90px;  margin: 0; float:left;">
                                        <button class="btn btn-danger remove-existed" type="button"><i class="glyphicon glyphicon-remove"></i> Usuń</button>
                                    </div>
                             </div>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <!--div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Zdjęcia</h3>
            </div>
            <div class="panel-body">
                <div id="photo">
                    <!--?php
                    $x=1;
                    //for ($i = 0; $i < count($certificatesName); $i++) {
                    for ($i = 0; $i < 0; $i++) {
                        echo ' <div id="add-certificate-' . ($i + 1) . '" style=" float: left; margin: 30px;">
                    <div class="certificate from-server" id="certificate-' . ($i + 1) . '">'.
                           // '<img src="uploads/doctor_' . $office->id . '/' . $photoName[$i] . '" id="certificate-img-' . ($i + 1) . '" style="width: 130px; height: 130px; object-fit: cover; object-position: center; border-radius: 10%; " class="show-certificate">'.
                            '<a class= " delete-cert-a delete-certificate-' . ($i + 1) . '" style="float: left; position: absolute; left: 0px; top: 0px;" onclick="deleteCertFromServer(' . ($i + 1) . ')">'.
                            '<img id="delete' . ($i + 1) . '" class="delete-image" src="icons/delete.png" alt="usuń" />'. '</a>' .
                            '      </div>
                </div>
                ';
                        $x++; }
                    for($x; $x <= 6; $x++) {
                        echo '  <div id="add-certificate-'.$x.'" style=" float: left; margin: 30px;">
                    <div class="empty-certificate" id="certificate-'.$x.'">
                    </div>
                </div>';
                    }
                    ?>

                </div>

            </div>

        </div-->
        <div class="panel-body">
            <div class="form-group">
                <div>
                    <?= Html::button(Yii::t('user', 'Zapisz gabinet'), ['class' => 'btn btn-success submit-button btn-block ']) ?>
                    <br>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>




<div class="copy-fields-services hide">
    <div class="group-input"  style="margin-top:10px;  overflow: hidden; width: 100%">
        <div id="service-name" style="width: 400px; float:left; margin: 0;">
            <?= $form->field($model, 'servicesName[]')->textInput(['maxlength' => 255, 'style' => 'width: 80%;', 'placeholder' => "Nazwa usługi" ])->label(false); ?>
        </div>
        <div id="service-name" style="width: 300px; float:left; margin: 0;">
            <?= $form->field($model, 'servicesPrice[]')->textInput(['maxlength' => 255, 'style' => 'width: 20%;', 'placeholder' => "Cena"])->label(false); ?>
        </div>
        <div class="input-group" style="width: 90px;  margin: 0; float:left;">
            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Usuń</button>
        </div>
    </div>
</div>













