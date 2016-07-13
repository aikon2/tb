<?php

namespace app\models\system;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\system\Usd;

/**
 * UsdSearch represents the model behind the search form about `app\models\system\Usd`.
 */
class UsdSearch extends Usd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'work_usd'], 'integer'],
            [['name_usd', 'dns_name', 'login', 'pass'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Usd::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'work_usd' => $this->work_usd,
        ]);

        $query->andFilterWhere(['like', 'name_usd', $this->name_usd])
            ->andFilterWhere(['like', 'dns_name', $this->dns_name])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'pass', $this->pass]);

        return $dataProvider;
    }
}
