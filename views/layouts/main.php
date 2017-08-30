<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);


    if(!Yii::$app->user->isGuest) {
        //  $user = new \app\models\User();

        // $user = \app\models\User::findIdentity(Yii::$app->user->id);
        //$user = \app\models\User::findOne()
        $userId = Yii::$app->user->getId();
        $userDetails = new \app\models\UserDetails();
        $userDetails = \app\models\UserDetails::find()->where(['user_id' => $userId])->one();
        $role = $userDetails->role;

        if ($role == 'lekarz')
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    ['label' => 'My profile',

                        'items' => [


                            ['label' => 'settings', 'url' => ['/user/settings/account']],
                            '<li class="divider"></li>',
                            //'<li class="dropdown-header">Dropdown Header</li>',
                            ['label' => 'blabla.', 'url' => ['#']]
                        ],
                        'visible' => !(Yii::$app->user->isGuest)


                        //'url' => ['/user/settings/account']

                    ],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Sign in', 'url' => ['/user/security/login']] :
                        ['label' => 'Sign out (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/user/security/logout'],
                            'linkOptions' => ['data-method' => 'post']],

                    ['label' => 'Register',
                        'items' => [
                            ['label' => 'jako pacjent', 'url' => ['/user/registration/register']],
                            '<li class="divider"></li>',
                            //'<li class="dropdown-header">Dropdown Header</li>',
                            ['label' => 'jako lekarz', 'url' => ['/user/registration/register-doctor']],
                        ],
                        'visible' => Yii::$app->user->isGuest
                    ]


                    // ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest]
                ],
            ]);

        else  //jest pacjentem
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    ['label' => 'My profile',

                        'items' => [


                            ['label' => 'settings', 'url' => ['/user/settings/account']],
                            '<li class="divider"></li>',
                            //'<li class="dropdown-header">Dropdown Header</li>',
                            ['label' => 'coś tam ...', 'url' => ['#']]
                        ],
                        'visible' => !(Yii::$app->user->isGuest) //zalogowany


                        //'url' => ['/user/settings/account']

                    ],
                  //  Yii::$app->user->isGuest ?
                    //    ['label' => 'Sign in', 'url' => ['/user/security/login']] :
                        ['label' => 'Sign out (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/user/security/logout'],
                            'linkOptions' => ['data-method' => 'post']],

                    /**['label' => 'Register',
                        'items' => [
                            ['label' => 'jako pacjent', 'url' => ['/user/registration/register']],
                            '<li class="divider"></li>',
                            //'<li class="dropdown-header">Dropdown Header</li>',
                            ['label' => 'jako lekarz', 'url' => ['/user/registration/register-doctor']],
                        ],
                        'visible' => Yii::$app->user->isGuest
                    ]*/


                    // ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest]
                ],
            ]);




    }
    else {


        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
                ['label' => 'My profile',

                    'items' => [


                        ['label' => 'settings', 'url' => ['/user/settings/account']],
                        '<li class="divider"></li>',
                        //'<li class="dropdown-header">Dropdown Header</li>',
                        ['label' => 'coś tam ...', 'url' => ['#']]
                    ],
                    'visible' => !(Yii::$app->user->isGuest) //zalogowany


                    //'url' => ['/user/settings/account']

                ],
                Yii::$app->user->isGuest ?
                    ['label' => 'Sign in', 'url' => ['/user/security/login']] :
                    ['label' => 'Sign out (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/user/security/logout'],
                        'linkOptions' => ['data-method' => 'post']],

                ['label' => 'Register',
                    'items' => [
                        ['label' => 'jako pacjent', 'url' => ['/user/registration/register']],
                        '<li class="divider"></li>',
                        //'<li class="dropdown-header">Dropdown Header</li>',
                        ['label' => 'jako lekarz', 'url' => ['/user/registration/register-doctor']],
                    ],
                    'visible' => Yii::$app->user->isGuest
                ]


                // ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest]
            ],
        ]);

    }

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
