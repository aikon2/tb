<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\ActionForm;
use yii\web\NotFoundHttpException;
use app\models\system\Vagon;
use app\models\system\Device;
use app\models\system\DataListSearch;
use app\models\system\DataList;

use webvimark\modules\UserManagement\models\User;

class SystemController extends \yii\web\Controller {

   public $layout = 'system'; //Шаблон для этого контроллера выбран system.php

   //Запрет неавторизированного управления

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

   public function actionData() {
      $data = Tree::nparseData();
      return $this->render('data', [
                  'data' => $data,
      ]);
   }

   public function actionImport() {
      return $this->render('import');
   }
   public function actionExport() {
      return $this->render('export');
   }

/*Удалить   
//Только админ
   public function actionTree($c = NULL, $id = 0) {
      if (User::hasRole('admin')) {
         if (!is_null($c)) {
            switch ($c) {
               case 'del':
                  if ($id > 0) {
                     if (($node = Tree::findOne(['id' => $id])) !== null) {
                        $node->deleteWithChildren();
                     }
                  }

                  break;

               default:
                  break;
            }
         }
         return $this->render('tree');
      } else {
         throw new NotFoundHttpException('Страница не найдена.');
      }
   }
 * 
 */

   //Только админ
   public function actionIn() {
      if (User::hasRole('admin')) {
         $model = new Device();
         //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);      
         //\Yii::trace('### ### ### Тест лога');
         //\Yii::trace(Yii::$app->request->post());      
         if ($model->load(Yii::$app->request->post())) {
            //\Yii::trace('### ### ### If');
            //return $this->redirect(['/table/device/view', 'id' => $model->id]);
            $searchModel = new DataListSearch();
            $dataProvider = $searchModel->search(
                    [
                        'DataListSearch' => [
                            'id_device' => $model->id,
                            'typeDataRef' => 'b'
                        ]
            ]);
            //Получаем массив данных из таблицы
            $allq = DataList::find()
                    ->select(['data_list.id', 'number', 'time_point'])
                    ->joinWith('idDataRef')
                    ->where(['id_device' => $model->id, 'type_data_ref' => 'b'])
                    ->createCommand()
                    ->queryAll();
            return $this->render('in', [
                        'model' => $model,
                        'r' => 1,
                        'dataProvider' => $dataProvider,
                        'qwery' => $allq
            ]);
         } else {
            //\Yii::trace('### ### ### Else');
            return $this->render('in', [
                        'model' => $model,
                        'r' => NULL
            ]);
         }
      } else {
         throw new NotFoundHttpException('Страница не найдена.');
      }
   }

   //Только админ
   public function actionTest($message = NULL) {
      if (User::hasRole('admin')) {
         if ($message):
            return $this->render('test', [
                        'message' => $message,
            ]);
         else:
            return $this->render('test', [
                        'message' => 'Пустое значение',
            ]);

         endif;
      } else {
         throw new NotFoundHttpException('Страница не найдена.');
      }
   }

   //Только админ
   public function actionOut($c = NULL, $n1 = 1, $n2 = 1, $t1 = null, $t2 = null, $interval = 'day') {
      if (User::hasRole('admin')) {
         $model = new Vagon();
         $message = NULL;

         if ($c) {
            switch ($c) {
               case 'version': {
                     $message = $model->getVersion();
                     break;
                  }
               case 'time': {
                     $message = $model->getTime();
                     break;
                  }
               case 'archive': {
                     $date = date('YmdHis');
                     if (is_null($t1)) {
                        if (is_null($t2))
                           $t1 = $t2 = $date;
                        else
                           $t1 = $t2;
                     }
                     else if (is_null($t2))
                        $t2 = $date;
                     $message = $model->getArchive($n1, $n2, $t1, $t2);
                     break;
                  }
               case 'total': {
                     $date = date('YmdHis');
                     if (is_null($t1)) {
                        if (is_null($t2))
                           $t1 = $t2 = $date;
                        else
                           $t1 = $t2;
                     }
                     else if (is_null($t2))
                        $t2 = $date;
                     $message = $model->getTotal($n1, $n2, $t1, $t2, $interval);
                     break;
                  }
               case 'events': {
                     $date = date('YmdHis');
                     if (is_null($t1)) {
                        if (is_null($t2))
                           $t1 = $t2 = $date;
                        else
                           $t1 = $t2;
                     }
                     else if (is_null($t2))
                        $t2 = $date;
                     $message = $model->getEvents($n1, $n2, $t1, $t2);
                     break;
                  }
               case 'ver': {
                     $message = 'hoooo';
                     break;
                  }
               default: $message = 'Неизвестный запрос';
            }
         }
         return $this->render('out', ['message' => $message]);
      } else {
         throw new NotFoundHttpException('Страница не найдена.');
      }
   }

   //Только админ
   public function actionAction() {

      if (User::hasRole('admin')) {
         //\Yii::trace('### ### ### Тест лога');
         //Проверяем был ли выбрана комманда 
         $ids = Yii::$app->request->post('ActionForm');
         //\Yii::trace(Yii::$app->request->post('ActionForm'));
         //Проверяем, выбран ли пустой id, если да, то как будто только открыли
         if (($ids) and ( ArrayHelper::isIn('', $ids))) {
            $ids = null;
         }
         //Для проверки отправки запроса получаем значение
         $page = Yii::$app->request->post('adr');

         if ($ids) {
            //Если выбран ID         
            $model = $this->findModel($ids);
            return $this->render('action', [
                        'model' => $model,
                        'ghide' => 1,
                        'gadr' => '10.24.2.188',
                        'guser' => '',
                        'gpass' => '',
                        'gid' => $model->id,
                        'gcommand' => $model->actionstring,
                        'gparams' => $model->params,
                        'pagein' => '',
                        'pageout' => '',
            ]);
         } elseif ($page) {
            //Если отправлен запрос        
            $ids = Yii::$app->request->post('id');
            $model = $this->findModel($ids);
            $vagon = new Vagon();
            $pagein = 'http://' . Yii::$app->request->post('adr') . '/crq?req=' . Yii::$app->request->post('string') . '&' . Yii::$app->request->post('params');
            $user = Yii::$app->request->post('user');
            $pass = Yii::$app->request->post('pass');
            return $this->render('action', [
                        'model' => $model,
                        'ghide' => 2,
                        'gadr' => Yii::$app->request->post('adr'),
                        'guser' => $user,
                        'gpass' => $pass,
                        'gid' => $model->id,
                        'gcommand' => Yii::$app->request->post('string'),
                        'gparams' => Yii::$app->request->post('params'),
                        'pagein' => $pagein,
                        'pageout' => $vagon->getCurlOut($pagein, $user, $pass),
            ]);
         } else {
            //Если форму только открыли         
            return $this->render('action', [
                        'model' => new ActionForm(),
                        'ghide' => 0,
                        'gadr' => '',
                        'guser' => '',
                        'gpass' => '',
                        'gid' => '',
                        'gcommand' => '',
                        'gparams' => '',
                        'pagein' => '',
                        'pageout' => '',
            ]);
         }
      } else {
         throw new NotFoundHttpException('Страница не найдена.');
      }
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

   protected function findModel($id) {
      if (($model = ActionForm::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('Запрашиваемая страница не существует.');
      }
   }

}
