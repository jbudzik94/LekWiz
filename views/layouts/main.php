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
    <style>
        a.navbar-brand {
            padding: 5px;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" style="background-image: url(shattered.png);">
    <?php
    NavBar::begin([
        // 'brandLabel' => 'My Company',
        //  'brandLabel' => Html::img('medicine.png', [ 'style' => 'width: 40px; height: 40px; padding: 0px; display:inline; ',  'class' => 'd-inline-block align-top', 'alt'=>Yii::$app->name])."<p>LekWiz<p>",
        'brandLabel' => '<img src="medical.png" width="40" height="40" class="d-inline-block align-top" alt="" style=" display:inline; "> <span style="color: #777777; ">LekWiz</span>',

        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
            'style' => 'background-color: #fff; border: #3fa1d6; color: white; opacity: 50%;'
        ],
    ]);


    if (!Yii::$app->user->isGuest) {
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
                    //['label' => 'Strona główna', 'url' => ['/site/index']],
                    //['label' => 'About', 'url' => ['/site/about']],
                    //['label' => 'Contact', 'url' => ['/site/contact']],
                    ['label' => 'Mój profil', 'url' => ['/user/settings/account']

                        /* 'items' => [


                             ['label' => 'settings', 'url' => ['/user/settings/account']],
                             '<li class="divider"></li>',
                             //'<li class="dropdown-header">Dropdown Header</li>',
                             ['label' => 'blabla.', 'url' => ['#']]
                         ],
                         'visible' => !(Yii::$app->user->isGuest)


                         //'url' => ['/user/settings/account']
 */
                    ],
                    ['label' => 'Gabinety i usługi', 'url' => ['/user/settings/offices']],
                    ['label' => 'Kalendarz', 'url' => ['/calendar/show-schedule']],
                    ['label' => 'Strefa pacjenta', 'url' => ['/visit/my-visits']],
                    ['label' => 'Wyloguj (' . \app\models\UserDetails::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()->name . ' ' . \app\models\UserDetails::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()->last_name . ' )',
                        'url' => ['/user/security/logout'],
                        'linkOptions' => ['data-method' => 'post']],

                    /*['label' => 'Register',
                        'items' => [
                            ['label' => 'jako pacjent', 'url' => ['/user/registration/register']],
                            '<li class="divider"></li>',
                            //'<li class="dropdown-header">Dropdown Header</li>',
                            ['label' => 'jako lekarz', 'url' => ['/user/registration/register-doctor']],
                        ],

                        'visible' => $arr['item'] == 'admin' ?  true : false
                    ]*/

                    // ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest]
                ],
            ]);

        else  //jest pacjentem
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    //  ['label' => 'Strona główna', 'url' => ['/site/index']],
                    //['label' => 'About', 'url' => ['/site/about']],
                    //['label' => 'Contact', 'url' => ['/site/contact']],
                    ['label' => 'Mój profil', 'url' => ['/user/settings/account-patient']],
                    ['label' => 'Strefa pacjenta', 'url' => ['/visit/my-visits']],
                    //  Yii::$app->user->isGuest ?
                    //    ['label' => 'Sign in', 'url' => ['/user/security/login']] :
                    ['label' => 'Wyloguj ( ' . \app\models\UserDetails::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()->name . ' ' . \app\models\UserDetails::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()->last_name . ' )',
                        'url' => ['/user/security/logout'],
                        'linkOptions' => ['data-method' => 'post']],

                    /**['label' => 'Register',
                     * 'items' => [
                     * ['label' => 'jako pacjent', 'url' => ['/user/registration/register']],
                     * '<li class="divider"></li>',
                     * //'<li class="dropdown-header">Dropdown Header</li>',
                     * ['label' => 'jako lekarz', 'url' => ['/user/registration/register-doctor']],
                     * ],
                     * 'visible' => Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())=='admin' ? true : false;
                     * ]*/


                    // ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest]
                ],
            ]);


    } else {


        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                //  ['label' => 'Strona główna', 'url' => ['/site/index']],
                //['label' => 'About', 'url' => ['/site/about']],
                //['label' => 'Contact', 'url' => ['/site/contact']],

                ['label' => 'Zaloguj', 'url' => ['/user/security/login']],

                ['label' => 'Zarejestruj się',
                    'items' => [
                        ['label' => 'Jako pacjent', 'url' => ['/user/registration/register']],
                        '<li class="divider"></li>',
                        //'<li class="dropdown-header">Dropdown Header</li>',
                        ['label' => 'Jako lekarz', 'url' => ['/user/registration/register-doctor']],
                    ]
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

<footer class="footer" style="background-color: white;">
    <div class="container">
        <p class="pull-left"> LekWiz &copy; <?= date('Y') ?> - Znajdź lekarza i umów wizytę</p>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
