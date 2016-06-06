<?php

namespace app\models\system;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\system\Device;

/**
 * DeviceSearch represents the model behind the search form about `app\models\system\Device`.
 */
class DeviceSearch extends Device {
   /* вычисляемый атрибут */

   public $typeDeviceName;
   public $usdName;

   /**
    * @inheritdoc
    */
   public function rules() {
      return [
          [['id', 'id_type_device', 'id_usd', 'work_device'], 'integer'],
          [['name_device', 'serial'], 'safe'],
          [['typeDeviceName', 'usdName'], 'safe'] //правила вычисляемого атрибута
      ];
   }

   /**
    * @inheritdoc
    */
   public function scenarios() {
      // bypass scenarios() implementation in the parent class
      return Model::scenarios();
   }

   /**
    * Creates data provider instance with search query applied
    *
    * @param array $params
    *
    * @return ActiveDataProvider
    */
   //Настроим поиск для использования поля typeDeviceName
   public function search($params) {
      $query = Device::find();

      // add conditions that should always apply here

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
      ]);

      /**
       * Настройка параметров сортировки
       * Важно: должна быть выполнена раньше $this->load($params)
       * statement below
       */
      $dataProvider->setSort([
          'attributes' => [
              'id',
              'typeDeviceName' => [
                  'asc' => ['type_device.name_type' => SORT_ASC],
                  'desc' => ['type_device.name_type' => SORT_DESC],
                  'label' => 'Тип прибора'
              ],
              'name_device',
              'serial',
              'usdName' => [
                  'asc' => ['usd.name_usd' => SORT_ASC],
                  'desc' => ['usd.name_usd' => SORT_DESC],
                  'label' => 'Сборщик'
              ],
          ]
      ]);

      if (!($this->load($params) && $this->validate())) {
         /**
          * Жадная загрузка данных типа приборов
          * для работы сортировки.
          */
         $query->joinWith(['idTypeDevice']);
         $query->joinWith(['idUsd']);
         return $dataProvider;
      }

      // grid filtering conditions
      $query->andFilterWhere([
          'device.id' => $this->id,
          'id_type_device' => $this->id_type_device,
          'id_usd' => $this->id_usd,
          'work_device' => $this->work_device,
      ]);
      $query->andFilterWhere(['like', 'name_device', $this->name_device])
              ->andFilterWhere(['like', 'serial', $this->serial]);

      // Фильтр по сборщику
      $query->joinWith(['idUsd' => function ($q) {
             $q->andFilterWhere(['like', 'usd.name_usd', $this->usdName]);
          }]);

              // Фильтр по типу прибора
              $query->joinWith(['idTypeDevice' => function ($q) {
                     $q->andFilterWhere(['like', 'type_device.name_type', $this->typeDeviceName]);
                  }]);


                      return $dataProvider;
                   }

                }
                