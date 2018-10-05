<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 05.12.2017
 * Time: 13:34

 */

use yii\widgets\Pjax;
use yii\helpers\Html;
?>
<?= $tekst ?>
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
?><?php
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
?><?php
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
?><?php
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
?><?php
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
?><?php
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
?><?php
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
?><?php
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
?><?php
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
<?php Pjax::begin(); ?>
<?= Html::a("Refresh", ['site/time'], ['class' => 'btn btn-lg btn-primary']) ?>
<h1>Current time: <?= $time ?></h1>
<?php Pjax::end(); ?>
