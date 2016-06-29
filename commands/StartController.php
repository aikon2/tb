<?php

namespace app\commands;

use yii\console\Controller;
use app\models\system\Start;

/**
 * These commands allow you to get the required settings from the database.  * 
 */
class StartController extends Controller {

   public function actionIndex() {
      echo "Command: \n";
      echo "1. data-list[id_device]\n";
      echo "2. archive[id_device]\n";
   }

   /**    
    * @param string $id -> id_device.
    */
   public function actionDataList($id = NULL) {
      
      var_export((new Start)->getDataList($id));
      
   }

   public function actionArchive($id = NULL) {
      
      var_export((new Start)->getArchive($id));
   }   
  
   
}
