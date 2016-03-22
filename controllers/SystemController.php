<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\ActionForm;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;

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
   
   

   public function actionTest($message = NULL) {
      if ($message):
         return $this->render('test', [
                     'message' => $message,
         ]);
      else:
         return $this->render('test', [
                     'message' => 'Пустое значение',
         ]);

      endif;
   }

   public function actionImport() {
      return $this->render('import');
   }
   
   public function actionExport() {
      return $this->render('export');
   }

   public function actionSearch() {
      $search = Yii::$app->request->post('search');

      if ($search):
         Yii::$app->session->setFlash(
                 'success', 'Результат поиска'
         );
      else:
         Yii::$app->session->setFlash(
                 'error', 'Пустой запрос поиска'
         );
      endif;

      return $this->render(
                      'search', [
                  'search' => $search
                      ]
      );
   }

   public function actionAction() {

      \Yii::trace('### ### ### Тест лога');

      $ids = Yii::$app->request->post('ActionForm');
      $page = Yii::$app->request->post('adr');

      if ($ids) {
         //Если выбран ID         
         $model = $this->findModel($ids);
         return $this->render('action', [
                     'model' => $model,
                     'ghide' => 1,
                     'gadr' => '10.24.2.202',
                     'guser'=>'',
                     'gpass'=>'',
                     'gcommand' => $model->actionstring,
                     'gparams' => $model->params,
                     'pagein' => '',
                     'pageout' => '',
         ]);
      } elseif ($page) {
         //Если отправлен запрос         
         $pagein = 'http://' . Yii::$app->request->post('adr') . '/crq?req=' . Yii::$app->request->post('string').'&'. Yii::$app->request->post('params');
         $user=Yii::$app->request->post('user');
         $pass=Yii::$app->request->post('pass');
         return $this->render('action', [
                     'model' => new ActionForm(),
                     'ghide' => 2,
                     'gadr' => Yii::$app->request->post('adr'),
                     'guser'=>$user,
                     'gpass'=>$pass,
                     'gcommand' => Yii::$app->request->post('string'),
                     'gparams' => Yii::$app->request->post('params'),
                     'pagein' => $pagein,
                     'pageout' => $this->getCurlOut($pagein,$user,$pass),
         ]);
      } else {
         //Если форму только открыли         
         return $this->render('action', [
                     'model' => new ActionForm(),
                     'ghide' => 0,
                     'gadr' => '',
                     'guser'=>'',
                     'gpass'=>'',
                     'gcommand' => '',
                     'gparams' => '',
                     'pagein' => '',
                     'pageout' => '',
         ]);
      }
   }

   protected function findModel($id) {
      if (($model = ActionForm::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }
 
   protected function getCurlOut($param,$user,$pass) {
      try {
         $ch = curl_init(); // create cURL handle (ch)
         if (!$ch) {
            die("Couldn't initialize a cURL handle");
         }
// set some cURL options
         $ret = curl_setopt($ch, CURLOPT_URL, $param);

         $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         //$ret = curl_setopt($ch, CURLOPT_TIMEOUT, 20); //Таймаут на выполнение
         if (!empty($user) or !empty($pass)){
         $ret = curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
         }
         
// execute
         $ret = curl_exec($ch);

         $info = curl_getinfo($ch);
         curl_close($ch); // close cURL handler

         if (empty($info['http_code'])) {
            return 'ОШИБКА: Нет HTTP кода заголовка';
         } else {
            if ($info['http_code'] == 401) {
               return 'ОШИБКА: 401 Доступ запрещен. Проверте настройки доступа';
            } else {
               
               return Html::encode(iconv('windows-1251', 'utf-8',$ret));
            }
         }
      } catch (ErrorException $e) {
         Yii::warning($e);
         return 'ОШИБКА в запросе';
      }
   }  

}
