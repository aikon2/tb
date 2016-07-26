<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\system\Tree;
use yii\filters\VerbFilter;

class TreeController extends \yii\web\Controller {

   public $layout = 'system'; //Шаблон для этого контроллера выбран system.php

   public function behaviors() {
      return [
          'ghost-access' => [ //Запрет неавторизированного управления
              'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
          ],
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'delete' => ['POST'],
              ],
          ],
      ];
   }   

   public function actionIndex() {
      $id = \yii::$app->request->get('id');      
   if ($id){
      $model=$this->findModel($id);
      $mname=$model->name;
   }  else {
      $mname='';
   }  
      return $this->render('index',[
          'id'=>$id,
          'mname'=>$mname
              ]);
   }

   public function actionEdit() {
      $name = Html::encode(\yii::$app->request->post('name'));
      $id = \yii::$app->request->post('id');
      $model=$this->findModel($id);      
         $model->name=$name;
         if ($model->save()) {
            Yii::$app->session->setFlash('success', "Успешное редактирование");
         } else {
            Yii::$app->session->setFlash('error', "Введено недопустимое значение. Редактирование отменено!");
         }      
      return $this->redirect(['index']);
   }

   public function actionDelete($id) {
      $this->findModel($id)->deleteWithChildren();

      return $this->redirect(['index']);
   }

   public function actionRoot() {
      $name = Html::encode(\yii::$app->request->post('name'));
      if ($name != '') {
         $model = new Tree(['name' => $name]);
         if ($model->makeRoot()) {
            Yii::$app->session->setFlash('success', "Создан новые корень");
         } else {
            Yii::$app->session->setFlash('error', "Введено недопустимое значение. Корень не создан!");
         }
      } else {
         Yii::$app->session->setFlash('error', "Пустое значение. Корень не создан!");
      }

      return $this->redirect(['index']);
   }

   protected function findModel($id) {
      if (($model = Tree::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

}
