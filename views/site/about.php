<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

//$this->title = 'About';
//$this->params['breadcrumbs'][] = $this->title;
?>
<!--div class="site-about">
    <!--h1><--?= Html::encode($this->title) ?--><!--/h1-->
</br>
</br>
</br>
</br>

    <html>
    <head>

        <title>Test formularza</title>

    </head>
    <body>
    <form action="zamowienie.php" method="GET">
        Imię: <input type=text name="imie"/><br/>
        Nazwisko: <input type=text name="nazwisko"/><br/>
        Proszę fakturę do zamówienia: <input type=checkbox name="faktura"/></br></br>
        Zamawiam:<br/>
        <input type=radio name="zamowienie" value="coca-cola"/>Coca-cola<br>
        <input type=radio name="zamowienie" value="fanta"/>Fanta<br>
        <input type=radio name="zamowienie" value="sprite"/>Sprite<br>
        <br/>
        <input type=submit value="Wyślij"/>
    </form>


    </body>
    </html>

    <code><? __FILE__ ?></code>
    </div>
