<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<p>Witaj,</p>

<p style="max-width: 550px;">W celu zakończenia rejestracji na wizytę w dniu <?= $date ?> o godzinie <?= $time ?> kliknij proszę w link poniżej.</p>
<a style="max-width: 550px;" href="<?= $confirmationLink ?>"><?= $confirmationLink ?></a>
<p>Jeśli nie masz pojęcia, skąd wziął się ten e-mail, po prostu go zignoruj.</p>