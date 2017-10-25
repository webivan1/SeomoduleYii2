<?php

namespace webivan\seomodule\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seotexts".
 *
 * @property int $id
 * @property string $source
 * @property int $value
 * @property int $state
 * @property string $title
 * @property string $description
 * @property string $heading_1
 * @property string $heading_2
 * @property string $heading_3
 * @property string $seotext
 * @property string $other_text
 * @property string $create_at
 */
class Seotexts extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seotexts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source', 'value'], 'required'],
            [['value', 'state'], 'integer'],
            [['seotext', 'other_text'], 'string'],
            [['create_at'], 'safe'],
            [['source', 'heading_1', 'heading_2', 'heading_3'], 'string', 'max' => 150],
            [['title', 'description'], 'string', 'max' => 255],
            [['source', 'value'], 'unique', 'targetAttribute' => ['source', 'value']],
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
            'value' => 'Value',
            'state' => 'State',
            'title' => 'Title',
            'description' => 'Description',
            'heading_1' => 'Heading 1',
            'heading_2' => 'Heading 2',
            'heading_3' => 'Heading 3',
            'seotext' => 'Seotext',
            'other_text' => 'Other Text',
            'create_at' => 'Create At',
        ];
    }
}
