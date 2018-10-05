<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 05.01.2018
 * Time: 15:17
 */


use yii\helpers\Html;
use yii\widgets\Menu;
use yii\bootstrap\Collapse;

/**
 * @var dektrium\user\models\User $user
 */

$user = Yii::$app->user->identity;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            Kalendarz
        </h3>
    </div>
    <div class="panel-body">
        <?php
        //$office[0] = ['label' => $office->name, 'url' => ['/calendar/settings', 'office_id' => '116', 'day_id' => '1']] ;
        //$office[1] = ['label' => 'Mój grafik3', 'url' => ['/user/settings/account']] ;

        //$item = [ ['label' => 'Mój grafik', 'url' => ['/calendar/show-schedule']] ];
       // array_push($item, $office[0]);
        ?>
        <?= Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked',
            ],
            'items' => $item
        ]);

        ?>
    </div>
</div>

