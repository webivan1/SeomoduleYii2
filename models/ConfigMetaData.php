<?php

namespace webivan\seomodule\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * This is the model class for table "config_meta_data".
 *
 * @property int $id
 * @property string $source
 * @property string $connect
 * @property int $state
 * @property string $meta_template
 * @property string $run_date
 * @property string $templater
 */
class ConfigMetaData extends ActiveRecord
{
    /**
     * Default page size
     *
     * @property int
     */
    public $pageSize = 25;

    /**
     * @property int
     */
    public $count_seo;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config_meta_data';
    }

    // Scenarios
    const SCENARIO_SEARCH = 'search';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source', 'connect', 'templater'], 'string', 'on' => self::SCENARIO_SEARCH],
            [['state', 'id', 'count_seo'], 'integer', 'on' => self::SCENARIO_SEARCH],

            [['source', 'state'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['state'], 'integer', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['run_date'], 'safe', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['source', 'connect'], 'string', 'max' => 150, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['templater'], 'string', 'max' => 100, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['source', 'connect'], 'unique', 'targetAttribute' => ['source', 'connect'], 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['meta_template'], 'validateMetaDatas', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
            'connect' => 'Connect',
            'state' => 'State',
            'meta_template' => 'Meta Template',
            'run_date' => 'Run Date',
            'templater' => 'Templater',
            'count_seo' => 'Count seo texts'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'deleteWith' => [
                'class' => 'webivan\seomodule\behaviors\DeleteWithSeotexts'
            ]
        ];
    }

    /**
     * Validate meta datas
     *
     * @param string $attr
     * @return bool
     */
    public function validateMetaDatas($attr)
    {
        $value = $this->{$attr};

        if (empty($value) || !is_array($value)) {
            $this->addError($attr, 'Is not array');
            return false;
        }

        $model = new ItemsSeoMetatags();
        $model->setAttributes($value);

        if (!$model->validate()) {
            foreach ($model->getErrors() as $key => $error) {
                $this->addError("meta_template.{$key}", array_shift($error));
            }

            return false;
        }

        $this->{$attr} = Json::encode($model->getAttributes());

        return true;
    }

    /**
     * Grid datas
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = $this->find()
            ->select([
                't.*',
                'COUNT(DISTINCT(s.id)) AS count_seo'
            ])
            ->alias('t')
            ->leftJoin(Seotexts::tableName() . ' AS s', 's.source = t.source')
            ->groupBy('t.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ]
        ]);

        if ($this->hasErrors()) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere([
                't.id' => $this->id,
                't.state' => $this->state
            ])
            ->andFilterWhere(['like', 't.source', $this->source])
            ->andFilterWhere(['like', 't.connect', $this->connect])
            ->andFilterWhere(['like', 't.templater', $this->templater]);

        return $dataProvider;
    }
}
