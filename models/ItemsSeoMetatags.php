<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 10:54
 */

namespace webivan\seomodule\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Json;

class ItemsSeoMetatags extends Model
{
    /**
     * Meta title
     *
     * @property string
     */
    public $title;

    /**
     * Meta description
     *
     * @property string
     */
    public $description;

    /**
     * @property string
     */
    public $seotext;

    /**
     * @property string
     */
    public $heading_1;

    /**
     * @property string
     */
    public $heading_2;

    /**
     * @property string
     */
    public $heading_3;

    /**
     * @property string
     */
    public $other_text;

    /**
     * @property array
     */
    public $object_text;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['title', 'description', 'seotext', 'heading_1', 'heading_2', 'heading_3', 'other_text'], 'string'],
            [['title', 'description'], 'string', 'max' => 255],
            [['heading_1', 'heading_2', 'heading_3'], 'string', 'max' => 150],
            [['seotext', 'other_text', 'object_text'], 'safe'],
            ['object_text', 'filter', 'filter' => function ($value) {
                return !empty($value) && is_array($value)
                    ? $value
                    : null;
            }],
            ['object_text', 'validateObjectText'],
        ];
    }

    /**
     * Validate object_text
     *
     * @param string $attr
     * @return bool
     */
    public function validateObjectText($attr)
    {
        $values = $this->{$attr};

        if (!is_array($values) || empty($values)) {
            return false;
        }

        $values = ItemsObjectText::compactArrayObjectText($values);

        $outputSuccess = [];

        foreach ($values as $key => $value) {
            $model = new ItemsObjectText();
            $model->setAttributes([
                'key' => $key,
                'value' => $value
            ]);

            if (!$model->validate()) {
                continue;
            }

            $outputSuccess[$model->key] = $model->value;
        }

        if (!empty($outputSuccess)) {
            $this->{$attr} = $outputSuccess;
        } else {
            $this->{$attr} = null;
        }

        return true;
    }
}