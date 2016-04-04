<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use webvimark\modules\UserManagement\components\GhostNav;
use webvimark\modules\UserManagement\UserManagementModule;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
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
                'brandLabel' => 'TisBOX',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    
                    ['label' => 'Главная', 'url' => ['/site/index']],
                    ['label' => 'О Системе', 'url' => ['/site/about']],
                    ['label' => 'Обратная связь', 'url' => ['/site/contact']],
                    ['label' => 'Форум', 'url' => ['/forum']],
                    // Если гость в меню только вход
                    Yii::$app->user->isGuest ? (
                            ['label' => 'Вход', 'url' => ['/user-management/auth/login']]
                            ) : (
                            // Если нет, то показываем доступные права
                            GhostNav::widget([
                                'options' => ['class' => 'navbar-nav navbar-right'],
                                'encodeLabels' => false,
                                'activateParents' => true,
                                'items' => [
                                    [
                                        'label' => 'Администратор',
                                        'items' => UserManagementModule::menuItems()
                                    ],
                                    [
                                        'label' => Yii::$app->user->identity->username,
                                        'items' => [
                                            ['label' => 'Регистрация', 'url' => ['/user-management/auth/registration']],
                                            ['label' => 'Изменить пароль', 'url' => ['/user-management/auth/change-own-password']],
                                            ['label' => 'Востановить пароль', 'url' => ['/user-management/auth/password-recovery']],
                                            ['label' => 'Подтвердить E-mail', 'url' => ['/user-management/auth/confirm-email']],
                                            ['label' => 'Выход', 'url' => ['/user-management/auth/logout']],
                                        ],
                                    ],
                                ],
                            ])
                            )
                
                ],
            ]);




            NavBar::end();
            ?>

            <div class="container">
<?=
Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; TisBOX</p>               
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
