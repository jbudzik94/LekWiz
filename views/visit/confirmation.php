<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 23.12.2017
 * Time: 14:55
 */
?>
<div class="row">
    <div class="col-xs-12">
        <!--div id="w0" class="alert-dismissible alert-info alert fade in"-->
        <!--button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button-->




        <?php if (Yii::$app->session->hasFlash('confirmation-fail'))
        {
            echo '<div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
                Yii::$app->session->getFlash('confirmation-fail') .
                '</div>';
        }
        elseif (Yii::$app->session->hasFlash('confirmation-success'))
        {
            echo '<div class="alert alert-info alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
                Yii::$app->session->getFlash('confirmation-success') .
                '</div>';
        }
        elseif (Yii::$app->session->hasFlash('confirmation-expired'))
        {
            echo '<div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
                Yii::$app->session->getFlash('confirmation-expired') .
                '</div>';
        }
        ?>

        <!--/div-->
    </div>
</div>
