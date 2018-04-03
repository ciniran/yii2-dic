<?php

namespace ciniran\dic\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ciniran\dic\models\SystemDic;

/**
 * SystemDicQuery represents the model behind the search form about `dic\models\DicTools`.
 */
class SystemDicQuery extends SystemDic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid','status'], 'integer'],
            [['name', 'value'], 'safe'],
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
        $query = SystemDic::find()->orderBy('sort DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pid' => $this->pid,
            'status' => $this->status,

        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }



}
