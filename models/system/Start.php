<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\system;

use yii\base\Model;
use yii\helpers\Url;
use DateTime;

class Start extends Model {
   /*
    * Получаем массив работающих приборов по id сборщика
    */

   public function getDevice($id) {
      try {
         //Получаем весь массив данных из таблицы
         $q = Device::find()
                 ->select(['id'])
                 //Получаем массив данных по полученному id_usd
                 ->where(['id_usd' => $id, 'work_device' => '1'])
                 ->createCommand()
                 ->queryAll();
      } catch (\Exception $e) {
         echo "Something went wrong of get Device\n";
         throw $e;
         return FALSE;
      }
      return $q;
   }

   /*
    * Получаем массив сборщиков (либо конкретного по id сборщика)
    */

   public function getUsd($id) {
      try {
         //Получаем весь массив данных из таблицы
         $q = Usd::find()
                 ->select(['id', 'dns_name', 'login', 'pass'])
                 ->where($id === NULL ?
                                 //Получаем весь массив данных из таблицы
                                 ['work_usd' => '1'] :
                                 //Получаем массив данных из таблицы по полученному id_device
                                 ['id' => $id, 'work_usd' => '1'])
                 ->createCommand()
                 ->queryAll();
      } catch (\Exception $e) {
         echo "Something went wrong of get Device\n";
         throw $e;
         return FALSE;
      }
      return $q;
   }

   /*
    * Получаем массив работающих b каналов по id прибора
    */

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

   /*
    * Получение и запись всех данных по всем приборам со всех сборщиков
    */

   public function Arch() {
      $model = new Vagon();
      //Получаем все Сборщики
      $musd = $this->getUsd(NULL);
      //var_export($musd);
      if (count($musd) > 0) {
         foreach ($musd as $vusd) {
            //Получаем Приборы по каждому Сборщику
            $mdevice = $this->getDevice($vusd['id']);
            //var_export($mdevice);
            if (count($mdevice) > 0) {
               foreach ($mdevice as $vdevice) {
                  //Получаем Каналы по каждому Прибору
                  $mchan = $this->getDataList($vdevice['id']);
                  //echo ". Value of USD=" . $vusd['id'] . " , and Device=" . $vdevice['id'] . "\n";
                  //var_export($mchan);
                  if (count($mchan) > 0) {
                     foreach ($mchan as $vchan) {
                        //Сформируем crq запрос
                        $adr = $vusd['dns_name'] . Url::to(['/crq', 'req' => 'archive',
                                    'type' => 'b', 'n1' => $vchan['number'], 'n2' => $vchan['number'],
                                    't1' => date('YmdHis', strtotime($vchan['time_point'])),
                                    't2' => date('YmdHis')]);
                        //Отправим запрос
                        if ($backCurl = $model->getCurlOut($adr, $vusd['login'], $vusd['pass'])) {
                           if (!$parse = $model->parseData($backCurl)) {
                              continue;
                           }
                        }
                        echo ". Value of USD=" . $vusd['id']
                        . ", and Device=" . $vdevice['id']
                        . ", and Chan=" . $vchan['id']
                        . " get " . count($parse) . " values\n";
                        //Полученные значения сохраняем
                        $back_time = $this->SaveMass($parse, $vchan['id']);
                        //echo "Back-time: ".$back_time."\n";
                        if (($back_time != NULL) and ( $back_time != FALSE)) {
                           //Успешно вернулись с сохранения, передвинем time_point по последнему значению                          
                           
                           $this->MovePoint($vchan['id'], $back_time);
                        }
                     }
                  }
               }
            }
         }
      } else {
         echo "Get array of NULL";
      }
      return TRUE;
   }

   /*
    * Сохраняет полученный массив данных в BlockInterval
    */

   private function SaveMass($mass = NULL, $list) {

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
            $transaction->commit();
            if (($ok) and ( $sin > 0)) {
               echo "..Save/Update of " . strval($sin) . " elements\n";
            }
            if ($ok) {
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

   private function MovePoint($id, $new_time) {
      try {
         $modelsave = DataList::find()->where(['id' => $id])->one();
         if ($modelsave->time_point != $new_time) {
            //Текущее значение не равно новому
            $old_time = $modelsave->time_point;
            //Посчитаем сколько получасовок должно быть
            $per = date_diff(new DateTime($new_time), new DateTime($old_time));
            $out = floor(($per->h * 2) + ($per->format('%a') * 24 * 2) + ($per->i / 30));
            //Посчитаем сколько значений в базе в этот периуд
            $count = BlockInterval::find()
                    ->where(['id_data_list' => '6'])
                    ->andFilterCompare('time_interval', ">$old_time")
                    ->andFilterCompare('time_interval', "<=$new_time")
                    ->count();
            if ($out != $count) {
               //Если не равно, значит есть дырка, ей нужно проставить статус
               for ($i = 1; $i <= $out; $i++) {
                  try {
                     $times = date('Y-m-d H:i:s', strtotime($old_time) + 1800 * $i);
                     if (!$model = BlockInterval::find()->where(
                                     ['id_data_list' => $id,
                                         'time_interval' => $times])->one()) {
                        $model = new BlockInterval();
                        $model->id_data_list = $id;
                        $model->time_interval = $times;
                        $model->value = '0';
                        $model->status = '-1';
                        if (!$model->save()) {                           
                           echo "Of move point something went wrong at " . strval($times) . " element\n";
                           $ok = FALSE;
                           break;
                        }
                     }
                  } catch (\Exception $e) {
                     echo "Of move point something went wrong at " . strval($i) . " element\n";
                     throw $e;
                     return FALSE;
                  }
               }
            }

            $modelsave->time_point = $new_time;
            if (!$modelsave->save()) {
               echo "Something went wrong move time point:" . $new_time . ".\n";
               return FALSE;
            }
            echo "...Time point for " . $id . " move in last value: " . $new_time . "\n";
         }
      } catch (\Exception $e) {
         echo "Error! Something went wrong after save\n";
         throw $e;
      }
   }

   public function test() {

      $t1 = '2015-12-17 00:00:00';
      $t2 = '2015-12-17 02:00:00';
      //$t2 = date('Y-m-d H:i:s',  strtotime($t1)+1800);

      $per = date_diff(new DateTime($t2), new DateTime($t1));
      $out = floor(($per->h * 2) + ($per->format('%a') * 24 * 2) + ($per->i / 30));

      $count = BlockInterval::find()
              ->where(['id_data_list' => '6'])
              ->andFilterCompare('time_interval', ">$t1")
              ->andFilterCompare('time_interval', "<=$t2")
              ->count();

      echo var_dump($out);
      echo var_dump($count);

      for ($i = 1; $i <= $out; $i++) {
         $times = date('Y-m-d H:i:s', strtotime($t1) + 1800 * $i);
         echo $times . "\n";
      }
   }

}
