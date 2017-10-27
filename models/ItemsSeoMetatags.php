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
     * @property array
     */
    protected $removeTags = [
        'title', 'description', 'heading_1', 'heading_2', 'heading_3'
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['title', 'description', 'seotext', 'heading_1', 'heading_2', 'heading_3', 'other_text'], 'string'],
            [['title', 'description'], 'string'],
            [['heading_1', 'heading_2', 'heading_3'], 'string', 'max' => 255],
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
     * @inheritdoc
     */
    public function beforeValidate()
    {
        // remove html tags
        foreach ($this->removeTags as $tag) {
            if (property_exists($this, $tag)) {
                $this->{$tag} = strip_tags($this->{$tag});
            }
        }

        return parent::beforeValidate();
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

        $i = 0;

        foreach ($values as $key => $value) {
            $model = new ItemsObjectText();
            $model->setAttributes([
                'key' => $key,
                'value' => $value
            ]);

            if (!$model->validate()) {
                if (!empty($model->key) || !empty($model->value)) {
                    $field = empty($model->key) ? 'key' : 'value';
                    $this->addError("object_text.$i.$field", "Required field $field");
                } else {
                    continue;
                }
            }

            $outputSuccess[$model->key] = $model->value;

            $i++;
        }

        if (!empty($outputSuccess)) {
            $this->{$attr} = $outputSuccess;
        } else {
            $this->{$attr} = null;
        }

        return true;
    }
}