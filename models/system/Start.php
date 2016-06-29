<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\system;

use yii\base\Model;
use app\models\system\DataList;
use app\models\system\Vagon;
use app\models\system\BlockInterval;

class Start extends Model {

   public function getDataList($id = NULL) {
      //Получаем весь массив данных из таблицы
      $q = DataList::find()
              ->select(['data_list.id', 'number', 'time_point'])
              ->joinWith('idDataRef')
              ->where($id === NULL ?
                              //Получаем весь массив данных из таблицы
                              ['type_data_ref' => 'b', 'work_data' => '1'] :
                              //Получаем массив данных из таблицы по полученному id_device
                              ['id_device' => $id, 'type_data_ref' => 'b', 'work_data' => '1'])
              ->createCommand()
              ->queryAll();
      //var_export($q);
      return $q;
   }

   public function getArchive($id = NULL) {
      $mass = $this->getDataList($id);
      echo "I get an array of " . count($mass) . " element\n";
      $model = new Vagon();
      if (count($mass) > 0) {
         foreach ($mass as $v) {
            echo "\nRequesting the element [id]-[number]: [" . $v['id'] . "]-[" . $v['number'] . "]\n";
            //Получаем массив архивных значений по указанному каналу
            $message = $model->getArchive($v['number'], $v['number'], date('YmdHis', strtotime($v['time_point'])), date('YmdHis'));
            if ($message) {
               echo ".As this element get of " . count($message) . " values\n";
               //var_dump($message);
               //Записываем в базу массив значений
               $back = $this->Save($message, $v['id']);

               if (($back != NULL)and ( $back != FALSE)) {
                  //Успешно вернулись с сохранения, передвинем time_point по последнему значению
                  try {
                     $modelsave = DataList::find()->where(['id' => $v['id']])->one();
                     if ($modelsave->time_point != $back) {
                        $modelsave->time_point = $back;
                        if (!$modelsave->save()) {
                           echo "Something went wrong after save\n";
                           return FALSE;
                        }
                        echo "...Time point move in last value\n";
                     }
                  } catch (\Exception $e) {
                     echo "Something went wrong after save\n";
                     throw $e;
                     return FALSE;
                  }
                  //return $back;
                  //return $message;
               }
            } else {
               echo "This element no values\n";
            }
         }
      }
      return "Ok\n";
   }

   function Save($mass = NULL, $list) {

      if (count($mass) > 0) {
         //Запишем данные                     
         $transaction = BlockInterval::getDb()->beginTransaction();
         try {
            $sin = 0;
            $ok = TRUE;
            foreach ($mass as $value) {
               //Проверим на $80 статусы (отсутствие значений)
               if ($value['State'] === '128') {
                  continue;
               }
               if (!$modelsave = BlockInterval::find()->where(
                               ['id_data_list' => $list,
                                   'time_interval' => $value["Time"]])->one()) {
                  $modelsave = new BlockInterval();
               } else {
                  if (($modelsave->value == $value['Value'])and ( $modelsave->status == $value['State'])) {
                     continue;
                  }
               }
               $modelsave->id_data_list = $list;
               $modelsave->time_interval = $value['Time'];
               $modelsave->value = $value['Value'];
               $modelsave->status = $value['State'];
               if (!$modelsave->save()) {
                  $transaction->rollBack();
                  echo "Something went wrong at " . strval($sin + 1) . " element\n";
                  $ok = FALSE;
                  break;
               }
               $sin+=1;
            }
            if ($ok) {
               $transaction->commit();
               echo "..Save " . strval($sin) . " elements\n";
               return $value['Time'];
            }
         } catch (\Exception $e) {
            $transaction->rollBack();
            echo "Something went wrong at " . strval($sin + 1) . " element\n";
            throw $e;
            return FALSE;
         }
      }
      return NULL;
   }

}
