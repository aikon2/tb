<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\system;

use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\ErrorException;

class Vagon extends Model {

   const USD_ADR = 'http://10.24.2.188';
   public $name = 'Hello';

   public function getVersion() {
      $pagein = self::USD_ADR . Url::to(['/crq', 'req' => 'version']);
      if ($back = $this->getCurlOut($pagein)) {
         $back = explode(' ', $back, 3);
         return $back[0] . '.' . $back[1];
      }
      return FALSE;
   }

   public function getTime() {
      $pagein = self::USD_ADR . Url::to(['/crq', 'req' => 'gettime']);
      if ($back = $this->getCurlOut($pagein)) {
         $back = str_replace("\r\n", "", $back);
         return $back;
      }
      return FALSE;
   }

   public function getArchive($n1, $n2, $t1, $t2) {
      $pagein = self::USD_ADR . '/crq?req=archive'
              .'&type=b'
              .'&n1='.$n1
              .'&n2='.$n2
              .'&t1='.$t1
              .'&t2='.$t2;
      //$pagein = self::USD_ADR . Url::to(['/crq', 'req' => 'archive',
          //'type' => 'b', 'n1' => $n1, 'n2' => $n2, 't1' => $t1, 't2' => $t2]);      
      //return $pagein;
      if ($back = $this->getCurlOut($pagein)) {
         return $this->parseData($back);
      }
      return FALSE;
   }   
  
   
   
   public function getTotal($n1, $n2,$t1, $t2, $interval) {
      $pagein = self::USD_ADR . Url::to(['/crq', 'req' => 'total', 
          'type' => 'b', 'n1' => $n1, 'n2' => $n2, 't1' => $t1, 't2' => $t2, 
          'interval'=>$interval]);      
      //return $pagein;
      if ($back = $this->getCurlOut($pagein)) {
         return $this->parseData($back);
      }
      return FALSE;
   }
   
   public function getEvents($n1, $n2,$t1, $t2) {
      $pagein = self::USD_ADR . Url::to(['/crq', 'req' => 'events', 
          'type' => 'j', 'n1' => $n1, 'n2' => $n2, 't1' => $t1, 't2' => $t2]);      
      //return $pagein;
      if ($back = $this->getCurlOut($pagein)) {
         return $this->parseEvents($back);
      }
      return FALSE;
   }

   public function getCurlOut($param, $user = null, $pass = null) {
      try {
         $ch = curl_init(); // create cURL handle (ch)
         if (!$ch) {
            die("Couldn't initialize a cURL handle");
         }// set some cURL options
         $ret = curl_setopt($ch, CURLOPT_URL, $param);
         $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         $ret = curl_setopt($ch, CURLOPT_TIMEOUT, 20); //Таймаут на выполнение
         if (!empty($user) or ! empty($pass)) {
            $ret = curl_setopt($ch, CURLOPT_USERPWD, $user . ':' . $pass);
         }// execute
         $ret = curl_exec($ch);
         $info = curl_getinfo($ch);
         curl_close($ch); // close cURL handler
         if (empty($info['http_code'])) {
            return FALSE; //Нет HTTP кода заголовка
         } else {
            if ($info['http_code'] == 401) {
               return FALSE; //401 Доступ запрещен. Проверте настройки доступа
            } else {
               return Html::encode(iconv('windows-1251', 'utf-8', $ret));
            }
         }
      } catch (ErrorException $e) {
         Yii::warning($e);
         return FALSE; //в запросе
      }
   }
   
   public function parseData ($in) {      
         $back = str_replace(["B","w"], "", str_replace("\r\n", "|", $in));         
         $mass = explode('|', $back);
         if (count($mass) > 2) {
            $back=NULL;
            for ($i = 0; $i < count($mass) - 2; $i++) { //Не берем 1 и последнюю строки
               list($back[$i]['ShortChanName'], 
                       $time, 
                       $back[$i]['Value'], 
                       $back[$i]['State']) = explode(', ', $mass[$i + 1]);
               $t1=explode(' ',$time,2);
               $t2=explode('-', $t1[0]);
               $back[$i]['Time']=$t2[2].'-'.$t2[1].'-'.$t2[0].' '.$t1[1];
            }
            return $back;
         }
         return FALSE;
   }
   
   public function parseEvents ($in) {      
         $back = str_replace("\r\n", "|", $in);
         $mass = explode('|', $back);
         if (count($mass) > 2) {
            $back=NULL;
            for ($i = 0; $i < count($mass) - 2; $i++) { //Не берем 1 и последнюю строки
               list($back[$i]['ShortChanName'], $back[$i]['Time'], $back[$i]['Value'],
                       $back[$i]['Ipar'], $back[$i]['Fpar'], 
                       $back[$i]['Comment'])  = explode(', ', $mass[$i + 1]);               
            }
            return $back;
         }
         return FALSE;
   }

}
