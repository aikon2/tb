<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $model app\models\ContactForm */


use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\widgets\Pjax;
use yii\helpers\BaseHtml;

$this->title = 'Импорт | Визуальная система измерений';
?>
<div class="row ramka">
    <div class="col-md-3 vcenter ramka">
        <?php
        Pjax::begin();
        echo ButtonDropdown::widget([
            'label' => 'Выбрать действие',
            'options' => [
                'class' => 'btn-lg btn-primary',
                'style' => 'margin:5px'
            ],
            'dropdown' => [
                'items' => [
                    [
                        'label' => 'Получить версию ПО',
                        'url' => 'import&message=hello'
                    ],
                    [
                        'label' => 'Третье действие',
                        'url' => '#'
                    ],
                    [
                        'label' => '',
                        'options' => [
                            'role' => 'presentation',
                            'class' => 'divider'
                        ]
                    ],
                    [
                        'label' => 'Четвертое действие',
                        'url' => '#'
                    ]
                ]
            ]
        ]);
        
        echo Html::input('text','string',$message,['class'=> 'form-control']);
        
        ?>
        
        
        <h1>Сейчас: <?= $time ?></h1>
        <?php Pjax::end(); ?>
        
    </div>  

    <div class="col-md-2 vcenter">        
        
    </div>               

</div>

<div class="row">  

    <div class="col-md-3 vcenter">

    </div>

</div>

<div class="row">        



    <p></p>
    <p>188</p>
    <pre>
        <?php
        $page = file_get_contents('http://10.24.2.188/crq?req=dev_info');

        echo Html::encode(iconv('windows-1251', 'utf-8', $page));
        ?>
    </pre>

    <hr class="featurette-divider">
    <p>202</p>
    <pre>
        <?php
        $page = file_get_contents('http://10.24.2.202/crq?req=dev_info');

        echo Html::encode(iconv('windows-1251', 'utf-8', $page));
        ?>
    </pre>
</div>