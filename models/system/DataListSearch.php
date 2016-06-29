<?php

namespace app\models\system;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\system\DataList;

/**
 * DataListSearch represents the model behind the search form about `app\models\system\DataList`.
 */
class DataListSearch extends DataList {

   public $deviceName;
   public $dataRef;
   public $typeDataRef;

   /**
    * @inheritdoc
    */
   public function rules() {
      return [
          [['id', 'id_device', 'id_data_ref', 'number', 'work_data'], 'integer'],
          [['time_point'], 'safe'],
          [['deviceName', 'dataRef','typeDataRef'], 'safe'],
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
   public function search($params) {
      $query = DataList::find();

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
              'id_device',
              'deviceName' => [
                  'asc' => ['device.name_device' => SORT_ASC],
                  'desc' => ['device.name_device' => SORT_DESC],
                  'label' => 'Прибор'
              ],
              'dataRef' => [
                  'asc' => ['data_ref.name_ref' => SORT_ASC],
                  'desc' => ['data_ref.name_ref' => SORT_DESC],
                  //'label' => 'Тип'
              ],
          'number',
          'time_point',
          'work_data',         
          'typeDataRef'=> [
                  'asc' => ['data_ref.type_data_ref' => SORT_ASC],
                  'desc' => ['data_ref.type_data_ref' => SORT_DESC],
                  //'label' => 'Тип'
              ],
      ]]);

      if (!($this->load($params) && $this->validate())) {
         /**
          * Жадная загрузка данных типа приборов
          * для работы сортировки.
          */
         $query->joinWith(['idDevice']);
         $query->joinWith(['idDataRef']);
         return $dataProvider;
      }

      // grid filtering conditions
      $query->andFilterWhere([
          'data_list.id' => $this->id,
          'id_device' => $this->id_device,
          'id_data_ref' => $this->id_data_ref,
          'number' => $this->number,
          'time_point' => $this->time_point,
          'work_data' => $this->work_data,          
      ]);

      // Фильтр по типу прибора
      $query->joinWith(['idDevice' => function ($q) {
             $q->andFilterWhere(['like', 'device.name_device', $this->deviceName]);
          }]);
      // Фильтр по типу данных
      $query->joinWith(['idDataRef' => function ($q) {
             $q->andFilterWhere(['like', 'data_ref.name_ref', $this->dataRef]);
             $q->andFilterWhere(['like', 'data_ref.type_data_ref', $this->typeDataRef]);             
          }]);

              return $dataProvider;
           }

        }
        