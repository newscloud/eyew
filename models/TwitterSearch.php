<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Twitter;

/**
 * TwitterSearch represents the model behind the search form about `app\models\Twitter`.
 */
class TwitterSearch extends Twitter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'moment_id', 'tweet_id', 'twitter_id', 'tweeted_at', 'created_at', 'updated_at'], 'integer'],
            [['screen_name', 'text', 'link'], 'safe'],
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
        $query = Twitter::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'moment_id' => $this->moment_id,
            'tweet_id' => $this->tweet_id,
            'twitter_id' => $this->twitter_id,
            'tweeted_at' => $this->tweeted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'screen_name', $this->screen_name])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
