<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 08.01.2018
 * Time: 20:38
 */

use yii\widgets\ActiveForm;

?>

<div class="form-group" >
    <label style="float: left; width: 10%;">Gabinet:</label>
    <div id="office">
        <?= \app\models\Office::findOne(\app\models\Calendar::findOne($calendar_id)->office_id)->name; ?>
    </div>
    <div class="hidden" id="calendar_id">
        <?= $calendar_id; ?>
    </div>
</div>
<div class="form-group" >
    <label style="float: left; width: 10%;">Dzień:</label>
    <div id="date">
        <?= $date; ?>
    </div>
</div>
<div class="form-group" style=" margin-bottom: 10px;">
    <label style="float: left; width: 10%;">Godzina:</label>
    <div id="time">
        <?= $time; ?>
    </div>
</div>
<?php
$currentService = 0;

echo '<div class="form-group">';
echo '<label for="usr">Imię:</label>';
echo '<input type="text" class="form-control" id="name">';
echo '<label for="usr">Nazwisko:</label>';
echo '<input type="text" class="form-control" id="last_name">';
echo '<label for="usr">Numer telefonu:</label>';
echo '<input type="text" class="form-control" id="phone">';
echo '<label for="usr">Usługa:</label>';
echo \yii\helpers\Html::dropDownList('list', $currentService, \yii\helpers\ArrayHelper::map($services, 'id', 'name'), ['class' => "form-control", 'id' => 'service_id']);
echo '</div><br>';

?>
<?php echo \yii\helpers\Html::submitButton("Zapisz", ['class' => 'btn btn-block btn-primary', 'id' => 'submit']); ?>

<script>
    $('#submit').on('click', function () {
        console.log("submit form");
        var name = $("#name").val();
        var last_name = $("#last_name").val();
        var time = $('#time').text();
        var date = $('#date').text();
        var phone = $('#phone').val();
        var service_id = $('#service_id').val();
        var calendar_id = $('#calendar_id').text();

        if(name == '' || last_name == '' ){
            alert("Muszissz uzupełanić wszystkie dane" + name +" "+ last_name +" "+time+" "+date+" "+phone+" "+service_id);
        }
        else {
            $.ajax({
                url: "index.php?r=calendar/save-append-patient",
                type: "POST",
                data: {
                    name: name,
                    last_name: last_name,
                    phone: phone,
                    service_id: service_id,
                    date: date,
                    time: time,
                    calendar_id: calendar_id
                },
                success: function (result) {
                  //  $("#refresh").click();
                    $("#modal").modal('hide');
                    console.log("forma przeszłana" + result);
                }
                /*error: function () {
                    alert("Coś poszło nie tak");
                }*/
            });
        }
    });
</script>