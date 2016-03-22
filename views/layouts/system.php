<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Collapse;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use app\components\AlertWidget;

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
      <div class="wrap">
         <?php
         $this->beginBody();
         NavBar::begin([
             'brandLabel' => 'TisBOX', //<img src="'.\Yii::$app->request->BaseUrl.'/img/logo.png"/>
             'brandUrl' => Yii::$app->homeUrl,
             'renderInnerContainer' => FALSE, //На всю ширину экрана
             'options' => [
                 'class' => 'navbar-inverse navbar-fixed-top',
             ],
         ]);
         echo Nav::widget([
             'options' => ['class' => 'navbar-nav navbar-right', 'style' => 'padding-right: 40px'],
             'items' => [
                 Yii::$app->user->identity->superadmin==1 ? (
                            [
                                'label' => 'Админка',
                                'items' => [
                                    ['label'=>'Test','url' => ['system/test']],
                                    ['label'=>'УСПД','url' => ['system/action']]
                                ]
                            ]
                            ):(''),
                 [
                     'label' => Yii::$app->user->identity->username,
                     'items' => [
                         ['label' => 'Выход', 'url' => ['/user-management/auth/logout']],
                     ],
                 ],
             ],
         ]);
         NavBar::end();
         ?>
         <div class="container-fluid" style="padding-top: 60px">
            <div class="row">
               <div class="sidebar col-md-2">
                  <?php
                  /* Sidebar content */
                  echo Nav::widget(
                          [
                              'encodeLabels' => false, //Отключение экранирования в названииях
                              'options' => ['class' => 'nav-pills nav-stacked'], //
                              'items' => [
                                  [
                                      'label' => '<span class="glyphicon glyphicon-tasks"></span> &nbsp; Данные',
                                      'url' => ['#']
                                  ],
                                  [
                                      'label' => '<span class="glyphicon glyphicon-print"></span> &nbsp; Отчеты',
                                      'url' => ['#']
                                  ],
                                  [
                                      'label' => '<span class="glyphicon glyphicon-import"></span> &nbsp; Импорт',
                                      'url' => ['system/import']
                                  ],
                                  [
                                      'label' => '<span class="glyphicon glyphicon-export"></span> &nbsp; Экспорт',
                                      'url' => ['system/export']
                                  ],
                                  [
                                      'label' => '<span class="glyphicon glyphicon-wrench"></span> &nbsp; Настройки',
                                      'url' => ['#']
                                  ],
                              ]
                          ]
                  );
                  //Строка поиска
                  ActiveForm::begin(
                          [
                              'action' => ['system/search'],
                              'method' => 'post',
                              'options' => [
                                  'class' => 'navbar-form'
                              ]
                          ]
                  );
                  ?>
                  <div class="input-group">
                     <?php
                     echo Html::input(
                             'type: text', 'search', '', [
                         'placeholder' => 'Найти объект ...',
                         'class' => 'form-control'
                             ]
                     );
                     ?>
                     <span class="input-group-btn">                                                                
                        <?php
                        echo Html::submitButton(
                                '<span class="glyphicon glyphicon-search"></span>', [
                            'class' => 'btn btn-success',                                    
                                ]
                        );
                        ?>
                     </span>
                  </div>                        
                  <?php
                  ActiveForm::end();

                  //Панель объектов
                  echo Collapse::widget([
                      'items' => [
                          [
                              'label' => 'Объекты',
                              'content' => 'Объект №1',
                              // Открыто по-умолчанию
                              'contentOptions' => [
                                  'class' => 'in'
                              ]
                          ],
                      ]
                  ]);
                  ?>
               </div>
               <?php /* End Sidebar content */ ?>
               <div class="col-md-10">
                  <?php
                  /* Body content */
                  Breadcrumbs::widget([
                      'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                  ])
                  ?>
                  <?= AlertWidget::widget() //Выводит флеш сообщение ?>
                  <?=
                  $content
                  /* END Body content */
                  ?>
               </div>
            </div>
         </div>            
      </div>       
      <footer class="footer"><?php /* класс footer - занимает всю ширину окна, но в отлиичии
                   * от wrap, находится всегда внизу */ ?>
         <div class="container"><?php /* класс container, позволяет делить футер на колонки */ ?>                
            <p class="pull-left">&copy; TisBOX</p>                
         </div>
      </footer>
      <?php $this->endBody() ?>
   </body>
</html>
<?php $this->endPage() ?>
