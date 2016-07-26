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
      if ($id != NULL) {
         var_export((new Start)->getDataList($id));
      } else {
         echo "id not set!";
      }
   }

   /**
    * @param string $id -> id_usd.
    */
   public function actionUsd($id = NULL) {
      var_export((new Start)->getUsd($id));
   }

   /**
    * @param string $id -> id_usd.
    */
   public function actionDevice($id = NULL) {
      if ($id != NULL) {
         var_export((new Start)->getDevice($id));
      } else {
         echo "id not set!";
      }
   }

   public function actionArch() {
      echo "Start " . $this->udate('Y-m-d H:i:s.u T') . "\n";
      if ((new Start)->Arch()) {
         echo "End ok " . $this->udate('Y-m-d H:i:s.u T');
      } else {         
         echo "End with error " . $this->udate('Y-m-d H:i:s.u T');
      }
   }

   public function actionTest($id=0) {
      //echo "Start " . $this->udate('Y-m-d H:i:s.u T') . "\n";
      //(new Start)->test();      
      //echo "End " . $this->udate('Y-m-d H:i:s.u T');      
      //$vr=[];
      
      if ($id>0){
         echo "bolshe";
      }  else {
         echo "net";
      }
   }
   
   private function udate($format = 'u', $utimestamp = null) {
        if (is_null($utimestamp))
            $utimestamp = microtime(true);

        $timestamp = floor($utimestamp);
        $milliseconds = round(($utimestamp - $timestamp) * 1000000);

        return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
    }

}
