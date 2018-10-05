<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 05.01.2018
 * Time: 19:48
 */
use yii\widgets\Menu;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
         Wizyty
        </h3>
    </div>
    <div class="panel-body">
        <?= Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked',
            ],
            'items' => [
                ['label' => 'Nadchodzące wizyty', 'url' => ['/visit/my-visits']],

                ['label' => 'Historia wizyt', 'url' => ['/visit/visits-history']],


            ],
        ]);


        ?>
    </div>
</div>

