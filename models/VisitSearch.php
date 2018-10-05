<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visit;

/**
 * VisitSearch represents the model behind the search form about `app\models\Visit`.
 */
class VisitSearch extends Visit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'calendar_id', 'user_id', 'doctor_id', 'service_id'], 'integer'],
            [['patient_name', 'patient_last_name', 'phone', 'date', 'time', 'token', 'status'], 'safe'],
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
        $query = Visit::find();

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
            'calendar_id' => $this->calendar_id,
            'user_id' => $this->user_id,
            'doctor_id' => $this->doctor_id,
            'service_id' => $this->service_id,
            'date' => $this->date,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['like', 'patient_name', $this->patient_name])
            ->andFilterWhere(['like', 'patient_last_name', $this->patient_last_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
