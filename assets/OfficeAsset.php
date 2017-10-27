<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 10.10.2017
 * Time: 07:45
 */

namespace app\assets;

use yii\web\AssetBundle;


class OfficeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/office.css',
    ];
   /* public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];*/
}