<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 04.01.2018
 * Time: 16:17
 */
?>

<p>Witaj,</p>

<p style="max-width: 550px;">Twoja wizyta w dniu <?= $date ?> o godzinie <?= date('G:i', strtotime($time) )?>  u lekarza <?= $user_details->name." ".$user_details->last_name ?> została odwołana.</p>

<p>Jeśli nie masz pojęcia, skąd wziął się ten e-mail, po prostu go zignoruj.</p>