<?php

namespace app\controllers;

use Yii;


class SystemController extends \yii\web\Controller {

    public $layout = 'system'; //Шаблон для этого контроллера выбран system.php
    
    public function behaviors() {
        return [
            'ghost-access' => [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }
    
    public function actionImport($message=NULL) {                     
        return $this->render('import', [                        
            'time' => date('H:i:s'),
            'message' => $message,
            ]);
        
    }

     public function actionExport() {
        return $this->render('export');
    }
    
    public function actionSearch() {
        $search = Yii::$app->request->post('search');
        
        return $this->render(
            'search',
            [
                'search' => $search
            ]
        );
            
    }
}
